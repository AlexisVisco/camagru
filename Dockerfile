FROM php:7.2-apache

RUN apt-get update && apt-get install -y ssmtp && rm -r /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

ADD docker/ssmtp.conf /etc/ssmtp/ssmtp.conf
ADD docker/php-smtp.ini /usr/local/etc/php/conf.d/php-smtp.ini

RUN pecl install xdebug-2.6.0

RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable xdebug
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/php.ini

RUN usermod -u 1000 www-data

RUN a2enmod rewrite

