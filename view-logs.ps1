# PowerShell script to view Laravel logs in real-time
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Laravel Logs Viewer - Real-time" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Viewing logs from: storage\logs\laravel.log" -ForegroundColor Yellow
Write-Host "Press Ctrl+C to stop" -ForegroundColor Yellow
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Check if log file exists
if (-not (Test-Path "storage\logs\laravel.log")) {
    Write-Host "⚠️  Log file not found. Creating it..." -ForegroundColor Yellow
    New-Item -Path "storage\logs\laravel.log" -ItemType File -Force | Out-Null
    Write-Host "✅ Log file created. Waiting for logs..." -ForegroundColor Green
    Start-Sleep -Seconds 2
}

# Display logs in real-time
try {
    Get-Content "storage\logs\laravel.log" -Wait -Tail 50 | ForEach-Object {
        # Color code different log levels
        if ($_ -match "ERROR|CRITICAL|ALERT|EMERGENCY") {
            Write-Host $_ -ForegroundColor Red
        } elseif ($_ -match "WARNING|WARN") {
            Write-Host $_ -ForegroundColor Yellow
        } elseif ($_ -match "INFO|NOTICE") {
            Write-Host $_ -ForegroundColor Green
        } elseif ($_ -match "DEBUG") {
            Write-Host $_ -ForegroundColor Cyan
        } else {
            Write-Host $_ -ForegroundColor White
        }
    }
} catch {
    Write-Host "❌ Error reading log file: $_" -ForegroundColor Red
    Write-Host "Press any key to exit..." -ForegroundColor Yellow
    $null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
}

