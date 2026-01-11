# --- Stage 1: Build frontend assets ---
FROM node:18 AS node_builder

WORKDIR /app

# Copy package files
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy all project files
COPY . .

# Build Vite assets
RUN npm run build


# --- Stage 2: PHP Application ---
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy Laravel app
COPY . .

# Copy built frontend assets from Stage 1
COPY --from=node_builder /app/public/build ./public/build

# Install composer dependencies (tanpa dev)
RUN composer install --no-dev --optimize-autoloader

# Laravel storage permissions
RUN mkdir -p storage bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

# Expose port (Railway default 8080)
EXPOSE 8080

# Start PHP server
CMD php artisan serve --host=0.0.0.0 --port=8080
