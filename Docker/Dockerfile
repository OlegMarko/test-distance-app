FROM php:7.1.3-apache
USER root
WORKDIR /var/www/html
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys AA8E81B4331F7F50
RUN apt-get update && apt-get install -y \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        zip \
        curl \
        unzip \
        git \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-ext-install soap \
    && docker-php-ext-install pcntl \
    && docker-php-source delete

COPY apache/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY apache/ssl/ssl.crt /etc/apache2/ssl/ssl.crt
COPY apache/ssl/ssl.key /etc/apache2/ssl/ssl.key
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite \
    && a2enmod ssl
