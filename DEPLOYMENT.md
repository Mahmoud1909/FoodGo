Production deployment checklist

- Ensure PHP >= 8.1 is installed on the server.
- Ensure these PHP extensions are enabled: `ext-json`, `ext-curl`, `ext-openssl`, `ext-mbstring`.
- Upload project files (do NOT overwrite `vendor/` unless you intend to install vendors on the server).

Server-side commands (run in project root):

1) If you upload the repository but not `vendor/`, install composer dependencies:

```bash
composer install --no-dev --optimize-autoloader --no-interaction
```

2) Generate Laravel optimized files:

```bash
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3) Place your Firebase service account JSON at:

`storage/app/firebase/service-account.json`

4) File permissions (Linux):

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

6) Restart PHP-FPM / web server after env changes.

Troubleshooting: 
- If you see "Firebase initialization error" related to service account, ensure the JSON exists at `storage/app/firebase/service-account.json` and is readable by PHP.
- If `composer install` fails on the server, upload the `vendor/` folder from a build server (where composer succeeded) or fix the server's Composer/SSH permissions.

Optional: run the included PowerShell helper `install-vendors.ps1` on Windows servers to install composer if available.
