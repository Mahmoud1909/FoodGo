<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Helpers\FirestoreHelper;

$restaurantId = '5KjbF2LDaEe19ttEFClo';

echo "🔍 Searching for restaurant with ID: {$restaurantId}\n";
echo "===========================================\n\n";

// Check Firebase configuration
$projectId = config('firebase.project_id', env('FIREBASE_PROJECT_ID'));
$serviceAccountPath = config('firebase.service_account_path', storage_path('app/firebase/service-account.json'));

echo "📋 Firebase Configuration:\n";
echo "   Project ID: " . ($projectId ?: 'NOT SET') . "\n";
echo "   Service Account: " . ($serviceAccountPath ?: 'NOT SET') . "\n";
echo "   Service Account Exists: " . (file_exists($serviceAccountPath) ? 'YES' : 'NO') . "\n\n";

// Try direct Firebase access
echo "Connecting to Firestore...\n";
try {
    echo "✅ Firestore REST is configured (using service account)\n\n";

    echo "Method 1: Direct document access (vendors/{$restaurantId})...\n";
    $restaurant = FirestoreHelper::getDocument('vendors/'.$restaurantId);
    if (!empty($restaurant)) {
        echo "✅ Restaurant Data Found:\n";
        echo json_encode($restaurant, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo "\n\n";
        exit(0);
    }
    echo "❌ Method 1: Document does not exist\n\n";

    echo "Method 2: Query by 'id' field...\n";
    $results = FirestoreHelper::queryCollection('vendors', 'id', '==', $restaurantId);
    if (!empty($results)) {
        echo "✅ Restaurant Data Found:\n";
        echo json_encode($results[0], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo "\n\n";
        exit(0);
    }
    echo "❌ Method 2: Restaurant not found\n\n";
    
    echo "❌ Restaurant not found with ID: {$restaurantId}\n";
    echo "\nPlease verify:\n";
    echo "1. Restaurant ID is correct: {$restaurantId}\n";
    echo "2. Firestore rules allow read access\n";
    echo "3. Document exists in Firestore console\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

