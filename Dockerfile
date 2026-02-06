FROM php:8.2-cli

WORKDIR /var/www

COPY . .

# Install system packages
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    sqlite3 \
    libsqlite3-dev

# Install only needed PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create SQLite database file
RUN mkdir -p database
RUN touch database/database.sqlite

# Link storage (for images)
RUN php artisan storage:link || true

# Start Laravel
CMD php -S 0.0.0.0:10000 -t public