FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /var/www/html

COPY . .
RUN composer install

# RUN chown -R www-data:www-data /var/www/html \
#     && chmod -R 755 /var/www/html

CMD ["php-fpm"]