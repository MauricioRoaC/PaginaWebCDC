#!/bin/sh
set -eu
cd /var/www/html
test -n "${APP_KEY:-}" || { echo "APP_KEY is required" >&2; exit 1; }
sed -i 's/^Listen 80$/Listen 10000/' /etc/apache2/ports.conf
mkdir -p "${PUBLIC_STORAGE_ROOT:-storage/app/public}"
chown www-data:www-data "${PUBLIC_STORAGE_ROOT:-storage/app/public}"
php artisan config:clear
php artisan migrate --force
if [ "${BOOTSTRAP_SUPERADMIN:-false}" = "true" ]; then
    php artisan db:seed --class=AdminUserSeeder --force
fi
if [ "${MEDIA_DRIVER:-local}" = "local" ] && [ ! -L public/storage ] && [ ! -e public/storage ]; then
    php artisan storage:link
fi
php artisan config:cache
# Rebuild Blade views from the deployed revision before serving requests.
php artisan view:clear
php artisan view:cache
chown -R www-data:www-data storage bootstrap/cache
php artisan news:publish-scheduled
# Run the scheduler while the web container is awake.
su -s /bin/sh www-data -c 'while true; do php artisan schedule:run --no-interaction; sleep 60; done' &
exec apache2-foreground
