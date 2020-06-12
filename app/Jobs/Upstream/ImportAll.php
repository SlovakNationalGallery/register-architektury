<?php

namespace App\Jobs\Upstream;

use App\Jobs\ReindexAll;
use App\Jobs\ProcessImage;
use App\Models\Architect;
use App\Models\Building;
use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImportAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $logChannel;
    protected $db;
    protected $log;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($logChannel= 'default')
    {
        $this->logChannel = $logChannel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->db = DB::connection('upstream');
        $this->log = Log::channel($this->logChannel);

        $this->log->info('Fetching data');
        $buildings = $this->db->table('Stavby')
            ->leftJoin('Stav', 'Stav.Identifikácia', '=', 'Stavby.Modalita')
            ->leftJoin('Roky', 'Roky.Identifikácia', '=', 'Stavby.Chronológia')
            ->leftJoin('Funkcia', 'Funkcia.Identifikácia', '=', 'Stavby.Súčasná funkcia')
            ->select(
                'Evid_č AS source_id',
                'Pôvodný názov diela AS title',
                'Alternatívne názvy AS title_alternatives',
                'Dátum spracovania AS processed_date',
                'Architekt AS architect_names',
                'Stavebnik AS builder',
                'Stavitel AS builder_authority',
                'miesto AS location_city',
                'okres AS location_district',
                'ulica AS location_street',
                'GPS AS location_gps',
                'Projekt AS project_start_dates',
                'Realizácia AS project_duration_dates',
                'Funkcia.Pole1 AS current_function',
                'Roky.Rok0 AS decade',
                'Stav.Stav AS status',
                'Štýlová charkteristika AS style',
                'Stavby.Pole1 AS image_filename',
                'Literatúra: AS bibliography',
                'Opis AS description'
            )->get();

        $architects = $this->db->table('Architekti')
            ->leftJoin('Mesto AS MiestoNarodenia', 'MiestoNarodenia.Identifikácia', '=', 'Architekti.Miesto narodenia')
            ->leftJoin('Mesto AS MiestoUmrtia', 'MiestoUmrtia.Identifikácia', '=', 'Architekti.Miesto úmrtia')
            ->select(
               'Architekti.Identifikácia AS source_id',
               'Meno AS first_name',
               'Priezvisko AS last_name',
               'Dátum narodenia AS birth_date',
               'MiestoNarodenia.Mesto AS birth_place',
               'Dátum úmrtia AS death_date',
               'MiestoUmrtia.Mesto AS death_place',
               'Životopis AS bio',
               'diela AS building_source_ids'
            )->get();

        $images = $this->db->table('Obrazky')
            ->select(
                'Identifikačné číslo AS source_id',
                'Evidenčné číslo objektu AS building_source_id',
                'Názov dokumentu AS title',
                'Autor dokumentu AS author',
                'Rok AS created_date',
                'Zdroj originálu AS source',
                'Cesta AS path'
            )
            ->where('Cesta', '!=', '')
            ->whereNotNull('Cesta')
            ->get();

        $this->inTransaction(function() use ($architects, $buildings, $images) {
            // Delete objects no longer present in source
            Image::whereNotIn('source_id', Arr::pluck($images, 'source_id'))->delete();
            Architect::whereNotIn('source_id', Arr::pluck($architects, 'source_id'))->delete();
            Building::whereNotIn('source_id', Arr::pluck($buildings, 'source_id'))->delete();

            $this->log->info('Processing ' . count($buildings) . ' buildings...');
            Building::unguarded(function() use ($buildings) {
                foreach($buildings as $row) {
                    $row = $this->trimRow($row);

                    $gpsLocation = $this->parseLocationGPS($row->location_gps);
                    $row->location_gps = $gpsLocation ? "$gpsLocation->lat,$gpsLocation->lon" : null;

                    $row->project_start_dates = $this->sanitizeDates($row->project_start_dates);

                    $row->project_duration_dates = $this->sanitizeDates($row->project_duration_dates);

                    Building::updateOrCreate(
                        ['source_id' => $row->source_id],
                        (array) $row
                    );
                }
            });

            $this->log->info('Processing ' . count($architects) . ' architects...');
            Architect::unguarded(function() use ($architects) {
                foreach($architects as $row) {
                    $building_source_ids = empty($row->building_source_ids) ? [] : explode(';', $row->building_source_ids);

                    Architect::updateOrCreate(
                        ['source_id' => $row->source_id],
                        Arr::except((array) $row, ['building_source_ids'])
                    )->buildings()->sync(
                        Building::whereIn('source_id', $building_source_ids)->pluck('id')
                    );
                }
            });

            $this->log->info('Processing ' . count($images) . ' images...');
            Image::unguarded(function() use ($images, $buildings) {
                foreach($images as $row) {
                    $building = Building::firstWhere('source_id', $row->building_source_id);

                    if (empty($building)) {
                        $this->log->warning('Skipping image ' . $row->source_id . ' referencing an unknown building');
                        continue;
                    }
                    $row->building_id = $building->id;

                    Image::updateOrCreate(
                        ['source_id' => $row->source_id],
                        Arr::except((array) $row, ['building_source_id']),
                    );
                }
            });
        });

        $this->log->info('Enqueing image processing');
        Image::unprocessed()->get()->map(function ($image) {
            ProcessImage::dispatch($image);
        });

        $this->log->info('Enqueing search re-index');
        ReindexAll::dispatch();

        $this->log->info('🚀 Done');
    }

    private function parseLocationGPS($str)
    {
        $str = trim($str);

        // convert Degree, Minutes, Seconds (DMS) to decimal if necessary
        if (strpos($str, '°') !== false) {
            $parts = preg_split("/[^\d\w.]+/", $str);
            $lat = $this->DMStoDD($parts[0], $parts[1], $parts[2], $parts[3]);
            $lon = $this->DMStoDD($parts[4], $parts[5], $parts[6], $parts[7]);
            return (object) compact('lat', 'lon');
        }

        $parts = explode(',', $str);
        if (is_numeric($parts[0]) && is_numeric($parts[1])) return (object) [
            'lat' => (float) $parts[0],
            'lon' => (float) $parts[1],
        ];
    }

    private function DMStoDD($degrees, $minutes, $seconds, $direction)
    {
        $dd = $degrees + $minutes/60 + $seconds/(60*60);

        if ($direction == "S" || $direction == "W") {
            $dd = $dd * -1;
        }
        return $dd;
    }

    private function inTransaction($callback) {
        Building::withoutSyncingToSearch(function () use ($callback) {
            Architect::withoutSyncingToSearch(function () use ($callback) {
                DB::connection('mysql')->transaction(function () use ($callback) {
                    return $callback();
                });
            });
        });
    }

    private function trimRow($row) {
        return (object) array_map(function ($value) {
            if (empty($value)) return $value;
            return trim($value);
        }, (array) $row);
    }

    private function sanitizeDates($dates) {
        return (empty($dates)) ? null : (string)Str::of($dates)->replace('–', '-')->replace(' ;', ';');
    }
}
