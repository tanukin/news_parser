FROM php:7.4-cli

RUN apt-get update && apt-get install -y libzip-dev \
    && docker-php-ext-install zip

RUN docker-php-ext-install pdo_mysql pcntl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1

WORKDIR /var/www
