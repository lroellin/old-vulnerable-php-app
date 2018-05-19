FROM php:5.6-apache
RUN apt-get update && apt-get install -y git zlib1g-dev fortune libpng-dev \
    && docker-php-ext-install pdo pdo_mysql gd \
    && pecl install SPL_Types-0.4.0 \
    && docker-php-ext-enable spl_types
RUN a2enmod rewrite
COPY --chown=www-data:www-data src/ /var/www/html
COPY php.ini /usr/local/etc/php/