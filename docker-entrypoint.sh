#!/bin/sh
set -e

# Install Composer dependencies if vendor directory doesn't exist
if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Create .env file if it doesn't exist
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        echo "Creating .env file from .env.example..."
        cp .env.example .env
        php artisan key:generate --force
    fi
fi

# Create SQLite database if it doesn't exist
if [ ! -f "database/database.sqlite" ]; then
    echo "Creating SQLite database..."
    mkdir -p database
    touch database/database.sqlite
    chmod 664 database/database.sqlite
fi

# Set proper permissions for Laravel directories
mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Execute the main command
exec "$@"

