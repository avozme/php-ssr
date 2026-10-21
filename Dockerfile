FROM php:8.4-apache

RUN a2enmod rewrite

COPY apache.conf /etc/apache2/conf-available/app.conf
RUN a2enconf app