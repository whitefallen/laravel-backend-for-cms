#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerenv ]] && exit 0

set -xe

# Install git (the php image doesn't have it) which is required by composer
apt-get update -yqq
apt-get install git -yqq zlib1g-dev libzip-dev

# Install Xdebug
pecl install xdebug
docker-php-ext-enable xdebug

# Install mysql driver
# Here you can install any other extension that you need
docker-php-ext-install pdo_mysql zip

# Install composer
curl -sS https://getcomposer.org/installer | php

# Install all project dependencies
php composer.phar install --no-progress
