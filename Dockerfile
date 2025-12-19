# Dockerfile for Laravel Application on Render
# استخدام PHP 8.2 مع Apache

FROM php:8.2-apache

# تثبيت التبعيات المطلوبة
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تثبيت Node.js و NPM
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# تفعيل mod_rewrite في Apache
RUN a2enmod rewrite

# تعيين مجلد العمل
WORKDIR /var/www/html

# نسخ ملفات المشروع
COPY . /var/www/html

# نسخ entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# تثبيت تبعيات PHP
RUN composer install --optimize-autoloader --no-dev --no-interaction

# تثبيت تبعيات Node.js وبناء الأصول
RUN npm install --legacy-peer-deps && npm run production

# إعداد الصلاحيات
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# تعيين متغيرات البيئة الافتراضية
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# إعداد Apache للعمل مع Laravel
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && echo 'ServerName localhost' >> /etc/apache2/apache2.conf \
    && echo '<VirtualHost *:80>\n\
    ServerName localhost\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# فتح المنفذ 80 (Railway سيستخدم PORT ديناميكي)
EXPOSE 80

# استخدام entrypoint script
ENTRYPOINT ["docker-entrypoint.sh"]

