#!/bin/bash

# Abortar el script si ocurre algún error
set -e

# Función para imprimir mensajes con formato
print_message() {
  echo
  echo -e "\e[32m####################################\e[0m"
  echo -e "\e[32m$1\e[0m"
  echo -e "\e[32m####################################\e[0m"
  echo
}

# Actualizar submódulos
print_message "Actualizando submódulos..."
git submodule update --init --recursive

# Copiar .env.local a .env
print_message "Copiando .env.local a .env..."
cp .env.local .env

# Instalar y habilitar la extensión xml para php8.2
print_message "Instalando y habilitando la extensión xml para php8.2..."
apt-get install php8.2-xml php8.2-curl -y
phpenmod xml

# Instalar dependencias con Composer
print_message "Instalando dependencias con Composer..."
composer install

# Cambiar los permisos de las carpetas de almacenamiento y bootstrap
print_message "Cambiando permisos de las carpetas de almacenamiento y bootstrap..."
chmod -R a+w storage/
chmod -R a+w bootstrap/

# Iniciar Sail
print_message "Iniciando Sail..."
./vendor/bin/sail up -d

# Ejecutar migraciones, pruebas y comandos de npm en la shell de Sail con privilegios de root
print_message "Ejecutando migraciones, pruebas y comandos de npm en la shell de Sail con privilegios de root..."
./vendor/bin/sail root-shell -c '\
php artisan migrate && \
php artisan test && \
cd vue3-client/ && \
npm install && \
npm install -g @vue/cli-service && \
npm run build-to-laravel'

print_message "Finalizado, app funcionando en tcp/8088."