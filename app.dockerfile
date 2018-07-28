FROM php:7.2.8-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev \
    mysql-client libmagickwand-dev --no-install-recommends \
    && pecl install imagick-beta mcrypt-1.0.1 \
    && docker-php-ext-enable imagick mcrypt \
    && docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | \
  php -- --install-dir=/usr/local/bin --filename=composer
