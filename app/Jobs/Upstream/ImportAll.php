<?php

namespace App\Jobs\Upstream;

use App\Jobs\ProcessArchitectImage;
use App\Jobs\ProcessBuildingImage;
use App\Models\Architect;
use App\Models\Building;
use App\Models\BuildingDate;
use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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
            ->leftJoin('Obdobie', 'Obdobie.Pole1', '=', 'Stavby.Štýlová charkteristika')
            ->select(
                'Evid_č AS source_id',
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
                'Roky.Rok0 AS decade',
                'Stavby.Pole1 AS image_filename',
                'Literatúra: AS bibliography',
                'SketchUp model AS sketchup_model_url',
            )
            ->selectRaw("JSON_OBJECT('sk', `Pôvodný názov diela`, 'en', `Názov ENG`) as title")
            ->selectRaw("JSON_OBJECT('sk', Funkcia.Pole1, 'en', Funkcia.Pole2) as current_function")
            ->selectRaw("JSON_OBJECT('sk', Obdobie.Pole1, 'en', Obdobie.Pole2) as style")
            ->selectRaw("JSON_OBJECT('sk', Stav.Stav, 'en', Stav.`Stav ENG`) as status")
            ->selectRaw("JSON_OBJECT('sk', Opis, 'en', `Opis ENG`) as description")
            ->where('Web', 1)
            ->get();

        $building_dates = $this->db->table('RokyStavby')
            ->leftJoin('RokyStavbyKategorie', 'RokyStavby.Kategoria', '=', 'RokyStavbyKategorie.ID')
            ->join('Stavby', fn ($join) => $join
                ->on('Stavby.Evid_č', '=', 'RokyStavby.StavbaID')
                ->where('Stavby.Web', 1)
            )
            ->select(
                'RokyStavby.ID AS source_id',
                'StavbaID AS building_source_id',
                'Zaciatok AS from',
                'Koniec AS to',
            )
            ->selectRaw("JSON_OBJECT('sk', RokyStavbyKategorie.Nazov, 'en', RokyStavbyKategorie.Nazov_EN) as category")
            ->selectRaw("JSON_OBJECT('sk', Poznamka, 'en', Poznamka_EN) as note")
            ->get();

        $architects = $this->db->table('Architekti')
            ->leftJoin('Mesto AS MiestoNarodenia', 'MiestoNarodenia.Identifikácia', '=', 'Architekti.Miesto narodenia')
            ->leftJoin('Rok AS RokNarodenia', 'RokNarodenia.Identifikácia', '=', 'Architekti.Rok narodenia')
            ->leftJoin('Mesto AS MiestoUmrtia', 'MiestoUmrtia.Identifikácia', '=', 'Architekti.Miesto úmrtia')
            ->leftJoin('Rok AS RokUmrtia', 'RokUmrtia.Identifikácia', '=', 'Architekti.Rok úmrtia')
            ->select(
               'Architekti.Identifikácia AS source_id',
               'Meno AS first_name',
               'Priezvisko AS last_name',
               'Dátum narodenia AS birth_date',
               'RokNarodenia.Rok AS birth_year',
               'MiestoNarodenia.Mesto AS birth_place',
               'Dátum úmrtia AS death_date',
               'RokUmrtia.Rok AS death_year',
               'MiestoUmrtia.Mesto AS death_place',
               'Životopis AS bio',
               'diela AS building_source_ids',
               'Obrazok AS image_path',
            )
            ->where('Web', 1)
            ->get();

        $images = $this->db->table('Obrazky')
            ->join('Stavby', fn ($join) => $join
                ->on('Stavby.Evid_č', '=', 'Obrazky.Evidenčné číslo objektu')
                ->where('Stavby.Web', 1)
            )
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

        $this->inTransaction(function() use ($architects, $buildings, $building_dates, $images) {
            // Delete objects no longer present in source
            Image::whereNotIn('source_id', Arr::pluck($images, 'source_id'))->delete();
            BuildingDate::whereNotIn('source_id', Arr::pluck($building_dates, 'source_id'))->delete();

            $architectsToDelete = Architect::whereNotIn('source_id', Arr::pluck($architects, 'source_id'));
            $architectsToDelete->unsearchable(); // Scout does not observe deletions in transactions, so remove from index manually
            $architectsToDelete->delete();

            $buildingsToDelete = Building::whereNotIn('source_id', Arr::pluck($buildings, 'source_id'));
            $buildingsToDelete->unsearchable();
            $buildingsToDelete->delete();

            $this->log->info('Processing ' . count($buildings) . ' buildings...');
            Building::unguarded(function() use ($buildings) {
                foreach($buildings as $row) {
                    try {
                        DB::connection('mysql')->transaction(function () use ($row) {
                            $row = $this->trimRow($row);

                            $gpsLocation = $this->parseLocationGPS($row->location_gps);
                            $row->location_gps = $gpsLocation ? "$gpsLocation->lat,$gpsLocation->lon" : null;
                            $row->title = (array)json_decode($row->title);
                            $row->current_function = (array)json_decode($row->current_function);
                            $row->style = (array)json_decode($row->style);
                            $row->status = (array)json_decode($row->status);
                            $row->description = (array)json_decode($row->description);

                            Building::updateOrCreate(
                                ['source_id' => $row->source_id],
                                (array)$row
                            );
                        });
                    } catch (Throwable $e) {
                        $this->log->error('Error processing building', ['source_id' => $row->source_id, 'error' => $e->getMessage()]);
                    }
                }
            });

            $this->log->info('Processing ' . count($building_dates) . ' buildings dates...');
            BuildingDate::unguarded(function() use ($building_dates) {
                $buildings = Building::whereIn('source_id', Arr::pluck($building_dates, 'building_source_id'))->get();
                foreach($building_dates as $row) {
                    try {
                        DB::connection('mysql')->transaction(function () use ($row, $buildings) {
                            $building = $buildings->firstWhere('source_id', $row->building_source_id);
                            BuildingDate::updateOrCreate(
                                ['source_id' => $row->source_id],
                                [
                                    'source_id' => $row->source_id,
                                    'building_id' => $building->id,
                                    'from' => $row->from,
                                    'to' => $row->to,
                                    'category' => (array)json_decode($row->category),
                                    'note' => (array)json_decode($row->note),
                                ]
                            );
                        });
                    } catch (Throwable $e) {
                        $this->log->error('Error processing building date', ['source_id' => $row->source_id, 'error' => $e->getMessage()]);
                    }
                }
            });

            $this->log->info('Processing ' . count($architects) . ' architects...');
            Architect::unguarded(function() use ($architects) {
                foreach($architects as $row) {
                    try {
                        DB::connection('mysql')->transaction(function () use ($row) {
                            $building_source_ids = empty($row->building_source_ids) ? [] : explode(';', $row->building_source_ids);

                            Architect::updateOrCreate(
                                ['source_id' => $row->source_id],
                                Arr::except((array) $row, ['building_source_ids'])
                            )->buildings()->sync(
                                Building::whereIn('source_id', $building_source_ids)->pluck('id')
                            );
                        });
                    } catch (Throwable $e) {
                        $this->log->error('Error processing architect', ['source_id' => $row->source_id, 'error' => $e->getMessage()]);
                    }
                }
            });

            $this->log->info('Processing ' . count($images) . ' images...');
            Image::unguarded(function() use ($images) {
                foreach($images as $row) {
                    try {
                        DB::connection('mysql')->transaction(function () use ($row) {
                            $building = Building::firstWhere('source_id', $row->building_source_id);

                            $row->building_id = $building->id;

                            Image::updateOrCreate(
                                ['source_id' => $row->source_id],
                                Arr::except((array) $row, ['building_source_id']),
                            );
                        });
                    } catch (Throwable $e) {
                        $this->log->error('Error processing image', ['source_id' => $row->source_id, 'error' => $e->getMessage()]);
                    }
                }
            });
        },
        // Finally (whether successful or not)
        function() {
            $this->log->info('Enqueing search re-index');
            Building::all()->searchable();
            Architect::all()->searchable();
        });

        $this->log->info('Enqueing image processing');
        Image::unprocessed()->get()->map(function ($image) {
            ProcessBuildingImage::dispatch($image);
        });
        Architect::withUnprocessedImage()->get()->map(function ($architect) {
            ProcessArchitectImage::dispatch($architect);
        });

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

    private function inTransaction($callback, $finallyCallback) {
        try {
            Building::withoutSyncingToSearch(function () use ($callback) {
                Architect::withoutSyncingToSearch(function () use ($callback) {
                    DB::connection('mysql')->transaction(function () use ($callback) {
                        return $callback();
                    });
                });
            });
        } finally {
            $finallyCallback();
        }
    }

    private function trimRow($row) {
        return (object) array_map(function ($value) {
            if (empty($value)) return $value;
            return trim($value);
        }, (array) $row);
    }
}
