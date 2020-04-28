<?php

namespace Deployer;

desc('Create indexes for Scout');
task('scout:init', function () {
    run('{{bin/php}} {{release_path}}/artisan elastic:create-index "App\Elasticsearch\BuildingsIndexConfigurator" -q');
    run('{{bin/php}} {{release_path}}/artisan elastic:update-mapping "App\Models\Building" -q');
    run('{{bin/php}} {{release_path}}/artisan scout:import "\App\Models\Building" -q');
    run('{{bin/php}} {{release_path}}/artisan elastic:create-index "App\Elasticsearch\ArchitectsIndexConfigurator" -q');
    run('{{bin/php}} {{release_path}}/artisan elastic:update-mapping "App\Models\Architect" -q');
    run('{{bin/php}} {{release_path}}/artisan scout:import "\App\Models\Architect" -q');
});

desc('Update indexes mapping for Scout');
task('scout:update', function () {
	set('version_number', function () {
	    return (string)time();
	});

    run('{{bin/php}} {{release_path}}/artisan elastic:update-index "App\Elasticsearch\BuildingsIndexConfigurator" -q');
    run('{{bin/php}} {{release_path}}/artisan elastic:migrate "App\Models\Building" regarch_buildings_{{version_number}} -q');
    run('{{bin/php}} {{release_path}}/artisan elastic:update-index "App\Elasticsearch\ArchitectsIndexConfigurator" -q');
    run('{{bin/php}} {{release_path}}/artisan elastic:migrate "App\Models\Architect" regarch_architects_{{version_number}} -q');
});

