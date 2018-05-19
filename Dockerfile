FROM php:5.6-apache
RUN apt-get update && apt-get install -y git zlib1g-dev fortune libpng-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_mysql gd \
    && pecl install SPL_Types-0.4.0 \
    && docker-php-ext-enable spl_types \
    && a2enmod rewrite \
    && echo "date.timezone=UTC" > /usr/local/etc/php/php.ini
COPY --chown=www-data:www-data src/ /var/www/html