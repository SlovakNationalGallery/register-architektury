<?php

namespace App\Jobs;

use App\Models\Architect;
use App\Models\Building;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class ReindexAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //TODO Do this without downtime
        Artisan::call('scout:flush', ['model' => Building::class]);
        Artisan::call('scout:import', ['model' => Building::class]);

        Artisan::call('scout:flush', ['model' => Architect::class]);
        Artisan::call('scout:import', ['model' => Architect::class]);
    }
}
