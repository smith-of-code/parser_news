FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    wget \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    libzip-dev \
    zip \
    supervisor
RUN pecl install xdebug-3.2.0
RUN pecl install redis

# Install PHP extensions
RUN docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath gd

RUN docker-php-ext-enable xdebug redis.so

ADD ./php.ini /usr/local/etc/php/php.ini
ADD ./horizon.conf /etc/supervisor/conf.d/horizon.conf

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Get latest Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Create system user to run Composer and Artisan Commands
RUN mkdir -p /var/log/supervisor

# Set working directory
WORKDIR /var/www
