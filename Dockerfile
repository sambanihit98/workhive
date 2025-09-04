# Use PHP 8.3 CLI
FROM php:8.3-cli

# Install system dependencies and PHP extensions Laravel needs
RUN apt-get update && apt-get install -y \
    unzip zip git curl libzip-dev libpng-dev libonig-dev libxml2-dev zlib1g-dev g++ make libicu-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd intl zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy all project files
COPY . .

# Ensure SQLite database exists and set folder permissions
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chmod -R 777 database storage bootstrap/cache

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port for Render
EXPOSE 10000

# Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
