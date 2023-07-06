## Acerca de

NB-TODO LIST. Prueba de concepto.

## Herramientas utilizadas

- Windows 10
- Visual Studio Code
- Sublime Merge
- Postman
- HeidiSQL
- WLS2
- Docker destop
- Proxmox
- Portainer

## Puesta en amrcha

### Requisitos

- Debian 12
- Git
- php 8.2
- composer 

### Instalación

- Clonar el repositorio -> `git clone https://github.com/neslonso/nb-todo.git`

### Via instalador

- Ejecutar instalador -> `cd nb-todo && chmod 770 ./install.sh && ./install.sh`

### O paso a paso

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

Acceder a app -> `http://localhost:8088/` (o la IP de la máquina virtual/container sobre en que se haya hecho la instalación).

P.D: Probado contra un lxc debian 12 sobre proxmox.
