# ============================================
# Script to Fix Database Connection
# ============================================

Write-Host "============================================" -ForegroundColor Cyan
Write-Host "Fixing Database Connection" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

# Step 1: Create SQL file
Write-Host "Creating SQL file..." -ForegroundColor Yellow

$sqlContent = @"
CREATE DATABASE IF NOT EXISTS foodgo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'laravel'@'localhost' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON foodgo.* TO 'laravel'@'localhost';
FLUSH PRIVILEGES;
SHOW DATABASES LIKE 'foodgo';
SELECT User, Host FROM mysql.user WHERE User='laravel';
"@

$sqlFile = "fix_database_temp.sql"
$sqlContent | Out-File -FilePath $sqlFile -Encoding ASCII

Write-Host "SQL file created: $sqlFile" -ForegroundColor Green
Write-Host ""

# Step 2: Execute SQL
Write-Host "Executing SQL commands..." -ForegroundColor Yellow
Write-Host "You will be prompted for MySQL root password" -ForegroundColor Yellow
Write-Host ""
Write-Host "Please run this command manually:" -ForegroundColor Cyan
Write-Host "  mysql -u root -p < $sqlFile" -ForegroundColor White
Write-Host ""
Write-Host "Or copy and paste these SQL commands into MySQL:" -ForegroundColor Cyan
Write-Host $sqlContent -ForegroundColor White
Write-Host ""

# Step 3: Clean up temp file
Write-Host "SQL file saved. You can delete it after use." -ForegroundColor Gray
Write-Host ""

# Step 4: Update .env instructions
Write-Host "============================================" -ForegroundColor Yellow
Write-Host "Update .env file with these settings:" -ForegroundColor Yellow
Write-Host "============================================" -ForegroundColor Yellow
Write-Host ""
Write-Host "DB_CONNECTION=mysql" -ForegroundColor Cyan
Write-Host "DB_HOST=127.0.0.1" -ForegroundColor Cyan
Write-Host "DB_PORT=3306" -ForegroundColor Cyan
Write-Host "DB_DATABASE=foodgo" -ForegroundColor Cyan
Write-Host "DB_USERNAME=laravel" -ForegroundColor Cyan
Write-Host "DB_PASSWORD=123456" -ForegroundColor Cyan
Write-Host ""

# Step 5: Clear cache
Write-Host "Clearing Laravel cache..." -ForegroundColor Yellow
try {
    php artisan config:clear 2>&1 | Out-Null
    php artisan cache:clear 2>&1 | Out-Null
    Write-Host "Cache cleared successfully!" -ForegroundColor Green
} catch {
    Write-Host "Could not clear cache. Make sure PHP is in PATH." -ForegroundColor Yellow
}

Write-Host ""

# Step 6: Test connection
Write-Host "============================================" -ForegroundColor Green
Write-Host "Next Steps:" -ForegroundColor Green
Write-Host "============================================" -ForegroundColor Green
Write-Host ""
Write-Host "1. Run the SQL commands (see above)" -ForegroundColor White
Write-Host "2. Update .env file with database credentials" -ForegroundColor White
Write-Host "3. Run: php artisan config:clear" -ForegroundColor White
Write-Host "4. Run: php artisan migrate" -ForegroundColor White
Write-Host "5. Test the website: http://127.0.0.1:8080" -ForegroundColor White
Write-Host ""
