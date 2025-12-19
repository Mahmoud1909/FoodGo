# PowerShell helper to run composer install on Windows servers
# Run from project root in an elevated PowerShell session

if (-not (Get-Command composer -ErrorAction SilentlyContinue)) {
    Write-Error "Composer not found in PATH. Install Composer or upload vendor/ from builder machine."
    exit 1
}

composer install --no-dev --optimize-autoloader --no-interaction

if ($LASTEXITCODE -ne 0) {
    Write-Error "Composer install failed with exit code $LASTEXITCODE"
    exit $LASTEXITCODE
}

Write-Output "Composer install completed. Run php artisan config:cache and restart your webserver."