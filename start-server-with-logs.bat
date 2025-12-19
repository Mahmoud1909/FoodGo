@echo off
echo ========================================
echo Clearing Laravel Caches...
echo ========================================
call php artisan config:clear
call php artisan cache:clear
call php artisan view:clear
call php artisan route:clear
call php artisan optimize:clear

echo.
echo ========================================
echo Starting Laravel Server on port 8001...
echo ========================================
echo.
echo Server will be available at: http://127.0.0.1:8001
echo Press Ctrl+C to stop the server
echo.
echo ========================================
echo Server Logs:
echo ========================================
echo.

call php artisan serve --host=127.0.0.1 --port=8001
