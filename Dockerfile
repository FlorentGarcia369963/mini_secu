FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev unzip \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .
# Pour le mode prod
# RUN composer install --no-dev --optimize-autoloader
# Pour le mode dev
RUN composer install


RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/var

EXPOSE 9000

CMD ["php-fpm"]
