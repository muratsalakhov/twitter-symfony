FROM php:8.3.0-fpm-alpine

# Install packages
RUN apk add --no-cache  \
    curl  \
    git  \
    build-base  \
    zlib-dev  \
    oniguruma-dev  \
    autoconf  \
    bash \
    linux-headers \
    postgresql-dev

# Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY ./docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# PostgreSQL
RUN docker-php-ext-install pdo_pgsql pgsql

# Configure non-root user.
ARG PUID=1000
ARG PGID=1000
RUN apk --no-cache add shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Source code
COPY ./ /var/www
WORKDIR /var/www

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD php-fpm

EXPOSE 9000

USER www-data