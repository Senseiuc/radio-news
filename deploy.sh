#!/bin/bash

# --- Set up your paths ---
APP_DIR="/home/transglobal/public_html/transglobal_backyard"

echo "==> Deploying Laravel project to $APP_DIR"

# --- Move into your Laravel project folder ---
cd "$APP_DIR" || exit

# --- Pull latest changes (if using Git) ---
# git pull origin main

# --- Install/update PHP dependencies ---
/opt/cpanel/ea-php82/root/usr/bin/php /opt/cpanel/composer/bin/composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

# --- Run Laravel commands ---
/opt/cpanel/ea-php82/root/usr/bin/php artisan migrate --force
/opt/cpanel/ea-php82/root/usr/bin/php artisan config:clear
/opt/cpanel/ea-php82/root/usr/bin/php artisan config:cache
/opt/cpanel/ea-php82/root/usr/bin/php artisan route:clear
/opt/cpanel/ea-php82/root/usr/bin/php artisan route:cache
/opt/cpanel/ea-php82/root/usr/bin/php artisan view:clear
/opt/cpanel/ea-php82/root/usr/bin/php artisan view:cache
/opt/cpanel/ea-php82/root/usr/bin/php artisan cache:clear
#/opt/cpanel/ea-php82/root/usr/bin/php artisan db:seed --force
#/opt/cpanel/ea-php82/root/usr/bin/php artisan db:seed --class=TariffSeeder

echo "✅ Deployment complete."
