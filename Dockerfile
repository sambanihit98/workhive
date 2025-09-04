# Stage 1 - PHP dependencies
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Stage 2 - Node build (Vite)
FROM node:18 AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 3 - Final image with PHP 8.3
FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip unzip git curl \
    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /app

# Copy backend (PHP) files
COPY --from=vendor /app/vendor ./vendor
COPY . .

# Copy frontend build (public/build) from Node stage
COPY --from=frontend /app/public/build ./public/build

# Expose port
EXPOSE 8000

# Start Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
