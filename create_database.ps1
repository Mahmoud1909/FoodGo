# ============================================
# سكربت إنشاء قاعدة البيانات foodgo
# ============================================

Write-Host "============================================" -ForegroundColor Cyan
Write-Host "إنشاء قاعدة البيانات foodgo" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

# التحقق من وجود MySQL
$mysqlPath = Get-Command mysql -ErrorAction SilentlyContinue
if (-not $mysqlPath) {
    Write-Host "❌ MySQL غير موجود في PATH" -ForegroundColor Red
    Write-Host ""
    Write-Host "يرجى تنفيذ الأوامر التالية يدوياً:" -ForegroundColor Yellow
    Write-Host "mysql -u root -p" -ForegroundColor White
    Write-Host ""
    Write-Host "ثم انسخ والصق:" -ForegroundColor Yellow
    Get-Content setup_database_quick.sql | Write-Host -ForegroundColor White
    exit 1
}

Write-Host "✅ MySQL موجود" -ForegroundColor Green
Write-Host ""

# طلب كلمة مرور root
Write-Host "يرجى إدخال كلمة مرور MySQL root:" -ForegroundColor Yellow
$securePassword = Read-Host -AsSecureString
$bstr = [System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($securePassword)
$rootPassword = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto($bstr)

Write-Host ""
Write-Host "جارٍ إنشاء قاعدة البيانات والمستخدم..." -ForegroundColor Yellow

# قراءة محتوى ملف SQL
$sqlFile = "setup_database_quick.sql"
if (-not (Test-Path $sqlFile)) {
    Write-Host "❌ ملف $sqlFile غير موجود!" -ForegroundColor Red
    exit 1
}

$sqlCommands = Get-Content $sqlFile -Raw

# إنشاء ملف SQL مؤقت بدون EXIT
$tempSqlFile = [System.IO.Path]::GetTempFileName() + ".sql"
$sqlCommands | Out-File -FilePath $tempSqlFile -Encoding UTF8

try {
    # تنفيذ الأوامر SQL
    $arguments = "-u root -p$rootPassword"
    $process = Start-Process -FilePath "mysql" -ArgumentList $arguments -NoNewWindow -Wait -PassThru -RedirectStandardInput $tempSqlFile -RedirectStandardOutput "mysql_output.txt" -RedirectStandardError "mysql_error.txt"
    
    # طريقة أخرى: استخدام pipe
    $sqlCommands | & mysql -u root -p$rootPassword 2>&1 | Out-File "mysql_result.txt"
    
    if (Test-Path "mysql_result.txt") {
        $result = Get-Content "mysql_result.txt" -Raw
        if ($result -match "GRANT" -or $result -eq "" -or $LASTEXITCODE -eq 0) {
            Write-Host "✅ تم إنشاء قاعدة البيانات والمستخدم بنجاح!" -ForegroundColor Green
        } else {
            if ($result -match "already exists" -or $result -match "exists") {
                Write-Host "⚠️  قاعدة البيانات أو المستخدم موجود بالفعل" -ForegroundColor Yellow
                Write-Host "✅ هذا جيد، لا مشكلة!" -ForegroundColor Green
            } else {
                Write-Host "⚠️  قد تكون هناك مشكلة" -ForegroundColor Yellow
                Write-Host "النتيجة: $result" -ForegroundColor Gray
            }
        }
        Remove-Item "mysql_result.txt" -Force -ErrorAction SilentlyContinue
    }
    
    # التحقق من الأخطاء
    if (Test-Path "mysql_error.txt") {
        $error = Get-Content "mysql_error.txt" -Raw
        if ($error -and $error -notmatch "Using a password") {
            if ($error -match "already exists") {
                Write-Host "✅ قاعدة البيانات أو المستخدم موجود بالفعل" -ForegroundColor Green
            } else {
                Write-Host "⚠️  تحذير: $error" -ForegroundColor Yellow
            }
        }
        Remove-Item "mysql_error.txt" -Force -ErrorAction SilentlyContinue
    }
    
    Remove-Item "mysql_output.txt" -Force -ErrorAction SilentlyContinue
    
} catch {
    Write-Host "⚠️  لا يمكن تنفيذ الأوامر تلقائياً" -ForegroundColor Yellow
    Write-Host "الخطأ: $_" -ForegroundColor Red
    Write-Host ""
    Write-Host "يرجى تنفيذ الأوامر التالية يدوياً:" -ForegroundColor Cyan
    Write-Host "mysql -u root -p" -ForegroundColor White
    Write-Host ""
    Write-Host "ثم انسخ والصق:" -ForegroundColor Cyan
    Write-Host $sqlCommands -ForegroundColor White
} finally {
    if (Test-Path $tempSqlFile) {
        Remove-Item $tempSqlFile -Force -ErrorAction SilentlyContinue
    }
}

Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "✅ تم الانتهاء!" -ForegroundColor Green
Write-Host ""
Write-Host "الخطوة التالية:" -ForegroundColor Yellow
Write-Host "  php artisan migrate" -ForegroundColor White
Write-Host ""
Write-Host "============================================" -ForegroundColor Cyan

