#!/bin/bash

# Abortar el script si ocurre algún error
set -e

# Clonar el repositorio de GitHub
git clone https://github.com/neslonso/nb-todo.git

# Actualizar submódulos
cd nb-todo
git submodule update --init --recursive

# Copiar .env.local a .env
cp .env.local .env

# Instalar y habilitar la extensión xml para php8.2
apt-get install php8.2-xml php8.2-curl -y
phpenmod xml

# Instalar dependencias con Composer
composer install

# Cambiar los permisos de las carpetas de almacenamiento y bootstrap
chmod -R a+w storage/
chmod -R a+w bootstrap/

# Iniciar Sail
./vendor/bin/sail up -d

# Ejecutar migraciones, pruebas y comandos de npm en la shell de Sail con privilegios de root
./vendor/bin/sail root-shell bash -c '\
php artisan migrate && \
php artisan test && \
cd vue3-client/ && \
npm install && \
npm install -g @vue/cli-service && \
npm run build-to-laravel'
