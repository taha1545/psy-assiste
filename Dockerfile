# Use an official PHP 8.2 CLI image
FROM php:8.2-cli

# Install required dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    git \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Set permissions for storage and cache
RUN chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 8000 for Laravel's built-in server
EXPOSE 8000

# Start Laravel's built-in Fast API server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
