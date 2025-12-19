CREATE DATABASE IF NOT EXISTS foodgo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'laravel'@'localhost' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON foodgo.* TO 'laravel'@'localhost';
FLUSH PRIVILEGES;
SHOW DATABASES LIKE 'foodgo';
SELECT User, Host FROM mysql.user WHERE User='laravel';
