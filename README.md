# Página Web - Comando Departamental de Cochabamba

Sitio institucional desarrollado con Laravel (backend administrativo) y HTML/CSS/JavaScript (frontend público). Gestiona noticias, imágenes, eventos, usuarios, contactos, documentos y transmisiones en vivo.

## Requisitos

- PHP >= 8.2
- Composer
- PostgreSQL
- Git
- Navegador web

## Instalación local

1. Clonar el repositorio y entrar al backend:

```bash
git clone https://github.com/MauricioRoaC/PaginaWebCDC.git
cd PaginaWebCDC/backend
```

2. Instalar dependencias y crear la configuración local:

```bash
composer install
cp .env.example .env
php artisan key:generate
```

3. Crear una base de datos PostgreSQL vacía, por ejemplo:

```sql
CREATE DATABASE policiaDepCbb;
```

4. Editar `.env` con los datos de conexión PostgreSQL y configurar el primer SuperAdmin:

```dotenv
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=policiaDepCbb
DB_USERNAME=postgres
DB_PASSWORD=tu_password

SUPERADMIN_NAME="Administrador principal"
SUPERADMIN_EMAIL=admin@tu-dominio.com
SUPERADMIN_PASSWORD=una-clave-larga-de-al-menos-12-caracteres
```

Usa una contraseña propia y segura. No publiques el archivo `.env`, no incluyas credenciales reales en Git y configura estas mismas variables como variables de entorno en el servicio de alojamiento.

5. Crear las tablas y el primer usuario:

```bash
php artisan migrate --force
php artisan db:seed --force
```

El seeder crea el SuperAdmin solo si el correo configurado todavía no existe. Ejecutarlo nuevamente no restablece la contraseña ni sobrescribe el perfil de una cuenta existente. Si el correo ya pertenece a un usuario que no es SuperAdmin, el seeder se detiene para evitar elevar permisos silenciosamente.

6. Iniciar el backend:

```bash
php artisan serve
```

El backend estará disponible localmente en `http://127.0.0.1:8000`.

## Frontend

El frontend está en la carpeta `frontend/`. Para desarrollo local, abrir `frontend/index.html` con Live Server (VS Code). La URL base de la API debe apuntar al backend local durante el desarrollo y a la URL pública del backend en producción.

## Funcionalidades principales

- Gestión de usuarios (SuperAdmin / Admin)
- Noticias con imágenes
- Eventos y calendario
- Contactos y categorías
- Documentos
- Historial de actividad
- Transmisiones en vivo dinámicas

## Notas

- La recuperación de contraseña requiere configurar el servicio de correo en `.env`.
- Para limpiar configuraciones almacenadas después de cambiar variables:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Respaldo y recuperación

Consultar [el procedimiento de respaldo PostgreSQL y multimedia](docs/respaldo-recuperacion.md). Guardar los respaldos fuera de Git y comprobar la restauración en una base aislada.

## Autor

Mauricio Roa
