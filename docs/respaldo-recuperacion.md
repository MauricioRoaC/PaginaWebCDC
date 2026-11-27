# Respaldo y recuperación

## Antes de comenzar

Usar datos ficticios para la defensa. Guardar los respaldos fuera del repositorio, en una ubicación privada cifrada. No compartir dumps, archivos .env ni credenciales. Instalar las herramientas cliente PostgreSQL de una versión compatible (pg_dump no debe ser anterior a la versión mayor del servidor).

## Respaldo local (PowerShell)

Desde la raíz del repositorio, detener temporalmente las escrituras (incluido el scheduler y otros procesos). Sustituir los datos de conexión por los de backend/.env; la contraseña se solicita interactivamente.

```powershell
$dest = Join-Path $HOME ("CDC-respaldos/" + (Get-Date -Format "yyyyMMdd-HHmmss"))
New-Item -ItemType Directory -Path $dest -ErrorAction Stop | Out-Null
pg_dump -h 127.0.0.1 -p 5432 -U postgres -W -F c --no-owner --no-privileges -f "$dest/database.dump" policiaDepCbb
if ($LASTEXITCODE -ne 0) { throw "Fallo el respaldo PostgreSQL" }
tar -czf "$dest/media.tar.gz" -C backend/storage/app/public .
if ($LASTEXITCODE -ne 0) { throw "Fallo el respaldo multimedia" }
pg_restore --list "$dest/database.dump"
if ($LASTEXITCODE -ne 0) { throw "Dump no legible" }
tar -tzf "$dest/media.tar.gz"
if ($LASTEXITCODE -ne 0) { throw "Archivo multimedia no legible" }
Get-FileHash "$dest/database.dump", "$dest/media.tar.gz" -Algorithm SHA256 | Export-Csv "$dest/checksums.csv" -NoTypeInformation
```

Si PUBLIC_STORAGE_ROOT está configurado, reemplazar backend/storage/app/public por esa ruta. Si se usa almacenamiento de objetos, exportar los objetos por separado conservando sus claves. Los documentos externos (file_url) no se incluyen: respaldarlos desde su proveedor si se cuenta con autorización. Guardar APP_KEY y configuración de recuperación por separado, cifradas; no regenerar la clave de una instalación restaurada sin evaluar datos cifrados.

## Recuperación de prueba (no sobre producción)

Crear una base nueva y vacía llamada cdc_restore_test, y un directorio multimedia nuevo. Usar el mismo código que generó el respaldo. En PowerShell, con $dest apuntando al respaldo:

```powershell
createdb -h 127.0.0.1 -p 5432 -U postgres -W cdc_restore_test
if ($LASTEXITCODE -ne 0) { throw "No se pudo crear la base de prueba" }
pg_restore -h 127.0.0.1 -p 5432 -U postgres -W --no-owner --no-privileges --exit-on-error --single-transaction -d cdc_restore_test "$dest/database.dump"
if ($LASTEXITCODE -ne 0) { throw "Fallo la restauracion" }
$media = Join-Path $dest "media-restaurada"
New-Item -ItemType Directory -Path $media -ErrorAction Stop | Out-Null
tar -xzf "$dest/media.tar.gz" -C "$media"
if ($LASTEXITCODE -ne 0) { throw "Fallo la extraccion" }
```

En una copia separada del backend, configurar DB_DATABASE=cdc_restore_test y PUBLIC_STORAGE_ROOT con la ruta absoluta de media-restaurada (usar barras / en .env), conservar APP_KEY original, ejecutar php artisan optimize:clear y php artisan storage:link. Si ya existe el enlace, verificar su destino antes de reemplazarlo. No ejecutar migrate:fresh ni seed sobre la base recuperada. No activar el scheduler ni correo real durante la prueba.

Verificar inicio de sesión, noticias e imágenes, eventos, contactos, mensajes y registros. Comparar cantidades con el origen. La lectura del dump y sus hashes no sustituyen una restauración real.

## Nube e institución

Para PostgreSQL remoto usar los parámetros y TLS exigidos por el proveedor (por ejemplo PGSSLMODE=require cuando corresponda); no publicar la contraseña ni la cadena de conexión. Realizar respaldo antes de cambios importantes y diariamente durante la defensa si hay cambios. En producción acordar frecuencia, retención, cifrado, responsables y pruebas periódicas con informática. Los archivos de almacenamiento público y la base deben corresponder al mismo punto de respaldo; detener escrituras o utilizar un mecanismo coordinado. No asumir que un plan gratuito ofrece copias automáticas.
