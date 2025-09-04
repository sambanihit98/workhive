# 1️⃣ Base image
FROM php:8.3-cli

# 2️⃣ Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip zip git curl libzip-dev libpng-dev libonig-dev libxml2-dev zlib1g-dev g++ make libicu-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd intl zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3️⃣ Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4️⃣ Set working directory
WORKDIR /app

# 5️⃣ Copy all project files
COPY . .

# 6️⃣ Set permissions for Laravel folders
RUN chmod -R 777 storage bootstrap/cache

# 7️⃣ Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 8️⃣ Expose port
EXPOSE 10000

# 9️⃣ Run migrations safely and start Laravel
#    --force ensures migrations run without confirmation
#    Existing tables are ignored by Laravel, so no drops
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000
