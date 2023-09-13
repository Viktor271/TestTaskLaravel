FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    net-tools \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html/storage && chmod -R 755 /var/www/html/storage

RUN composer update
RUN composer install --no-interaction

RUN composer require laravel/ui
RUN composer require jeroennoten/laravel-adminlte
RUN php artisan adminlte:install --force

RUN apt-get update && apt-get install -y default-mysql-client

RUN apt-get update && apt-get install -y vim
RUN apt-get update && apt-get -y install cron

EXPOSE ${EXPOSE_PORT}
