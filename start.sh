#!/bin/sh

echo "Running migrations..."
php artisan migrate --force

if [ "$RUN_SEEDER" = "true" ]; then
    echo "Seeding database..."
    php artisan db:seed --force
fi

echo "Starting Supervisor..."
/usr/bin/supervisord -c /etc/supervisord.conf
