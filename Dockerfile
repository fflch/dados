FROM uspdev/uspdev-php-apache:latest

RUN sed -i 's|/var/www/html|/var/www/html/public|' \
    /etc/apache2/sites-available/000-default.conf

USER www-data

COPY --chown=www-data . .

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

CMD ["apache2-foreground"]

