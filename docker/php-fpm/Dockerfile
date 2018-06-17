FROM php:5.6-fpm
MAINTAINER Claude <claude@heaux-isp.com>

RUN apt-get -y update

RUN apt-get -y install libicu-dev libxml2-utils libxml2-dev libgd-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev    

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/

RUN docker-php-ext-install gd &&\
    docker-php-ext-install intl &&\
    docker-php-ext-install pdo &&\
    docker-php-ext-install pdo_mysql

# COPY config/php.ini /usr/local/etc/php/

WORKDIR /app