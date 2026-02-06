FROM php:8.2-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev sqlite3 \
    libxml2-dev \
    && docker-php-ext-install \
    pdo \
    pdo_sqlite \
    mbstring \
    bcmath \
    tokenizer \
    xml \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN mkdir -p database
RUN touch database/database.sqlite

RUN php artisan storage:link || true

CMD php -S 0.0.0.0:10000 -t public