<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ElasticMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'regarch:elastic:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update index mapping for all searchable models.';

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
        $version_number = (string)time();

        $this->info('Processing ...');

        // migrate buildings
        $this->call('elastic:update-index', [
            'index-configurator' => 'App\Elasticsearch\BuildingsIndexConfigurator',
        ]);
        $this->call('elastic:migrate', [
            'model' => '\App\Models\Building',
            'target-index' => 'regarch_buildings_'.$version_number
        ]);

        // migrate architects
        $this->call('elastic:update-index', [
            'index-configurator' => 'App\Elasticsearch\ArchitectsIndexConfigurator',
        ]);
        $this->call('elastic:migrate', [
            'model' => '\App\Models\Architect',
            'target-index' => 'regarch_architects_'.$version_number
        ]);

        $this->info('🚀 Done');
    }
}
