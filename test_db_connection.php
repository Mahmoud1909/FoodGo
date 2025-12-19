<?php
/**
 * سكربت اختبار الاتصال بقاعدة البيانات
 * استخدم: php test_db_connection.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $pdo = DB::connection()->getPdo();
    echo "✅ الاتصال بقاعدة البيانات نجح!\n";
    echo "قاعدة البيانات: " . DB::connection()->getDatabaseName() . "\n";
    echo "المستخدم: " . config('database.connections.mysql.username') . "\n";
    echo "الخادم: " . config('database.connections.mysql.host') . "\n";
} catch (Exception $e) {
    echo "❌ فشل الاتصال بقاعدة البيانات!\n";
    echo "الخطأ: " . $e->getMessage() . "\n";
    echo "\n";
    echo "يرجى التأكد من:\n";
    echo "1. قاعدة البيانات 'foodgo' موجودة\n";
    echo "2. المستخدم 'laravel' موجود وله صلاحيات\n";
    echo "3. كلمة المرور صحيحة (123456)\n";
    echo "4. MySQL يعمل\n";
    exit(1);
}

