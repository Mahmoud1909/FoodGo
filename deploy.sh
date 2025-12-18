#!/bin/bash

# Foodie Admin Panel - Deployment Script
# استخدم هذا السكريبت لتسهيل عملية النشر

echo "🚀 بدء عملية النشر..."

# الألوان للرسائل
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# التحقق من وجود Composer
if ! command -v composer &> /dev/null; then
    echo -e "${RED}❌ Composer غير مثبت${NC}"
    exit 1
fi

# التحقق من وجود Node
if ! command -v node &> /dev/null; then
    echo -e "${RED}❌ Node.js غير مثبت${NC}"
    exit 1
fi

# التحقق من وجود .env
if [ ! -f .env ]; then
    echo -e "${YELLOW}⚠️  ملف .env غير موجود. نسخ من .env.example...${NC}"
    cp .env.example .env
    echo -e "${GREEN}✅ تم إنشاء .env${NC}"
    echo -e "${YELLOW}⚠️  يرجى تحديث ملف .env بإعدادات الإنتاج قبل المتابعة${NC}"
    read -p "هل قمت بتحديث .env؟ (y/n): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        echo -e "${RED}❌ تم الإلغاء${NC}"
        exit 1
    fi
fi

# 1. تحديث التبعيات
echo -e "${YELLOW}📦 تحديث التبعيات...${NC}"
composer install --optimize-autoloader --no-dev
if [ $? -ne 0 ]; then
    echo -e "${RED}❌ فشل تحديث التبعيات${NC}"
    exit 1
fi
echo -e "${GREEN}✅ تم تحديث التبعيات${NC}"

# 2. إنشاء APP_KEY إذا لم يكن موجوداً
if ! grep -q "APP_KEY=base64:" .env; then
    echo -e "${YELLOW}🔑 إنشاء مفتاح التطبيق...${NC}"
    php artisan key:generate
    echo -e "${GREEN}✅ تم إنشاء المفتاح${NC}"
fi

# 3. بناء الأصول
echo -e "${YELLOW}🎨 بناء الأصول...${NC}"
npm install
if [ $? -ne 0 ]; then
    echo -e "${RED}❌ فشل تثبيت npm packages${NC}"
    exit 1
fi

npm run build
if [ $? -ne 0 ]; then
    echo -e "${YELLOW}⚠️  محاولة npm run production...${NC}"
    npm run production
fi
echo -e "${GREEN}✅ تم بناء الأصول${NC}"

# 4. تشغيل Migrations
echo -e "${YELLOW}🗄️  تشغيل Migrations...${NC}"
read -p "هل تريد تشغيل migrations؟ (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan migrate --force
    if [ $? -ne 0 ]; then
        echo -e "${RED}❌ فشل migrations${NC}"
        exit 1
    fi
    echo -e "${GREEN}✅ تم تشغيل migrations${NC}"
fi

# 5. تحسين الأداء
echo -e "${YELLOW}⚡ تحسين الأداء...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo -e "${GREEN}✅ تم تحسين الأداء${NC}"

# 6. إعداد الصلاحيات
echo -e "${YELLOW}🔐 إعداد الصلاحيات...${NC}"
chmod -R 755 storage bootstrap/cache
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ تم إعداد الصلاحيات${NC}"
else
    echo -e "${YELLOW}⚠️  قد تحتاج صلاحيات sudo لإعداد الصلاحيات${NC}"
fi

echo -e "${GREEN}🎉 تم الانتهاء من عملية النشر بنجاح!${NC}"
echo -e "${YELLOW}⚠️  تذكر:${NC}"
echo -e "  1. تأكد من APP_DEBUG=false في .env"
echo -e "  2. تأكد من APP_ENV=production في .env"
echo -e "  3. تأكد من تفعيل SSL (HTTPS)"
echo -e "  4. اختبر الموقع بالكامل"

