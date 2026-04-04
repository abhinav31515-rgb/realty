#!/bin/sh
set -e
echo "Running migrations..."
php artisan migrate --force || echo "Migration failed, continuing..."
if [ "$RUN_SEEDER" = "true" ]; then
    echo "Seeding database..."
    php artisan db:seed --force || echo "Seeding failed, continuing..."
fi
echo "Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
