FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libicu-dev libxml2-dev libssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install gd zip intl bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-scripts

RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT} -t public"]