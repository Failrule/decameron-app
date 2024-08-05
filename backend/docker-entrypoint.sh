#!/bin/bash
echo "Corriendo entrypoint"

/usr/bin/composer install --prefer-dist --no-scripts --no-dev --optimize-autoloader

# Ejecutar comandos de Artisan
php ./artisan key:generate
php ./artisan migrate
php ./artisan cache:clear
php ./artisan config:clear
php ./artisan route:clear

# Servir la aplicación
php ./artisan serve --port=8000 --host=0.0.0.0

exec docker-php-entrypoint "$@"
