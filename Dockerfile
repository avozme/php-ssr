FROM php:8.3-apache

# Instalar el controlador PDO para MySQL
RUN docker-php-ext-install pdo_mysql