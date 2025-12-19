# PowerShell script to run Laravel with logs
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Starting Laravel Server with Logs" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Clear Laravel logs
if (Test-Path "storage\logs\laravel.log") {
    Remove-Item "storage\logs\laravel.log" -Force
    Write-Host "Cleared Laravel logs" -ForegroundColor Green
}

# Start Laravel server in background job
Write-Host "Starting Laravel server on http://127.0.0.1:8000" -ForegroundColor Green
Write-Host "Press Ctrl+C to stop" -ForegroundColor Yellow
Write-Host ""

# Start server in background
$job = Start-Job -ScriptBlock {
    Set-Location $using:PWD
    php artisan serve --host=127.0.0.1 --port=8000
}

# Wait a moment for server to start
Start-Sleep -Seconds 2

# Monitor log file
Write-Host "Monitoring Laravel logs..." -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

try {
    Get-Content "storage\logs\laravel.log" -Wait -Tail 50 -ErrorAction SilentlyContinue | ForEach-Object {
        Write-Host $_ -ForegroundColor White
    }
} catch {
    Write-Host "Waiting for log file to be created..." -ForegroundColor Yellow
    Start-Sleep -Seconds 2
    Get-Content "storage\logs\laravel.log" -Wait -Tail 50 | ForEach-Object {
        Write-Host $_ -ForegroundColor White
    }
} finally {
    # Stop the background job when script exits
    Stop-Job $job -ErrorAction SilentlyContinue
    Remove-Job $job -ErrorAction SilentlyContinue
}

