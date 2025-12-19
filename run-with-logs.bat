@echo off
echo ========================================
echo Starting Laravel Server with Logs
echo ========================================
echo.
echo This will start the Laravel development server
echo and show all logs in the terminal.
echo.
echo Press Ctrl+C to stop the server
echo.
echo ========================================
echo.

REM Clear Laravel logs
if exist storage\logs\laravel.log del storage\logs\laravel.log

REM Start Laravel server with verbose output
php artisan serve --host=127.0.0.1 --port=8000

pause

