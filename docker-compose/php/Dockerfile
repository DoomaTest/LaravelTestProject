FROM php:8.0.2-fpm-alpine3.13

# Copy File Config
ADD ./docker-compose/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# ADD and set Group
RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

# Create folder to run
RUN mkdir -p /var/www/html

# Work in the specific space
WORKDIR /var/www/html

# Install dependencies
RUN apk add --no-cache \
    freetype \
    libpng \
    libjpeg-turbo \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    php8-pdo_pgsql \
    postgresql-dev \
    postgresql-client

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg

RUN NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
    docker-php-ext-install -j${NPROC} gd

RUN apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

RUN docker-php-ext-install pdo pdo_pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.0.3

# Set Profile
RUN chown -R laravel:laravel /var/www/html

# install and enable xdebug
#RUN apk add --no-cache $PHPIZE_DEPS \
#	&& pecl install xdebug-2.9.7 \
#	&& docker-php-ext-enable xdebug
