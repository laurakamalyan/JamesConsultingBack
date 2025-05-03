FROM php:8.2-cli

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy app files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel-specific: generate storage link & config cache
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Expose HTTP port
EXPOSE 8000

# Start Laravel built-in server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
