@echo off
echo ========================================
echo Clearing Laravel Caches...
echo ========================================
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear

echo.
echo ========================================
echo Starting Laravel Server with Logs...
echo ========================================
echo.

start "Laravel Logs" powershell -Command "Get-Content storage\logs\laravel.log -Wait -Tail 50"
timeout /t 2 /nobreak >nul

php artisan serve --host=127.0.0.1 --port=8001
