# Set the base image for subsequent instructions
FROM php:7.3

# Update packages
RUN apt-get update

# Install PHP and composer dependencies
RUN apt-get install -qq git curl libmcrypt-dev libjpeg-dev libpng-dev libfreetype6-dev libbz2-dev libzip-dev zlib1g-dev

# Clear out the local repository of retrieved package files
RUN apt-get clean

# Install Xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Install needed extensions
# Here you can install any other extension that you need during the test and deployment process
RUN docker-php-ext-install mcrypt pdo_mysql zip

# Install Composer
RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel Envoy
RUN composer global require "laravel/envoy"
