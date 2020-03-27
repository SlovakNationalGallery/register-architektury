<?php

namespace App\Jobs;

use App\Models\Architect;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;

class ImportAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->source = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)}; DBQ=storage/app/source-db.accdb; Uid=''; Pwd='';");
        $this->log = Log::channel('stderr');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $architects = $this->fetchData(<<<'EOD'
            SELECT
                A.Identifikácia AS source_id,
                A.Meno AS first_name,
                A.Priezvisko AS last_name,
                A.[Dátum narodenia] AS birth_date,
                MiestoNarodenia.Mesto AS birth_place,
                A.[Dátum úmrtia] AS death_date,
                MiestoUmrtia.Mesto AS death_place,
                A.Životopis AS bio
            FROM (Architekti AS A
            LEFT JOIN Mesto AS MiestoNarodenia ON MiestoNarodenia.Identifikácia = A.[Miesto narodenia]
            ) LEFT JOIN Mesto AS MiestoUmrtia ON MiestoUmrtia.Identifikácia = A.[Miesto úmrtia]
        EOD);

        DB::transaction(function() use ($architects) {
            $processedCount = 0;

            Architect::truncate();
            foreach($architects as $row) {
                Architect::updateOrCreate(
                    ['source_id' => $row['source_id']],
                    [
                        'first_name' => $row['first_name'],
                        'last_name' => $row['last_name'],
                        'birth_date' => $row['birth_date'],
                        'birth_place' => $row['birth_place'],
                        'death_date' => $row['death_date'],
                        'death_place' => $row['death_place'],
                        'bio' => $row['bio'],
                    ]
                );
                $processedCount++;
            }
            $this->log->info("Processed $processedCount architect records.");
        });

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
