FROM php:7.2-fpm

ENV ACCEPT_EULA=Y

# Microsoft SQL Server Prerequisites
RUN apt-get update \
    && apt-get install -y gnupg wget \
    && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/9/prod.list \
        > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get install -y --no-install-recommends \
        locales \
        apt-transport-https \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
    && locale-gen \
    && apt-get update \
    && apt-get -y --no-install-recommends install msodbcsql17 unixodbc-dev mssql-tools \
        curl libxml2-dev libssl-dev zlib1g-dev apt-transport-https apt-utils lsb-release ca-certificates \
        libpng-dev libturbojpeg0 libjpeg-dev cron vim \
    && wget https://getcomposer.org/download/1.6.3/composer.phar -O /usr/local/bin/composer \
    && chmod a+rx /usr/local/bin/composer

RUN docker-php-ext-configure gd --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install mbstring pdo pdo_mysql iconv mbstring phar zip gd xml \
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv
RUN service cron start