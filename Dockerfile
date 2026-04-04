FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    postgresql-dev \
    oniguruma-dev

RUN docker-php-ext-install pdo_pgsql pgsql bcmath gd mbstring

# Create necessary directories for Nginx and Supervisor
RUN mkdir -p /run/nginx /var/log/supervisor /var/log/nginx

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . /var/www

RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Note: We use the full path for config in start.sh
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisord.conf

RUN chmod +x /var/www/start.sh

EXPOSE 80

CMD ["/var/www/start.sh"]
