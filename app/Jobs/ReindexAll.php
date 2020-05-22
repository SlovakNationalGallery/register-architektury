<?php

namespace App\Jobs;

use App\Models\Architect;
use App\Models\Building;
use Deployer\Component\Version\Builder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        // TODO do this with zero downtime
        Building::removeAllFromSearch();
        Architect::removeAllFromSearch();

        Building::makeAllSearchable();
        Architect::makeAllSearchable();
    }
}
