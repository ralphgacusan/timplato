# =========================
# Stage 1: PHP dependencies
# =========================
FROM php:8.2-cli AS composer

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        intl \
        zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts


# =========================
# Stage 2: Frontend assets
# =========================
FROM node:22-bookworm-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./

RUN npm run build


# =========================
# Stage 3: Production image
# =========================
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        intl \
        zip \
    && rm -rf /var/lib/apt/lists/*

# =========================
# Apache MPM configuration
# =========================
RUN a2dismod mpm_event mpm_worker mpm_prefork || true; \
    a2enmod mpm_prefork rewrite; \
    echo "Enabled Apache MPM modules:"; \
    apache2ctl -M 2>/dev/null | grep mpm

WORKDIR /var/www/html

COPY --from=composer /app/vendor ./vendor

COPY . .

COPY --from=frontend /app/public/build ./public/build

# Apache should serve Laravel's public directory
RUN sed -i 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf

RUN sed -i \
    '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' \
    /etc/apache2/apache2.conf

RUN chown -R www-data:www-data storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/laravel-entrypoint

RUN chmod +x /usr/local/bin/laravel-entrypoint

EXPOSE 80

ENTRYPOINT ["laravel-entrypoint"]

CMD ["apache2-foreground"]