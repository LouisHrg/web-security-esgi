FROM php:7.4-fpm-alpine

# Add composer from Docker image (multi-stage build)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install required extensions
RUN set -ex \
    && apk add --no-cache \
        autoconf \
        g++ \
        freetype-dev \
        make \
        icu-dev \
        postgresql-dev \
        bash \
        imagemagick-dev \
        imagemagick \
        libzip-dev \
        libpng \
        libpng-dev \
        jpegoptim \
        libjpeg-turbo-dev \
        optipng

RUN apk add nodejs npm

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

RUN docker-php-ext-configure gd \
    --with-jpeg \
    --with-freetype

RUN docker-php-ext-install \
    intl \
    opcache \
    pdo_mysql \
    mysqli \
    exif \
    zip \
    gd \
    calendar

# Install extensions from PECL
RUN pecl install \
    apcu \
    xdebug \
    imagick

RUN docker-php-ext-enable \
    apcu \
    xdebug \
    imagick

WORKDIR /home/app

COPY php.ini /usr/local/etc/php/conf.d/
