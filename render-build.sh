#!/usr/bin/env bash
# Render.com build script for Laravel

set -e

echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "Installing NPM dependencies..."
npm ci

echo "Building assets..."
npm run build

echo "Caching Laravel configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Running database migrations..."
php artisan migrate --force --no-interaction

echo "Creating storage link..."
php artisan storage:link || true

echo "Build completed successfully!"
