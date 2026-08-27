# ============================================================
# JobHub — Docker Image (Apache + PHP 8.2)
# Replaces XAMPP Apache/PHP stack
# ============================================================

FROM php:8.2-apache

LABEL maintainer="JobHub Team" \
      description="JobHub Job Portal - Apache + PHP 8.2"

# Enable Apache modules
RUN a2enmod rewrite headers expires

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        unzip \
        curl \
        git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mysqli \
        zip \
        gd \
        mbstring \
        exif \
        bcmath \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/public/uploads \
    && chmod -R 775 /var/www/html/tests

RUN find /var/www/html -type d -exec chmod 755 {} + \
    && find /var/www/html -type f -exec chmod 644 {} +

RUN chmod 640 /var/www/html/config/*.php

# Configure Apache virtual host
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Configure PHP
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Expose port 80 (Apache)
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
