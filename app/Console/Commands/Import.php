<?php

namespace App\Console\Commands;

use App\Jobs\Upstream\ImportAll as ImportAllJob;
use Illuminate\Console\Command;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'regarch:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs import from upstream database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ImportAllJob::dispatchNow('stderr');
    }
}
