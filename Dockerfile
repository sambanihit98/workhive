# 1. Base image
FROM php:8.3-cli

# 2. Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip zip git curl libzip-dev libpng-dev libonig-dev libxml2-dev zlib1g-dev g++ make libicu-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd intl zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /app

# 5. Copy all project files
COPY . .

# 6. Create SQLite database and set permissions
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chmod -R 777 database storage bootstrap/cache

# 7. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 8. Expose port
EXPOSE 10000

# 9. Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]


