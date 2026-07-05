FROM --platform=linux/arm64 php:8.5-fpm
LABEL org.opencontainers.image.authors="Claude claude@heaux-isp.com"

RUN apt-get -y update

RUN apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql

WORKDIR /app
