-- ============================================
-- سكربت إعداد قاعدة البيانات
-- ============================================
-- استخدم هذا الملف لإعداد قاعدة البيانات بسرعة
-- 
-- طريقة الاستخدام:
-- 1. افتح MySQL: mysql -u root -p
-- 2. نفّذ هذا الملف: source setup_database.sql
-- أو انسخ والصق الأوامر مباشرة
-- ============================================

-- إنشاء قاعدة البيانات (إذا لم تكن موجودة)
CREATE DATABASE IF NOT EXISTS foodgo 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

-- استخدام قاعدة البيانات
USE foodgo;

-- إنشاء المستخدم (إذا لم يكن موجوداً)
-- ⚠️ كلمة المرور: 123456 (مطابقة لملف .env)
CREATE USER IF NOT EXISTS 'laravel'@'localhost' 
    IDENTIFIED BY '123456';

-- إعطاء جميع الصلاحيات للمستخدم على قاعدة البيانات
GRANT ALL PRIVILEGES ON foodgo.* TO 'laravel'@'localhost';

-- تحديث الصلاحيات
FLUSH PRIVILEGES;

-- التحقق من الصلاحيات
SHOW GRANTS FOR 'laravel'@'localhost';

-- عرض قواعد البيانات (للتحقق)
SHOW DATABASES;

-- عرض المستخدمين (للتحقق)
SELECT User, Host FROM mysql.user WHERE User='laravel';

-- ============================================
-- ملاحظات:
-- ============================================
-- 1. بعد تنفيذ هذا السكربت، حدّث ملف .env:
--    DB_DATABASE=foodgo
--    DB_USERNAME=laravel
--    DB_PASSWORD=123456
--
-- 2. ثم شغّل: php artisan migrate
-- ============================================

