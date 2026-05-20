FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite

WORKDIR /var/www/html