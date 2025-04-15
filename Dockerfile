# Using the PHP 8.2 as Apache base image
FROM php:8.2-apache

# Enable the Apache module rewrite
RUN a2enmod rewrite

# Install PHP extensions for MySQL database connection
RUN docker-php-ext-install mysqli pdo_mysql pdo

# Install Composer
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install XDebug 
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install net utils inside container
#RUN apt update
#RUN apt install -y inetutils-ping netcat-openbsd

#COPY ./php_config/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini