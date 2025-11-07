FROM php:7.2.2-apache
RUN docker-php-ext-install mysqli

# Añadimos cabeceras de seguridad
COPY config/security-headers.conf /etc/apache2/conf-available/security-headers.conf
RUN a2enmod headers && a2enconf security-headers