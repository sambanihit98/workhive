# 1. Base image
FROM php:8.3-cli

# 2. Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip zip git curl gnupg libzip-dev libpng-dev libonig-dev libxml2-dev zlib1g-dev g++ make libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd intl zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Install Node.js (latest LTS) from NodeSource
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 4. Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 5. Set working directory
WORKDIR /app

# 6. Copy all project files
COPY . .

# 7. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 8. Install Node dependencies and build frontend
RUN npm install && npm run build

# 9. Set permissions
RUN chmod -R 777 storage bootstrap/cache

# 10. Expose port
EXPOSE 10000

# 11. Start Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
