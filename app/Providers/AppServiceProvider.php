<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use App\Helpers\FirestoreHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Set Firebase cookies only if values exist to prevent errors
        try {
            if (env('FIREBASE_APIKEY')) {
                setcookie('XSRF-TOKEN-AK', bin2hex(env('FIREBASE_APIKEY')), time() + 3600, "/"); 
            }
            if (env('FIREBASE_AUTH_DOMAIN')) {
                setcookie('XSRF-TOKEN-AD', bin2hex(env('FIREBASE_AUTH_DOMAIN')), time() + 3600, "/"); 
            }
            if (env('FIREBASE_DATABASE_URL')) {
                setcookie('XSRF-TOKEN-DU', bin2hex(env('FIREBASE_DATABASE_URL')), time() + 3600, "/"); 
            }
            if (env('FIREBASE_PROJECT_ID')) {
                setcookie('XSRF-TOKEN-PI', bin2hex(env('FIREBASE_PROJECT_ID')), time() + 3600, "/"); 
            }
            if (env('FIREBASE_STORAGE_BUCKET')) {
                setcookie('XSRF-TOKEN-SB', bin2hex(env('FIREBASE_STORAGE_BUCKET')), time() + 3600, "/"); 
            }
            if (env('FIREBASE_MESSAAGING_SENDER_ID')) {
                setcookie('XSRF-TOKEN-MS', bin2hex(env('FIREBASE_MESSAAGING_SENDER_ID')), time() + 3600, "/"); 
            }
            if (env('FIREBASE_APP_ID')) {
                setcookie('XSRF-TOKEN-AI', bin2hex(env('FIREBASE_APP_ID')), time() + 3600, "/"); 
            }
            if (env('FIREBASE_MEASUREMENT_ID')) {
                setcookie('XSRF-TOKEN-MI', bin2hex(env('FIREBASE_MEASUREMENT_ID')), time() + 3600, "/"); 
            }
        } catch (\Exception $e) {
            // Silently fail if cookies can't be set
            \Log::warning('Failed to set Firebase cookies', ['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $countries_data = [];
        $countries_file = public_path('countriesdata.json');
        
        // Safely load countries data
        try {
            if (file_exists($countries_file)) {
                $get_countries_json = file_get_contents($countries_file);
                if ($get_countries_json != '') {
                    $countries_data = json_decode($get_countries_json, true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $countries_data = [];
                        \Log::warning('Failed to parse countriesdata.json', ['error' => json_last_error_msg()]);
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to load countries data', ['error' => $e->getMessage()]);
            $countries_data = [];
        }
        
        // Try to get OpenAI settings from Firestore, but don't fail if it's not available
        try {
            $openai_settings = FirestoreHelper::getDocument('settings/openai_settings');
            if (!empty($openai_settings)) {
                if (!empty($openai_settings['api_key'])) {
                    Config::set('openai.api_key', $openai_settings['api_key']);
                }
                if (!empty($openai_settings['organization'])) {
                    Config::set('openai.organization', $openai_settings['organization']);
                }
            }
        } catch (\Exception $e) {
            // Log error but don't stop application boot
            \Log::warning('Failed to load OpenAI settings from Firestore', ['error' => $e->getMessage()]);
            $openai_settings = null;
        }

        view()->composer('*', function ($view) use ($countries_data, $openai_settings) {
            $view->with('countries_data', $countries_data);
            $view->with('openai_settings', $openai_settings);
        });
    }
}
