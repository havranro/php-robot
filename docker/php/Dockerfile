FROM php:7.4-fpm-alpine
WORKDIR /app

ENV ACCEPT_EULA=Y

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
