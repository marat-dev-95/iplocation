FROM php:8.0-fpm-alpine

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql

WORKDIR /app
