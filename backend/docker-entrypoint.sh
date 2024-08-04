#!/bin/bash

# Salir inmediatamente si un comando falla
set -e

# Si no existe el archivo composer.json, muestra un mensaje de error y termina
if [ ! -f "./api/composer.json" ]; then
    echo "El directorio api no existe. Creando un nuevo proyecto Laravel..."
    composer create-project laravel/laravel api
else
    echo "Ya existe proyecto backend en ./api"
fi

cd api

# Ejecutar comandos de Artisan
php artisan key:generate
php artisan migrate
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Servir la aplicación
php artisan serve --port=8000 --host=0.0.0.0

exec docker-php-entrypoint "$@"
