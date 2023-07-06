# Acerca de

NB-TODO LIST. Prueba de concepto.

# Herramientas utilizadas

- Windows 10
- Visual Studio Code
- Sublime Merge
- Postman
- HeidiSQL
- WLS2
- Docker destop
- Proxmox
- Portainer

# Instalación

## En windows, Vía vscode devcontainer

### Requisitos

- Git
- Visual Studio Code
- Docker desktop
- composer

- Clonar el repositorio -> `git clone https://github.com/neslonso/nb-todo.git`
- Inicializar submodulos -> `cd nb-todo && git submodule update --init --recursive`
- Copiar el archivo `.env.local` a `.env` -> `cp .env.local .env`
- Instalar dependencias -> `composer install`
- Instalar la extensión Dev Containers de Microsoft (o el pack de extensines Remote Development)
- Abrir directorio del repo en vscode, detectará .devcontainer/devcontainer.json -> Reopen in container
- Terminal al container
  - Migrate -> `php artisan migrate`
  - Test -> `php artisan test`
  - Instalar dependencias vue -> `cd /var/www/html/vue3-client/ && npm install`
  - Instalar vue-cli-service -> `npm install @vue/cli-service`
  - Build de cliente api -> `npm run build-to-laravel`

## En debian, Vía docker

### Requisitos

- Debian 12
- Git
- php 8.2
- composer
- docker & docker-compose

- Clonar el repositorio -> `git clone https://github.com/neslonso/nb-todo.git`

#### Via instalador

- Ejecutar instalador -> `cd nb-todo && chmod 770 ./install.sh && ./install.sh`

#### O paso a paso

- Inicializar submodulos -> `cd nb-todo && git submodule update --init --recursive`
- Copiar el archivo `.env.local` a `.env` -> `cp .env.local .env`
- Instalar y activar paquetes de php -> `apt-get install php8.2-xml php8.2-curl -y && phpenmod xml`
- Instalar dependencias -> `composer install`
- Ajustar permisos -> `chmod -R a+w storage/ && chmod -R a+w bootstrap/`
- Iniciar Laravel sail -> `./vendor/bin/sail up -d`
- Shell a Laravel sail -> `./vendor/bin/sail root-shell`
- Migrate -> `php artisan migrate`
- Test -> `php artisan test`
- Instalar dependencias vue -> `cd /var/www/html/vue3-client/ npm install`
- Instalar vue-cli-service -> `npm install -g @vue/cli-service`
- Build de cliente api -> `npm run build-to-laravel`

Probado contra debian 12 con los requisitos instalados (docker en lxc sobre proxmox).

# Acceso

- Acceder a app -> `http://localhost:8088/` (o la IP de la máquina virtual/container sobre en que se haya hecho la instalación).
- Datos de login: probador@pruebas.hace :: 12345678

# Quality

- Ejecutar pruebas de ejemplo -> `composer test`
  - code covegare en `tests/reports/coverage`
- Phpstan -> `composer phpstan`
- Telescope -> http://localhost:8088/telescope
  - Telescope proporciona información detallada sobre las consultas que se realizan
  en nuestra aplicación, incluyendo cuánto tiempo tarda cada consulta y cuántos datos
  se están recuperando. Así podemos identificar consultas que están tardando más
  tiempo de lo normal o recuperando más datos de lo necesario, lo que nos permite
  enfocar los esfuerzos en optimizar esas consultas.
