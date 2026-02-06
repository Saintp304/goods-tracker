FROM php:8.2-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev sqlite3 \
    && docker-php-ext-install zip pdo pdo_sqlite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

# Create SQLite database
RUN touch database/database.sqlite

# Run migrations
RUN php artisan migrate --force

# Link storage for images
RUN php artisan storage:link

# Serve Laravel from PUBLIC folder
CMD php -S 0.0.0.0:10000 -t public