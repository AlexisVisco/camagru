FROM php:7.1.2-apache

RUN apt-get update && apt-get install -y ssmtp && rm -r /var/lib/apt/lists/*

ADD docker/ssmtp.conf /etc/ssmtp/ssmtp.conf
ADD docker/php-smtp.ini /usr/local/etc/php/conf.d/php-smtp.ini

RUN pecl install xdebug-2.6.0

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable xdebug
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/php.ini

RUN usermod -u 1000 www-data

RUN a2enmod rewrite

