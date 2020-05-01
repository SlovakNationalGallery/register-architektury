<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ScoutElastic\Facades\ElasticClient;

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
    protected $description = 'Create or update index mapping for all searchable models';

    protected $indexConfigurators = [
        '\App\Models\Building' => 'App\Elasticsearch\BuildingsIndexConfigurator',
        '\App\Models\Architect' => 'App\Elasticsearch\ArchitectsIndexConfigurator',
    ];


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

        foreach ($this->indexConfigurators as $model => $indexConfigurator) {
            $index_name = $this->getIndexName($indexConfigurator);

            $already_exists = ElasticClient::indices()->exists([
                'index' => $index_name
            ]);

            if ($already_exists) {
                // migrate
                $this->comment('Index [' . $index_name . '] already exists. Will be updated.');

                $this->call('elastic:update-index', [
                    'index-configurator' => $indexConfigurator,
                ]);
                $this->call('elastic:migrate', [
                    'model' => $model,
                    'target-index' => $index_name.$version_number
                ]);

            } else {
                // create
                $this->comment('Index [' . $index_name . '] does not exist yet. Will be created.');

                $this->call('elastic:create-index', [
                    'index-configurator' => $indexConfigurator
                ]);
                $this->call('elastic:update-mapping', [
                    'model' => $model
                ]);
                $this->call('scout:import', [
                    'model' => $model
                ]);
            }

        }

        $this->info('🚀 Done');
    }

    private function getIndexName($indexConfigurator)
    {
        $indexConfiguratorClass = new $indexConfigurator;
        return $indexConfiguratorClass->getName();
    }
}
