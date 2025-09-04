# Use PHP with Apache
FROM php:8.2-apache

# Install PHP extensions Laravel needs
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy all files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run build \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Expose port
EXPOSE 10000

# Start Laravel
CMD php artisan serve --host 0.0.0.0 --port 10000
