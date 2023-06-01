######################################
FROM php:8.1-fpm-alpine3.17 AS base-php

# Alpine sources
RUN printf "https://mirror.arvancloud.ir/alpine/v3.17/main\nhttps://mirror.arvancloud.ir/alpine/v3.17/community" > /etc/apk/repositories

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql mbstring exif pcntl bcmath sockets timezonedb

######################################
FROM base-php AS base-php-redis

# Install redis
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions redis-5.3.7

######################################
FROM base-php-redis AS base-php-redis-composer

# install git
RUN apk add git

# Install composer
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions @composer-2.5.5

######################################
FROM base-php-redis-composer AS laravel-app

ARG WORKDIR
WORKDIR $WORKDIR

# Enable composer plugins 
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"

# Copy the composer.json and composer.lock files
COPY composer.* .

# Install dependencies
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction

# Copy codes and dump the autoloader
COPY ./ /tmp/app
RUN chgrp -R 0 /tmp/app && \
    chmod -R g=u /tmp/app && \
    cp -a /tmp/app/. . && \
    rm -rf /tmp/app && \
    composer dump-autoload --classmap-authoritative --no-dev

# laravel permission
RUN chmod -R 777 storage/ bootstrap/

FROM laravel-app AS maltina-app

RUN php artisan route:cache \
    && php artisan config:cache \
    && php artisan view:cache

FROM laravel-app AS queue

ENTRYPOINT ["php", "artisan", "queue:work"]

FROM laravel-app AS scheduler

ENTRYPOINT ["php", "artisan", "schedule:work"]