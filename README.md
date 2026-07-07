# 🚀 Proyectos API - Backend

API desarrollada con **Laravel 11**, siguiendo el **Patrón Repositorio** para la gestión de datos, utilizando **Laravel Passport** para la autenticación y **Form Requests** para la validación de solicitudes.

---

## 📋 Requisitos Previos

Antes de comenzar, asegúrate de tener instalado:

- PHP **>= 8.2**
- Composer
- MySQL o MariaDB

---

## ⚙️ Instalación y Configuración

### 1. Clonar el repositorio

```bash
git clone https://github.com/DeNialDev/proyectos-backend.git
cd proyectos-backend
```

### 2. Instalar las dependencias

```bash
composer install
```

### 3. Configurar las variables de entorno

```bash
cp .env.example .env
```

### 4. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 5. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

### 6. Generar las llaves de Laravel Passport

```bash
php artisan passport:keys --force
```

### 7. Configurar permisos (Linux/Ubuntu)

```bash
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
chmod 660 storage/oauth-private.key storage/oauth-public.key
```

### 8. Limpiar la caché de Laravel

```bash
php artisan config:clear
php artisan cache:clear
```

### 9. Iniciar el servidor de desarrollo

```bash
php artisan serve
```

La API estará disponible en:

> **http://127.0.0.1:8000**

---

## 📁 Estructura del Proyecto

El proyecto sigue una arquitectura basada en el **Patrón Repositorio**, separando la lógica de acceso a datos de la lógica de negocio para facilitar el mantenimiento y las pruebas.

```
app/
├── Http/
│   ├── Controllers/
│   ├── Requests/
│   └── Resources/
├── Interfaces/
├── Repositories/
├── Models/
└── Providers/
```

---

## 🔐 Autenticación

La autenticación se realiza mediante **Laravel Passport**, utilizando **OAuth2** para proteger los endpoints de la API.

---

## ✅ Tecnologías Utilizadas

- ⚡ Laravel 11
- 🐘 PHP 8.2+
- 🗄️ MySQL / MariaDB
- 🔐 Laravel Passport
- 📦 Patrón Repositorio
- ✔️ Form Requests
- 🎯 API REST

---

## 👨‍💻 Autor

Desarrollado por **DeNialDev**.
