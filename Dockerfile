ARG PHP_IMAGE=php:7.2-fpm

FROM composer:1.8.6 AS composer
WORKDIR /composer
COPY ./composer.json \
     ./composer.lock \
     ./symfony.lock \
     ./
RUN composer install --ignore-platform-reqs --no-scripts ${COMPOSER_FLAGS}

FROM ${PHP_IMAGE} AS app_vendor

RUN apt-get update \
    && apt-get install -y \
        librabbitmq-dev \
     && docker-php-ext-install pdo pdo_mysql \
    && pecl install amqp-1.9.4 \
    && docker-php-ext-enable amqp \
    && apt-get clean

# Set the WORKDIR to /app so all following commands run in /app
WORKDIR /app

#COPY composer.json composer.lock

# Install Composer and make it available in the PATH
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Copy composer files into the app directory.
#COPY composer.json composer.lock ./

# Install dependencies with Composer.
# --no-interaction makes sure composer can run fully automated
#RUN composer install --no-interaction --prefer-dist --no-scripts --no-dev

RUN sed -i "s/\(user\|group\) = www-data/\1 = root/" /usr/local/etc/php-fpm.d/www.conf

# Set the WORKDIR to /app so all following commands run in /app
WORKDIR /app

COPY --from=composer /composer /app
COPY ./ /app

CMD ["php-fpm", "-R"]
