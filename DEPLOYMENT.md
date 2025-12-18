Production deployment checklist

- Ensure PHP >= 8.1 is installed on the server.
- Ensure these PHP extensions are enabled: `ext-json`, `ext-curl`, `ext-openssl`, `ext-mbstring`.
- Upload project files (do NOT overwrite `vendor/` unless you intend to install vendors on the server).

Server-side commands (run in project root):

1) If you upload the repository but not `vendor/`, install composer dependencies:

```bash
composer install --no-dev --optimize-autoloader --no-interaction
```

2) If you changed `composer.json` (we added `google/cloud-firestore`), you can run:

```bash
composer update --no-dev --optimize-autoloader --no-interaction
```

3) Generate Laravel optimized files:

```bash
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

4) Set the Google credentials environment variable (point to the JSON file with service account key):

On Linux (systemd/nginx):

```bash
export GOOGLE_APPLICATION_CREDENTIALS=/path/to/google-service-account.json
# or add to php-fpm/www.conf or systemd unit
```

On Windows (IIS/PowerShell):

```powershell
setx GOOGLE_APPLICATION_CREDENTIALS "C:\path\to\google-service-account.json" /M
```

5) File permissions (Linux):

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

6) Restart PHP-FPM / web server after env changes.

Troubleshooting: 
- If you still see "Class Google\\Cloud\\Firestore\\FirestoreClient not found", ensure `vendor/google/cloud-firestore` exists and contains `src/FirestoreClient.php`.
- If `composer install` fails on the server, upload the `vendor/` folder from a build server (where composer succeeded) or fix the server's Composer/SSH permissions.

Optional: run the included PowerShell helper `install-vendors.ps1` on Windows servers to install composer if available.
