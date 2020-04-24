<?php

namespace Deployer;

desc('Install Backpack dependencies');
task('backpack:install', function () {
    run('{{bin/php}} {{release_path}}/artisan backpack:install -q');
    run('{{bin/php}} {{release_path}}/artisan elfinder:publish');
})->once();
