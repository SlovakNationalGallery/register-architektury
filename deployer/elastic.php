<?php

namespace Deployer;

desc('Update indexes mapping for Scout');
task('elastic:migrate', function () {
    run('{{bin/php}} {{release_path}}/artisan regarch:elastic:migrate -q');
});

