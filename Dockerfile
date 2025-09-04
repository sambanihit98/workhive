FROM php:8.3-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip zip git curl libzip-dev libpng-dev libonig-dev libxml2-dev zlib1g-dev g++ make libicu-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd intl zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy all project files
COPY . .

# Temporary .env with APP_KEY for build
RUN echo "APP_KEY=base64:GI+O0El4hJxr4I/3oPapMYNqQEWP55x3Z8E1sryyiuk=" > .env \
    && echo "DB_CONNECTION=sqlite" >> .env \
    && mkdir -p database && touch database/database.sqlite

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

EXPOSE 10000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
