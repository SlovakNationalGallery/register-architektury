<?php

namespace Deployer;

desc('Update indexes mapping for Scout');
task('elastic:migrate', function () {
    run('{{bin/php}} {{release_path}}/artisan regarch:elastic:migrate -q');
});

desc('Terminate horizon as user www-data');
task('sudo:artisan:horizon:terminate', function () {
    run('sudo -u www-data {{bin/php}} {{release_path}}/artisan horizon:terminate');
});
