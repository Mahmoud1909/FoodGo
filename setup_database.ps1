# ============================================
# سكربت PowerShell لإعداد قاعدة البيانات
# ============================================
# هذا السكربت يقوم بإعداد قاعدة البيانات foodgo تلقائياً
# ============================================

Write-Host "============================================" -ForegroundColor Cyan
Write-Host "إعداد قاعدة البيانات foodgo" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

# التحقق من وجود MySQL
Write-Host "التحقق من وجود MySQL..." -ForegroundColor Yellow
$mysqlPath = Get-Command mysql -ErrorAction SilentlyContinue

if (-not $mysqlPath) {
    Write-Host "❌ MySQL غير موجود في PATH" -ForegroundColor Red
    Write-Host "يرجى تثبيت MySQL أو إضافته إلى PATH" -ForegroundColor Red
    Write-Host ""
    Write-Host "يمكنك تنفيذ الأوامر يدوياً:" -ForegroundColor Yellow
    Write-Host "mysql -u root -p" -ForegroundColor White
    Write-Host "ثم انسخ والصق محتوى ملف setup_database.sql" -ForegroundColor White
    exit 1
}

Write-Host "✅ MySQL موجود" -ForegroundColor Green
Write-Host ""

# طلب كلمة مرور root
Write-Host "يرجى إدخال كلمة مرور MySQL root:" -ForegroundColor Yellow
$rootPassword = Read-Host -AsSecureString
$rootPasswordPlain = [Runtime.InteropServices.Marshal]::PtrToStringAuto(
    [Runtime.InteropServices.Marshal]::SecureStringToBSTR($rootPassword)
)

Write-Host ""
Write-Host "جارٍ إنشاء قاعدة البيانات والمستخدم..." -ForegroundColor Yellow

# إنشاء ملف SQL مؤقت
$tempSqlFile = [System.IO.Path]::GetTempFileName() + ".sql"
$sqlContent = @"
CREATE DATABASE IF NOT EXISTS foodgo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'laravel'@'localhost' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON foodgo.* TO 'laravel'@'localhost';
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'laravel'@'localhost';
"@

$sqlContent | Out-File -FilePath $tempSqlFile -Encoding UTF8

try {
    # تنفيذ الأوامر SQL
    $process = Start-Process -FilePath "mysql" -ArgumentList "-u", "root", "-p$rootPasswordPlain", "-e", "source $tempSqlFile" -NoNewWindow -Wait -PassThru -RedirectStandardOutput "mysql_output.txt" -RedirectStandardError "mysql_error.txt"
    
    if ($process.ExitCode -eq 0) {
        Write-Host "✅ تم إنشاء قاعدة البيانات والمستخدم بنجاح!" -ForegroundColor Green
        Write-Host ""
        Write-Host "البيانات:" -ForegroundColor Cyan
        Write-Host "  قاعدة البيانات: foodgo" -ForegroundColor White
        Write-Host "  المستخدم: laravel" -ForegroundColor White
        Write-Host "  كلمة المرور: 123456" -ForegroundColor White
        Write-Host ""
        Write-Host "✅ ملف .env محدث بالفعل!" -ForegroundColor Green
        Write-Host ""
        Write-Host "الخطوة التالية:" -ForegroundColor Yellow
        Write-Host "  php artisan config:clear" -ForegroundColor White
        Write-Host "  php artisan cache:clear" -ForegroundColor White
        Write-Host "  php artisan migrate" -ForegroundColor White
    } else {
        Write-Host "❌ حدث خطأ أثناء تنفيذ الأوامر" -ForegroundColor Red
        if (Test-Path "mysql_error.txt") {
            Write-Host "تفاصيل الخطأ:" -ForegroundColor Red
            Get-Content "mysql_error.txt" | Write-Host -ForegroundColor Red
        }
    }
} catch {
    Write-Host "❌ خطأ: $_" -ForegroundColor Red
    Write-Host ""
    Write-Host "يمكنك تنفيذ الأوامر يدوياً:" -ForegroundColor Yellow
    Write-Host "mysql -u root -p" -ForegroundColor White
    Write-Host "ثم انسخ والصق محتوى ملف setup_database.sql" -ForegroundColor White
} finally {
    # حذف الملف المؤقت
    if (Test-Path $tempSqlFile) {
        Remove-Item $tempSqlFile -Force
    }
    if (Test-Path "mysql_output.txt") {
        Remove-Item "mysql_output.txt" -Force
    }
    if (Test-Path "mysql_error.txt") {
        Remove-Item "mysql_error.txt" -Force
    }
}

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan

