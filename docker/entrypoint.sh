#!/bin/sh

set -e

echo "Starting Laravel production container..."

cd /var/www/html

# Make sure Laravel writable directories exist
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache

# Create public storage symlink if needed
php artisan storage:link --force || true

# Cache Laravel configuration/routes/views
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Laravel production container ready."

exec "$@"
