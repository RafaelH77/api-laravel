FROM php:8.1.19-fpm

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && rm composer-setup.php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod a+x /usr/local/bin/composer

RUN apt-get update \
    && apt-get install -y zip

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN pecl install xdebug-3.2.1 \
    && docker-php-ext-enable xdebug

RUN apt-get install -y    \
    build-essential
    
RUN docker-php-ext-enable fileinfo

RUN echo "[xdebug]" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.mode=debug" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.client_host=host.docker.internal" >>  $PHP_INI_DIR/php.ini \
    && echo "xdebug.start_with_request=yes" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.discover_client_host=off" >> $PHP_INI_DIR/php.ini \
    && echo "xdebug.log=/var/www/html/xdebug.log" >> $PHP_INI_DIR/php.ini

WORKDIR /var/www/html

EXPOSE 9000
