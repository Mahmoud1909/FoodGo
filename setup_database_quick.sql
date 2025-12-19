-- ============================================
-- سكربت سريع لإعداد قاعدة البيانات
-- ============================================
-- انسخ والصق هذا الكود في MySQL
-- ============================================

CREATE DATABASE IF NOT EXISTS foodgo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'laravel'@'localhost' IDENTIFIED BY '123456';

GRANT ALL PRIVILEGES ON foodgo.* TO 'laravel'@'localhost';

FLUSH PRIVILEGES;

-- التحقق من الصلاحيات
SHOW GRANTS FOR 'laravel'@'localhost';

-- عرض قواعد البيانات
SHOW DATABASES LIKE 'foodgo';

