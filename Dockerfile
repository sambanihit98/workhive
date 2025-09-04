FROM php:8.2-cli

# Install PHP extensions Laravel needs
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy all files
COPY . .

# Install PHP dependencies only
RUN composer install --no-dev --optimize-autoloader

# Generate APP_KEY (optional if not in .env)
# RUN php artisan key:generate

EXPOSE 10000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
