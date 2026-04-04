#!/bin/sh

# Run migrations
php artisan migrate --force

# Seed if needed (you might want to control this via env)
if [ "$RUN_SEEDER" = "true" ]; then
    php artisan db:seed --force
fi

# Start supervisor
/usr/bin/supervisord -c /etc/supervisord.conf
