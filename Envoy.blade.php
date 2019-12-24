@servers(['web' => 'laravel-deployer@whitefallen.de'])

@setup
    $repository = 'git@gitlab.com:der-eine-aegyptische-gott/laravel-backend-for-cms.git';
    $releases_dir = '/var/www/laravel-cms/releases';
    $app_dir = '/var/www/laravel-cms';
    $release = date('YmdHis');
    $new_release_dir = $releases_dir .'/'. $release;
@endsetup


@story('deploy')
    clone_repository
    run_composer
    update_symlinks
@endstory

@task('clone_repository')
    echo 'Cloning repository'
    [ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
    git clone --depth 1 {{ $repository }} {{ $new_release_dir }}
    cd {{ $new_release_dir }}
    git reset --hard {{ $commit }}
    touch database/database.sqlite
    chmod -R 775 database
    chgrp -R www-data database
@endtask

@task('run_composer')
    echo "Starting deployment ({{ $release }})"
    cd {{ $new_release_dir }}
    composer install --prefer-dist --no-scripts -q -o
    cp .env.example .env
    php artisan key:generate
    php artisan migrate:refresh --seed
@endtask

@task('update_symlinks')
    echo "Linking storage directory"
    rm -rf {{ $new_release_dir }}/storage
    ln -nfs {{ $app_dir }}/storage {{ $new_release_dir }}/storage

    echo 'Linking .env file'
    ln -nfs {{ $app_dir }}/.env {{ $new_release_dir }}/.env

    echo 'Linking current release'
    ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current
@endtask

