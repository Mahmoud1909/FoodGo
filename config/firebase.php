<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Firebase Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for Firebase services.
    | Make sure to set these values in your .env file.
    |
    */

    'api_key' => env('FIREBASE_APIKEY'),
    'auth_domain' => env('FIREBASE_AUTH_DOMAIN'),
    'project_id' => env('FIREBASE_PROJECT_ID'),
    'storage_bucket' => env('FIREBASE_STORAGE_BUCKET'),
    'messaging_sender_id' => env('FIREBASE_MESSAAGING_SENDER_ID'),
    'app_id' => env('FIREBASE_APP_ID'),
    'measurement_id' => env('FIREBASE_MEASUREMENT_ID'),
    
    /*
    |--------------------------------------------------------------------------
    | Service Account Path
    |--------------------------------------------------------------------------
    |
    | Path to the Firebase Service Account JSON file.
    | This file is required for server-side operations (PHP).
    | Download it from Firebase Console → Project Settings → Service Accounts
    |
    */
    'service_account_path' => storage_path('app/firebase/service-account.json'),
    
    /*
    |--------------------------------------------------------------------------
    | Firestore Settings
    |--------------------------------------------------------------------------
    */
    'firestore' => [
        'database' => '(default)',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Storage Settings
    |--------------------------------------------------------------------------
    */
    'storage' => [
        'default_bucket' => env('FIREBASE_STORAGE_BUCKET'),
    ],
];
















