FROM php:8.0-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    zlib1g-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libfreetype6-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libpq-dev \
    libmagickwand-dev \
    ghostscript \
    && pecl install imagick redis xdebug \
    && docker-php-ext-enable imagick redis xdebug \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure pgsql \
    && docker-php-ext-install -j$(nproc) gd soap iconv pdo pdo_mysql pdo_pgsql pgsql zip mbstring exif \
    && docker-php-source delete

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ADD ./php.ini /usr/local/etc/php/php.ini

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

USER www

EXPOSE 9000
CMD ["php-fpm"]
