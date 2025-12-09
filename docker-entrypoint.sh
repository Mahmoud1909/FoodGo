#!/bin/bash
set -e

# الانتظار حتى تكون قاعدة البيانات جاهزة (اختياري)
# يمكنك إضافة health check هنا إذا لزم الأمر

# الانتقال إلى مجلد المشروع
cd /var/www/html

# إنشاء مجلدات التخزين إذا لم تكن موجودة
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache
mkdir -p storage/app/firebase

# إنشاء service-account.json من Environment Variable إذا كان موجوداً
if [ -n "$FIREBASE_SERVICE_ACCOUNT" ]; then
    echo "Creating service-account.json from environment variable..."
    echo "$FIREBASE_SERVICE_ACCOUNT" > storage/app/firebase/service-account.json
    chmod 600 storage/app/firebase/service-account.json
    echo "service-account.json created successfully"
elif [ -n "$FIREBASE_SERVICE_ACCOUNT_BASE64" ]; then
    echo "Creating service-account.json from base64 encoded environment variable..."
    echo "$FIREBASE_SERVICE_ACCOUNT_BASE64" | base64 -d > storage/app/firebase/service-account.json
    chmod 600 storage/app/firebase/service-account.json
    echo "service-account.json created successfully from base64"
fi

# إصلاح الصلاحيات
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# تنظيف الكاش (فقط إذا كان Laravel مثبت بشكل صحيح)
if [ -f "artisan" ]; then
    echo "Laravel detected, initializing..."
    
    # تنظيف الكاش
    php artisan config:clear 2>/dev/null || true
    php artisan cache:clear 2>/dev/null || true
    php artisan route:clear 2>/dev/null || true
    php artisan view:clear 2>/dev/null || true
    
    # إنشاء APP_KEY إذا لم يكن موجوداً
    if [ -z "$APP_KEY" ] || [ "$APP_KEY" == "" ]; then
        echo "APP_KEY not found, generating..."
        php artisan key:generate --force 2>/dev/null || echo "Warning: Could not generate APP_KEY"
    fi
    
    # تهيئة الكاش (فقط في production)
    if [ "$APP_ENV" == "production" ]; then
        echo "Production environment detected, caching configuration..."
        php artisan config:cache 2>/dev/null || true
        php artisan route:cache 2>/dev/null || true
        php artisan view:cache 2>/dev/null || true
    fi
else
    echo "Warning: Laravel artisan file not found, skipping Laravel initialization"
fi

# التعامل مع PORT الديناميكي من Railway
# Railway يمرر PORT كمتغير بيئة
if [ -n "$PORT" ] && [ "$PORT" != "80" ]; then
    echo "Configuring Apache to listen on port $PORT"
    # تعديل Apache للاستماع على PORT الديناميكي
    # إضافة Listen directive جديد إذا لم يكن موجوداً
    if ! grep -q "Listen $PORT" /etc/apache2/ports.conf; then
        echo "Listen $PORT" >> /etc/apache2/ports.conf
    fi
    # تعديل VirtualHost للاستماع على PORT الجديد
    sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/g" /etc/apache2/sites-available/000-default.conf
    echo "Apache configured to listen on port $PORT"
else
    echo "Using default port 80 (PORT=$PORT)"
fi

# بدء Apache
exec apache2-foreground

