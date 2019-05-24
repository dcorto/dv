ARG PHP_VERSION=7.3

FROM php:${PHP_VERSION}-fpm-stretch as base

# override default WORKDIR
WORKDIR /var/www

################################################################################

FROM base as devel

RUN buildDeps=" \
    gcc g++ libxslt1-dev libxml2-dev libmcrypt-dev libtidy-dev libfreetype6-dev \
    libjpeg62-turbo-dev libpng-dev libbz2-dev zlib1g-dev libzip-dev libicu-dev icu-doc \
    libpcre3-dev \
    " \
    && apt-get update && apt-get upgrade -y \
    && apt-get install -y $buildDeps --no-install-recommends \
    && apt-get purge -y \
    && rm -rf /tmp/*

RUN pecl install xdebug-2.7.2 \
    && pecl install mongodb \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install -j$(nproc) intl zip

# set php.ini
COPY php.ini $PHP_INI_DIR/php.ini

# set fpm pool config
COPY php-fpm.d/www.conf $PHP_INI_DIR/../php-fpm.d/www.conf

# composer
RUN apt-get update \
    && apt-get install -y git zip unzip \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

ENV user deploybot

RUN useradd -m -d /home/${user} ${user} \
 && chown -R ${user} /home/${user}

USER ${user}