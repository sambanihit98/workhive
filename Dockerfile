# 1️ Base image with PHP 8.3 CLI
FROM php:8.3-cli

# 2️ Install system dependencies, PHP extensions, Node.js, and npm
RUN apt-get update && apt-get install -y \
    unzip zip git curl libzip-dev libpng-dev libonig-dev libxml2-dev zlib1g-dev g++ make libicu-dev libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd intl zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3️ Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4️ Set working directory
WORKDIR /app

# 5️ Copy project files
COPY . .

# 6️ Set folder permissions
RUN chmod -R 777 storage bootstrap/cache

# 7️ Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 8️ Install Node.js dependencies and build Vite assets
RUN npm install
RUN npm run build

# 9 Expose port
EXPOSE 10000

# 1️0 Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
