<?php

namespace Deployer;

require 'recipe/symfony.php';

// Project repository
set('repository', 'https://github.com/ivanstan/tle-api');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);
set('bin_dir', 'bin');
set('http_user', 'glutenfr');
set('writable_mode', 'chmod');

// Shared files/dirs between deploys 
add(
    'shared_files',
    [
        '.env'
    ]
);
add(
    'shared_dirs',
    [
        'var'
    ]
);

// Writable dirs by web server 
add('writable_dirs', []);

// Hosts

host('data.ivanstanojevic.me')
    ->user('glutenfr')
    ->port(2233)
    ->stage('production')
    ->set('deploy_path', '~/projects/tle.ivanstanojevic.me');

// Tasks

task(
    'deploy',
    [
        'deploy:info',
        'deploy:prepare',
        'deploy:lock',
        'deploy:release',
        'deploy:update_code',
        'deploy:clear_paths',
        'deploy:create_cache_dir',
        'deploy:shared',
        'deploy:assets',
        'deploy:vendors',
        'deploy:cache:clear',
        'deploy:cache:warmup',
        'deploy:writable',
        'database:migrate',
        'deploy:symlink',
        'deploy:unlock',
        'cleanup',
    ]
);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');

