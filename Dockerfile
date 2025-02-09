FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev unzip wget \
    && docker-php-ext-install pdo pdo_pgsql

RUN wget https://get.symfony.com/cli/installer -O - | bash \
&& mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

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
