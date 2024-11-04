FROM php:8.3-fpm

ENV APP_HOME /var/www/html
ARG HOST_UID=1000
ARG HOST_GID=1000
ENV USERNAME=www-data

COPY php.ini /usr/local/etc/php/
COPY docker.conf /usr/local/etc/php-fpm.d/docker.conf
COPY .bashrc /root/

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# create document root, fix permissions for www-data user and change owner to www-data
RUN mkdir -p /home/$USERNAME && chown $USERNAME:$USERNAME /home/$USERNAME \
    && usermod -o -u $HOST_UID $USERNAME -d /home/$USERNAME \
    && groupmod -o -g $HOST_GID $USERNAME \
    && chown -R ${USERNAME}:${USERNAME} $APP_HOME

RUN apt-get update \
  && apt-get install -y wget git curl ca-certificates \
  zip unzip supervisor sqlite3 libcap2-bin libpng-dev dnsutils librsvg2-bin \
  fswatch ffmpeg libjpeg62-turbo-dev libmagickwand-dev --no-install-recommends \
  libxml2-dev libzip-dev nano

# Install PHP extensions zip, exif, bcmath
RUN docker-php-ext-install zip exif pcntl bcmath -j$(nproc)

# GD
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd
# Intl
RUN apt-get install -y libicu-dev \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl

# PHP pdo_mysql extention
RUN docker-php-ext-install pdo_mysql

# PHP Postgresql extention
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# PECL update
RUN pecl channel-update pecl.php.net

# Pcov
RUN pecl install pcov && docker-php-ext-enable pcov

# Imagick
RUN pecl install imagick \
	&& docker-php-ext-enable imagick
# Soap
RUN docker-php-ext-install soap

# Msgpack
RUN pecl install msgpack && docker-php-ext-enable msgpack

# Redis and enable
RUN pecl install redis && docker-php-ext-enable redis

# Igbinary
RUN pecl install igbinary && docker-php-ext-enable igbinary
# Php-imap
RUN apt-get install -y \
        libc-client-dev libkrb5-dev && \
    rm -r /var/lib/apt/lists/*
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl && \
    docker-php-ext-install -j$(nproc) imap

# Xdebug
# RUN pecl install xdebug \
# && docker-php-ext-enable xdebug \
# && echo ";zend_extension=xdebug" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Node.js, NPM, Yarn
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs
RUN npm install npm@latest -g
RUN npm install yarn -g
RUN npm install @soketi/soketi -g

# Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin
RUN composer config --global process-timeout 3600
RUN composer global require "laravel/installer"

# Final
WORKDIR /var/www/html

USER root
