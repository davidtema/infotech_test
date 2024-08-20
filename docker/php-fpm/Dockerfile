FROM php:8.3-fpm-alpine

RUN apk add --no-cache autoconf g++ make \
    && apk add bash \
    && apk add vim \
    && apk add libmcrypt-dev \
    && apk add libpng-dev \
    && apk add zip libzip-dev \
    && apk add icu-dev \
    && apk add icu-dev \
    && rm -rf /tmp/pear

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install opcache

COPY ./conf.d/opcache.ini /usr/local/etc/php/conf.d
COPY ./conf.d/xdebug.ini /usr/local/etc/php/conf.d

#RUN docker-php-ext-install xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER=1

COPY ./ /app

WORKDIR /app

CMD php-fpm

EXPOSE 9000