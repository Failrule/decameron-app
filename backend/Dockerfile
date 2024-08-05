FROM php:8.1

# Instalar dependencias del sistema
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y unzip libpq-dev libcurl4-gnutls-dev && \
    docker-php-ext-install pdo pdo_pgsql bcmath

# Habilitar redis
RUN pecl install redis && \
    docker-php-ext-enable redis

# Establecer el directorio de trabajo
WORKDIR /var/www

COPY . .

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar las dependencias de Composer
RUN composer install --prefer-dist --no-scripts --no-dev --optimize-autoloader

# Copiar script de inicio
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]
