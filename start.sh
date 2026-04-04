#!/bin/sh
set -e

echo "Environment: $APP_ENV"

# Generate key if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating app key..."
    php artisan key:generate --force
fi

echo "Running migrations..."
php artisan migrate --force || echo "Migration failed, continuing..."

if [ "$RUN_SEEDER" = "true" ]; then
    echo "Seeding database..."
    php artisan db:seed --force || echo "Seeding failed, continuing..."
fi

echo "Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
