FROM php:8.2-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev sqlite3 \
    && docker-php-ext-install zip pdo pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

# Create sqlite file
RUN mkdir -p database
RUN touch database/database.sqlite

# Link storage
RUN php artisan storage:link || true

# Serve from public
CMD php -S 0.0.0.0:10000 -t public