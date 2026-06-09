FROM uspdev/uspdev-php-apache:8.4

RUN sed -i 's|/var/www/html|/var/www/html/public|' \
    /etc/apache2/sites-available/000-default.conf

# bibliotecas para mongo
RUN apt-get update && apt-get install -y \
        libssl-dev \
        pkg-config

RUN pecl install mongodb && docker-php-ext-enable mongodb

USER www-data

COPY --chown=www-data . .

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

CMD ["apache2-foreground"]