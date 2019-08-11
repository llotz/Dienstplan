FROM php:7.3-apache

# Install mysql
RUN apt-get update && apt-get upgrade -y
RUN docker-php-ext-install mysqli
EXPOSE 80

RUN a2enmod rewrite

ADD ./src /var/www/html

# Setup Database with create script
COPY createDb.sql /docker-entrypoint-initdb.d/
