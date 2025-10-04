FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel config
RUN cp .env.example .env || true
RUN php artisan key:generate

# Expose port
EXPOSE 10000

# Start server
CMD php -S 0.0.0.0:10000 -t public
