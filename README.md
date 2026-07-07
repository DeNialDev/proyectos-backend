Markdown
# Proyectos API - Backend

API construida con Laravel 11 utilizando el Patrón Repositorio para la gestión de datos, Laravel Passport para la autenticación y Form Requests para la validación de peticiones.

## Requisitos Previos

* PHP >= 8.2
* Composer
* MySQL / MariaDB

## Instalación y Configuración Local

1. Clonar el repositorio y entrar a la carpeta:
   ```bash
   git clone [https://github.com/DeNialDev/proyectos-backend.git](https://github.com/DeNialDev/proyectos-backend.git)
   cd proyectos-backend
Instalar dependencias de PHP:

 ```bash
composer install
Configurar el archivo de entorno:

 ```bash
cp .env.example .env
(Editar el archivo .env configurando las credenciales de la base de datos)

Generar la clave de la aplicación:

 ```bash
php artisan key:generate
Correr migraciones y seeders:

 ```bash
php artisan migrate --seed
Generar llaves de cifrado para Laravel Passport:

 ```bash
php artisan passport:keys --force
Configurar permisos de almacenamiento (Linux/Ubuntu):

 ```bash
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
chmod 660 storage/oauth-private.key storage/oauth-public.key
Limpiar caché del contenedor:

 ```bash
php artisan config:clear
php artisan cache:clear
Iniciar el servidor de desarrollo:

 ```bash
php artisan serve
La API estará disponible en http://127.0.0.1:8000.
