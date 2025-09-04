FROM php:8.2-cli

# Install PHP extensions Laravel needs
RUN apt-get update && apt-get install -y \
    unzip zip git libzip-dev libpng-dev libonig-dev libxml2-dev zlib1g-dev g++ make \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd intl zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy all project files
COPY . .

# Add temporary .env with APP_KEY to prevent artisan failures
RUN echo "APP_KEY=base64:GI+O0El4hJxr4I/3oPapMYNqQEWP55x3Z8E1sryyiuk=" > .env \
    && echo "DB_CONNECTION=sqlite" >> .env \
    && touch database/database.sqlite

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

EXPOSE 10000

# Start Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
