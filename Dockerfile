
FROM php:8.4-apache

RUN a2enmod rewrite

# Instalar las extensiones necesarias para MySQL
RUN docker-php-ext-install pdo_mysql

COPY apache.conf /etc/apache2/conf-available/app.conf
RUN a2enconf app
