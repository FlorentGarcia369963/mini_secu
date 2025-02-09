FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev unzip wget curl \
    && docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://get.symfony.com/cli/installer -o symfony-installer.sh \
&& bash symfony-installer.sh \
&& mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

RUN useradd -m symfony
RUN chown -R symfony:symfony /var/www/html

USER symfony

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .
# Pour le mode prod
RUN composer install --no-scripts --no-dev --optimize-autoloader
RUN composer run-script auto-scripts

# Pour le mode dev
# RUN composer install

USER root
RUN sed -i 's/user = www-data/user = symfony/g' /usr/local/etc/php-fpm.d/www.conf
RUN sed -i 's/group = www-data/group = symfony/g' /usr/local/etc/php-fpm.d/www.conf

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/var

EXPOSE 9000

CMD ["php-fpm"]
