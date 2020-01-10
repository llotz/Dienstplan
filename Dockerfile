FROM php:7.4-apache

RUN apt-get update && apt-get upgrade -y
RUN docker-php-ext-install mysqli
RUN pecl install xdebug
EXPOSE 80

RUN a2enmod rewrite

ADD ./src /var/www/html
