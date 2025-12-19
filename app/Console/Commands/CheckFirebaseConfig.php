<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\FirestoreHelper;

class CheckFirebaseConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firebase:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Firebase configuration and connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔥 Checking Firebase Configuration...');
        $this->newLine();

        // Check .env variables
        $this->info('📋 Checking .env variables:');
        $envVars = [
            'FIREBASE_APIKEY' => env('FIREBASE_APIKEY'),
            'FIREBASE_AUTH_DOMAIN' => env('FIREBASE_AUTH_DOMAIN'),
            'FIREBASE_PROJECT_ID' => env('FIREBASE_PROJECT_ID'),
            'FIREBASE_STORAGE_BUCKET' => env('FIREBASE_STORAGE_BUCKET'),
            'FIREBASE_MESSAAGING_SENDER_ID' => env('FIREBASE_MESSAAGING_SENDER_ID'),
            'FIREBASE_APP_ID' => env('FIREBASE_APP_ID'),
        ];

        $allEnvSet = true;
        foreach ($envVars as $key => $value) {
            if (empty($value)) {
                $this->error("   ❌ {$key} is not set");
                $allEnvSet = false;
            } else {
                $this->info("   ✅ {$key} is set");
            }
        }

        if (!$allEnvSet) {
            $this->newLine();
            $this->warn('⚠️  Some Firebase environment variables are missing!');
            $this->warn('   Please check your .env file and add the missing variables.');
            $this->newLine();
        } else {
            $this->newLine();
            $this->info('✅ All environment variables are set!');
            $this->newLine();
        }

        // Check Service Account
        $this->info('🔐 Checking Service Account:');
        $serviceAccountPath = storage_path('app/firebase/service-account.json');
        
        if (file_exists($serviceAccountPath)) {
            $this->info("   ✅ Service Account file exists: {$serviceAccountPath}");
            
            // Try to read and validate JSON
            $content = file_get_contents($serviceAccountPath);
            $json = json_decode($content, true);
            
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->info("   ✅ Service Account JSON is valid");
                
                if (isset($json['project_id'])) {
                    $this->info("   ✅ Project ID in Service Account: {$json['project_id']}");
                }
            } else {
                $this->error("   ❌ Service Account JSON is invalid: " . json_last_error_msg());
            }
        } else {
            $this->warn("   ⚠️  Service Account file not found: {$serviceAccountPath}");
            $this->warn("   📝 To get Service Account:");
            $this->warn("      1. Go to Firebase Console → Project Settings → Service Accounts");
            $this->warn("      2. Click 'Generate new private key'");
            $this->warn("      3. Save the file to: {$serviceAccountPath}");
        }
        $this->newLine();

        // Test Firestore connection
        $this->info('🔌 Testing Firestore connection:');
        try {
            $doc = FirestoreHelper::getDocument('settings/globalSettings');
            if ($doc !== null) {
                $this->info('   ✅ Firestore connection successful!');
                $this->info('   ✅ Can read from Firestore');
            } else {
                $this->warn('   ⚠️  Firestore connection works but document not found');
                $this->warn('   ℹ️  This is normal if the document does not exist');
            }
        } catch (\Exception $e) {
            $this->error('   ❌ Firestore connection failed!');
            $this->error('   Error: ' . $e->getMessage());
            
            if (strpos($e->getMessage(), 'Service Account') !== false) {
                $this->warn('   💡 Tip: Make sure Service Account file is in the correct location');
            }
        }
        $this->newLine();

        // Summary
        $this->info('📊 Summary:');
        if ($allEnvSet && file_exists($serviceAccountPath)) {
            $this->info('   ✅ Firebase is properly configured!');
            $this->info('   ✅ Ready to use Firebase services');
        } else {
            $this->warn('   ⚠️  Some configuration is missing');
            $this->warn('   📖 Please check FIREBASE_SETUP_GUIDE.md for detailed instructions');
        }
        $this->newLine();

        return 0;
    }
}
















