# ==============================================================================
# Multi-Stage Production Dockerfile for Ponnus Restaurant on Render (Free Tier)
# ==============================================================================

# ------------------------------------------------------------------------------
# Stage 1: Build Frontend Assets (Vite, TailwindCSS, Bootstrap)
# ------------------------------------------------------------------------------
FROM node:20-alpine AS frontend
WORKDIR /app

# Copy dependency manifests
COPY package*.json ./
RUN npm ci --prefer-offline --no-audit

# Copy application source files needed for Vite compilation
COPY vite.config.js ./
COPY resources/ resources/
COPY public/ public/

# Compile production assets to public/build
RUN npm run build

# ------------------------------------------------------------------------------
# Stage 2: Install Composer Dependencies (Production Only)
# ------------------------------------------------------------------------------
FROM composer:2 AS vendor
WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts \
    --ignore-platform-reqs

# ------------------------------------------------------------------------------
# Stage 3: Production Runtime (PHP 8.4-FPM + Nginx + Supervisor)
# ------------------------------------------------------------------------------
FROM php:8.4-fpm-bookworm AS production

LABEL maintainer="Mathew Phillip <mathew@ponnus.test>"
LABEL description="Ponnus Restaurant Menu Management System - Production Container for Render"

# Install system dependencies, Nginx, Supervisor, and required libraries
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    supervisor \
    gettext-base \
    curl \
    ca-certificates \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Configure & install required PHP extensions for Laravel 12 + Jetstream + MySQL + PostgreSQL
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        pdo_pgsql \
        bcmath \
        gd \
        intl \
        zip \
        opcache

# Copy Composer binary from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configure PHP & OPcache
COPY docker/php.ini $PHP_INI_DIR/conf.d/custom.ini
COPY docker/opcache.ini $PHP_INI_DIR/conf.d/opcache.ini

# Configure Nginx & Supervisor
RUN mkdir -p /etc/nginx/templates /etc/supervisor/conf.d
COPY docker/nginx.conf.template /etc/nginx/templates/default.conf.template
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Setup working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Copy pre-built vendor from Stage 2
COPY --from=vendor /app/vendor /var/www/html/vendor

# Copy compiled frontend assets from Stage 1
COPY --from=frontend /app/public/build /var/www/html/public/build

# Setup entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Setup proper directory permissions for Laravel storage & bootstrap cache
RUN mkdir -p \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Render default port
EXPOSE 10000

# Set entrypoint & command
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
