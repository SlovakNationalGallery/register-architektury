<?php

namespace App\Jobs;

use App\Models\Architect;
use App\Models\Building;
use App\Models\Image;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;

class ImportAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const BUILDING_SOURCE_ID_COLUMN = 0;
    const ARCHITECT_SOURCE_ID_COLUMN = 'source_id';
    const IMAGE_SOURCE_ID_COLUMN = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($logChannel= 'default')
    {
        $this->source = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)}; DBQ=storage/app/source-db-weinwurm.accdb; Uid=''; Pwd='';");
        $this->log = Log::channel($logChannel);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // field 'Evid_č' is not queriable directly because of its name, hence S.*
        $buildings = $this->fetchData(<<<'EOD'
            SELECT
                S.*,
                S.[Pôvodný názov diela] AS title,
                S.[Alternatívne názvy] AS title_alternatives,
                S.[Dátum spracovania] AS processed_date,
                S.[Architekt] AS architect_names,
                S.[Stavebnik] AS builder,
                S.[Stavitel] AS builder_authority,
                S.[miesto] AS location_city,
                S.[okres] AS location_district,
                S.[ulica] AS location_street,
                S.[GPS] AS location_gps,
                S.[Projekt] AS project_start_dates,
                S.[Realizácia] AS project_duration_dates,
                Roky.[Rok0] AS decade,
                Stav.[Stav] AS status,
                S.[Štýlová charkteristika] AS style,
                S.[Pole1] AS image_filename,
                S.[Literatúra:] AS bibliography,
                S.[Opis] AS description
            FROM (Stavby AS S
            LEFT JOIN Stav ON Stav.Identifikácia = S.Modalita
            ) LEFT JOIN Roky ON Roky.Identifikácia = S.[Chronológia]
        EOD);

        $this->log->info('Fetching data');
        $architects = $this->fetchData(<<<'EOD'
            SELECT
                A.Identifikácia AS source_id,
                A.Meno AS first_name,
                A.Priezvisko AS last_name,
                A.[Dátum narodenia] AS birth_date,
                MiestoNarodenia.Mesto AS birth_place,
                A.[Dátum úmrtia] AS death_date,
                MiestoUmrtia.Mesto AS death_place,
                A.Životopis AS bio,
                A.diela AS building_source_ids
            FROM (Architekti AS A
            LEFT JOIN Mesto AS MiestoNarodenia ON MiestoNarodenia.Identifikácia = A.[Miesto narodenia]
            ) LEFT JOIN Mesto AS MiestoUmrtia ON MiestoUmrtia.Identifikácia = A.[Miesto úmrtia]
        EOD);

        // field 'Identifikačné číslo' is not queriable directly because of its name, hence S.*
        $images = $this->fetchData(<<<'EOD'
            SELECT
                O.*,
                O.[Názov dokumentu] AS title,
                O.[Autor dokumentu] AS author,
                O.[Rok] AS created_date,
                O.[Zdroj originálu] AS source
            FROM Obrazky AS O
        EOD);

        DB::connection('mysql')->transaction(function() use ($architects, $buildings, $images) {
            // Delete objects no longer present in source
            Image::whereNotIn('source_id', Arr::pluck($images, self::IMAGE_SOURCE_ID_COLUMN))->delete();
            Architect::whereNotIn('source_id', Arr::pluck($architects, self::ARCHITECT_SOURCE_ID_COLUMN))->delete();
            Building::whereNotIn('source_id', Arr::pluck($buildings, self::BUILDING_SOURCE_ID_COLUMN))->delete();

            $this->log->info('Processing ' . count($buildings) . ' buildings...');
            Building::unguarded(function() use ($buildings) {
                foreach($buildings as $row) {
                    Building::updateOrCreate(
                        ['source_id' => $row[self::BUILDING_SOURCE_ID_COLUMN]],
                        [
                            'title' => $row['title'],
                            'title_alternatives' => $row['title_alternatives'],
                            'processed_date' => $row['processed_date'],
                            'architect_names' => $row['architect_names'],
                            'builder' => $row['builder'],
                            'builder_authority' => $row['builder_authority'],
                            'location_city' => $row['location_city'],
                            'location_district' => $row['location_district'],
                            'location_street' => $row['location_street'],
                            'location_gps' => $row['location_gps'],
                            'project_start_dates' => $row['project_start_dates'],
                            'project_duration_dates' => $row['project_duration_dates'],
                            'decade' => $row['decade'],
                            'status' => $row['status'],
                            'style' => $row['style'],
                            'image_filename' => $row['image_filename'],
                            'bibliography' => $row['bibliography'],
                            'description' => $row['description'],
                        ]
                    );
                }
            });

            $this->log->info('Processing ' . count($architects) . ' architects...');
            Architect::unguarded(function() use ($architects) {
                foreach($architects as $row) {
                    $building_source_ids = empty($row['building_source_ids']) ? [] : explode(';', $row['building_source_ids']);

                    Architect::updateOrCreate(
                        ['source_id' => $row[self::ARCHITECT_SOURCE_ID_COLUMN]],
                        [
                            'first_name' => $row['first_name'],
                            'last_name' => $row['last_name'],
                            'birth_date' => $row['birth_date'],
                            'birth_place' => $row['birth_place'],
                            'death_date' => $row['death_date'],
                            'death_place' => $row['death_place'],
                            'bio' => $row['bio'],
                        ]
                    )->buildings()->sync(
                        Building::whereIn('source_id', $building_source_ids)->pluck('id')
                    );
                }
            });

            $this->log->info('Processing ' . count($images) . ' images...');
            Image::unguarded(function() use ($images) {
                $BUILDING_COLUMN_INDEX = 9;

                foreach($images as $row) {
                    $building = Building::where('source_id', $row[$BUILDING_COLUMN_INDEX])->first();
                    if (!$building) {
                        $this->log->warning('Skipping image ' . $row[self::IMAGE_SOURCE_ID_COLUMN] . ' referencing an unknown building');
                        continue;
                    }

                    Image::updateOrCreate(
                        ['source_id' => $row[self::IMAGE_SOURCE_ID_COLUMN]],
                        [
                            'title' => $row['title'],
                            'author' => $row['author'],
                            'created_date' => $row['created_date'],
                            'source' => $row['source'],
                            'building_id' => $building->id,
                        ]
                    );
                }
            });
        });

        $this->log->info('🚀 Done');
    }

    private function fetchData($query)
    {
        $query = mb_convert_encoding($query, 'Windows-1252', 'UTF-8');

        $statement = $this->source->query($query);
        if (!$statement) dd($this->source->errorInfo());

        return array_map(function($row) {
            return array_map(function($value) {
                if (empty($value)) return $value;
                return mb_convert_encoding($value, 'UTF-8', 'Windows-1252');
            }, $row);
        }, $statement->fetchAll());
    }
}
