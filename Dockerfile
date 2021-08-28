FROM php:7.3-fpm

RUN apt-get update \
    && apt-get -y install zip libgmp-dev libmcrypt-dev

WORKDIR /var/www

COPY . /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --optimize-autoloader --no-dev --no-scripts
RUN php artisan config:cache
RUN php artisan route:cache

RUN chown -R www-data:www-data \
    /var/www/bootstrap/cache \
    /var/www/storage

RUN pecl install mcrypt-1.0.3 \
    && docker-php-ext-install pdo_mysql gmp \
    && docker-php-ext-enable mcrypt
