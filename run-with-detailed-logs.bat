@echo off
echo ========================================
echo Starting Laravel Server with Detailed Logs
echo ========================================
echo.
echo This will:
echo - Start the Laravel development server
echo - Show all PHP errors and warnings
echo - Show all Laravel logs in real-time
echo - Show all database queries
echo - Show all Firestore/Firebase logs
echo.
echo Press Ctrl+C to stop the server
echo.
echo ========================================
echo.

REM Set environment to show all errors
set APP_DEBUG=true
set APP_ENV=local
set LOG_LEVEL=debug

REM Clear Laravel logs
if exist storage\logs\laravel.log del storage\logs\laravel.log

REM Start watching Laravel log file in a separate window
start "Laravel Logs" cmd /k "powershell -Command Get-Content storage\logs\laravel.log -Wait -Tail 50"

REM Wait a moment for log window to open
timeout /t 2 /nobreak >nul

REM Start Laravel server
echo Starting Laravel server on http://127.0.0.1:8000
echo.
echo Open another terminal and run: tail -f storage\logs\laravel.log
echo.
php artisan serve --host=127.0.0.1 --port=8000

pause

