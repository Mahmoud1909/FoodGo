@echo off
echo ========================================
echo Laravel Logs Viewer - Real-time
echo ========================================
echo.
echo Viewing logs from: storage\logs\laravel.log
echo Press Ctrl+C to stop
echo.
echo ========================================
echo.

REM Check if log file exists
if not exist storage\logs\laravel.log (
    echo Creating log file...
    echo. > storage\logs\laravel.log
    echo Waiting for logs...
    timeout /t 2 /nobreak >nul
)

REM Display logs in real-time using PowerShell
powershell -ExecutionPolicy Bypass -Command "Get-Content storage\logs\laravel.log -Wait -Tail 50"

pause

