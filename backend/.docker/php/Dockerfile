#
#--------------------------------------------------------------------------
# Image Setup
#--------------------------------------------------------------------------
#
FROM php:7.2-fpm-alpine

RUN apk update \
    && apk add  --no-cache git mysql-client curl libmcrypt libmcrypt-dev openssh-client icu-dev \
    libxml2-dev freetype-dev libpng-dev libjpeg-turbo-dev g++ make autoconf bash

#
#--------------------------------------------------------------------------
# Optional Software's Installation
#--------------------------------------------------------------------------
#
###########################################################################
# xDebug:
###########################################################################

ARG INSTALL_XDEBUG=false

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    pecl install xdebug; \
    docker-php-ext-enable xdebug \
;fi

#RUN pecl install xdebug; \
#    docker-php-ext-enable xdebug

# Copy xdebug configuration for remote debugging
COPY .docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

###########################################################################
# General Dependencies:
###########################################################################
RUN docker-php-ext-install pdo_mysql soap intl zip mbstring bcmath tokenizer
###########################################################################
# Opcache:
###########################################################################
ARG INSTALL_OPCACHE=false

RUN if [ ${INSTALL_OPCACHE} = true ]; then \
    docker-php-ext-install opcache \
;fi

# Copy opcache configration
COPY .docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

###########################################################################
# Install composer:
###########################################################################
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#
COPY .docker/php/laravel.ini /usr/local/etc/php/conf.d

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000
