<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ElasticSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'regarch:elastic:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create index, update mapping and import data for all searchable models.';

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
        $this->info('Processing ...');

        // setup buildings
        $this->call('elastic:create-index', [
            'index-configurator' => 'App\Elasticsearch\BuildingsIndexConfigurator'
        ]);
        $this->call('elastic:update-mapping', [
            'model' => '\App\Models\Building'
        ]);
        $this->call('scout:import', [
            'model' => '\App\Models\Building'
        ]);

        // setup architects
        $this->call('elastic:create-index', [
            'index-configurator' => 'App\Elasticsearch\ArchitectsIndexConfigurator'
        ]);
        $this->call('elastic:update-mapping', [
            'model' => '\App\Models\Architect'
        ]);
        $this->call('scout:import', [
            'model' => '\App\Models\Architect'
        ]);

        $this->info('🚀 Done');
    }
}
