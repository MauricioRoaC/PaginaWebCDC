# Pagina Web - Comando Departamental de Cochabamba

Pagina web desarrollado con Laravel (backend) y HTML/CSS/JS (frontend) para la gestión de noticias, eventos, usuarios, contactos y transmisiones en vivo.

---

## Estructura del proyecto


backend/ → Laravel (panel administrativo)
frontend/ → Página web pública


---

## Requisitos

- PHP >= 8.2
- Composer
- PostgreSQL
- Git
- Navegador web

---

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/MauricioRoaC/PaginaWebCDC.git
```
```bash
cd PaginaWebCDC/backend
```

---

### 2. Instalar dependencias

```bash
composer install
```

---

### 3. Crear archivo .env

```bash
cp .env.example .env
```

---

### 4. Configurar base de datos

Editar el archivo `.env`:
IMPORTANTE: Crear una base de datos en PostgreSQL antes de continuar.

Ejemplo:
```SQL
CREATE DATABASE policiaDepCbb;
```

```php
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=policiaDepCbb
DB_USERNAME=postgres
DB_PASSWORD=tu_password
```

---

### 5. Generar clave de aplicación

```bash
php artisan key:generate
```

---

### 6. Ejecutar migraciones

```bash
php artisan migrate
```

---

### 7. Crear usuario administrador

```bash
php artisan db:seed
```

---

### Credenciales de acceso

```php
Email: admin@admin.com

Password: 12345678
```

---

### 8. Ejecutar servidor

```bash
php artisan serve
```

👉 Backend disponible en:
```bash
http://127.0.0.1:8000
```
---

## 🌐 Frontend

Abrir el archivo:

```html
frontend/index.html
```

👉 Se recomienda usar **Live Server (VS Code)**

---

## Transmisiones en vivo

El sistema permite:

- Agregar lives desde el panel admin
- Detectar automáticamente:
  - TikTok (link)
  - Facebook (iframe)
- Mostrar solo si está activo

---

## Funcionalidades principales

- Gestión de usuarios (superadmin / admin)
- Noticias con imágenes
- Eventos
- Contactos y categorías
- Documentos
- Historial de actividad
- Transmisiones en vivo dinámicas

---

## ⚠️ Notas

- El correo para recuperación de contraseña requiere configuración en `.env`
- Si no se configura, el sistema sigue funcionando normalmente
- No se incluye `.env` por seguridad
Si ocurre algún error, ejecutar:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```
---

## Autor

Mauricio Roa
