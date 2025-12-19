@echo off
REM Foodie Admin Panel - Deployment Script for Windows
REM استخدم هذا السكريبت لتسهيل عملية النشر على Windows

echo 🚀 بدء عملية النشر...

REM التحقق من وجود Composer
where composer >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ❌ Composer غير مثبت
    pause
    exit /b 1
)

REM التحقق من وجود Node
where node >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ❌ Node.js غير مثبت
    pause
    exit /b 1
)

REM التحقق من وجود .env
if not exist .env (
    echo ⚠️  ملف .env غير موجود. نسخ من .env.example...
    copy .env.example .env
    echo ✅ تم إنشاء .env
    echo ⚠️  يرجى تحديث ملف .env بإعدادات الإنتاج قبل المتابعة
    pause
)

REM 1. تحديث التبعيات
echo 📦 تحديث التبعيات...
call composer install --optimize-autoloader --no-dev
if %ERRORLEVEL% NEQ 0 (
    echo ❌ فشل تحديث التبعيات
    pause
    exit /b 1
)
echo ✅ تم تحديث التبعيات

REM 2. إنشاء APP_KEY إذا لم يكن موجوداً
findstr /C:"APP_KEY=base64:" .env >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo 🔑 إنشاء مفتاح التطبيق...
    php artisan key:generate
    echo ✅ تم إنشاء المفتاح
)

REM 3. بناء الأصول
echo 🎨 بناء الأصول...
call npm install
if %ERRORLEVEL% NEQ 0 (
    echo ❌ فشل تثبيت npm packages
    pause
    exit /b 1
)

call npm run build
if %ERRORLEVEL% NEQ 0 (
    echo ⚠️  محاولة npm run production...
    call npm run production
)
echo ✅ تم بناء الأصول

REM 4. تحسين الأداء
echo ⚡ تحسين الأداء...
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo ✅ تم تحسين الأداء

echo.
echo 🎉 تم الانتهاء من عملية النشر بنجاح!
echo.
echo ⚠️  تذكر:
echo   1. تأكد من APP_DEBUG=false في .env
echo   2. تأكد من APP_ENV=production في .env
echo   3. تأكد من تفعيل SSL (HTTPS)
echo   4. اختبر الموقع بالكامل
echo.
pause

