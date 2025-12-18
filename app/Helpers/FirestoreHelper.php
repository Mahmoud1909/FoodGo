<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Factory;

class FirestoreHelper
{
    protected static function getFirestore()
    {
        static $firestore = null;
        static $initializationFailed = false;
        
        // If initialization failed before, don't try again
        if ($initializationFailed) {
            return null;
        }
        
        if ($firestore !== null) {
            return $firestore;
        }
        
        // Use config file if available, otherwise fallback to env
        $projectId = config('firebase.project_id', env('FIREBASE_PROJECT_ID'));
        
        if (empty($projectId)) {
            logger()->warning('FIREBASE_PROJECT_ID not set. Please check your .env file or config/firebase.php');
            $initializationFailed = true;
            return null;
        }
        
        // Try to use service account JSON file if available
        $serviceAccountPath = config('firebase.service_account_path', storage_path('app/firebase/service-account.json'));
        
        try {
            // If the Google Cloud Firestore PHP client is not installed, avoid a fatal Error
            if (!class_exists(\Google\Cloud\Firestore\FirestoreClient::class)) {
                logger()->error('Missing Google Cloud Firestore PHP client. Run: composer require google/cloud-firestore and composer install on the server, or deploy vendor/ from a build machine.');
                $initializationFailed = true;
                return null;
            }

            if (file_exists($serviceAccountPath)) {
                $factory = (new Factory)->withServiceAccount($serviceAccountPath);
            } else {
                // Try to use project ID only (for basic operations)
                $factory = (new Factory)->withProjectId($projectId);
            }

            $firestore = $factory->createFirestore();
            return $firestore;
        } catch (\Throwable $e) {
            logger()->error('Firebase initialization error', ['error' => $e->getMessage()]);
            $initializationFailed = true;
            // Don't throw exception - return null instead to prevent 500 errors
            return null;
        }
    }

    protected static function baseUrl()
    {
        $projectId = env('FIREBASE_PROJECT_ID');
        return "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents";
    }

    /** Convert Firestore REST fields → clean PHP array */
    protected static function decodeFields($fields)
    {
        $result = [];
        foreach ($fields as $key => $value) {
            
            $type = array_key_first($value);
            $val = $value[$type];

            switch ($type) {
                case 'mapValue':
                    $result[$key] = self::decodeFields($val['fields'] ?? []);
                    break;

                case 'arrayValue':
                    $arr = [];
                    foreach ($val['values'] ?? [] as $v) {
                        $arr[] = self::decodeFields(['x' => $v])['x'];
                    }
                    $result[$key] = $arr;
                    break;

                case 'integerValue':
                    $result[$key] = (int) $val;
                    break;

                case 'doubleValue':
                    $result[$key] = (float) $val;
                    break;

                case 'booleanValue':
                    $result[$key] = (bool) $val;
                    break;

                default:
                    $result[$key] = $val;
            }
        }

        return $result;
    }

    /** Convert PHP array → Firestore REST fields */
    protected static function encodeFields(array $fields)
    {
        $formatted = [];

        foreach ($fields as $key => $value) {
            if (is_string($value)) {
                $formatted[$key] = ['stringValue' => $value];
            } elseif (is_int($value)) {
                $formatted[$key] = ['integerValue' => (string) $value];
            } elseif (is_float($value)) {
                $formatted[$key] = ['doubleValue' => $value];
            } elseif (is_bool($value)) {
                $formatted[$key] = ['booleanValue' => $value];
            } elseif (is_array($value)) {
                // associative → mapValue, numeric → arrayValue
                $isAssoc = array_keys($value) !== range(0, count($value) - 1);
                if ($isAssoc) {
                    $formatted[$key] = ['mapValue' => ['fields' => self::encodeFields($value)]];
                } else {
                    $formatted[$key] = [
                        'arrayValue' => ['values' => array_map(fn($v) => ['stringValue' => $v], $value)]
                    ];
                }
            } else {
                $formatted[$key] = ['stringValue' => (string) $value];
            }
        }

        return $formatted;
    }

    /** Get vakue of field based on data type */
    private static function getFirestoreValue($value)
    {
        if (is_int($value)) {
            return ['integerValue' => $value];
        } elseif (is_float($value)) {
            return ['doubleValue' => $value];
        } elseif (is_bool($value)) {
            return ['booleanValue' => $value];
        } elseif ($value instanceof \DateTime) {
            return ['timestampValue' => $value->format(\DateTime::ATOM)];
        } elseif (is_array($value)) {
            return ['arrayValue' => ['values' => array_map(fn($v) => self::getFirestoreValue($v), $value)]];
        } else {
            // Default: string
            return ['stringValue' => (string)$value];
        }
    }

    /** Get document as clean array */
    public static function getDocument($path)
    {
        try {
            $firestore = self::getFirestore();
            
            // If Firestore is not available, return null silently
            if ($firestore === null) {
                return null;
            }
            
            $database = $firestore->database();
            
            if ($database === null) {
                return null;
            }
            
            $pathParts = explode('/', $path);
            $collection = $pathParts[0];
            $documentId = $pathParts[1] ?? null;
            
            if ($documentId) {
                $docRef = $database->collection($collection)->document($documentId);
                $snapshot = $docRef->snapshot();
                
                if ($snapshot->exists()) {
                    return $snapshot->data();
                }
            }
            
            return null;
        } catch (\Throwable $e) {
            // Log error but don't throw - return null to prevent 500 errors
            logger()->error('Firestore getDocument error', ['path' => $path, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /** Get all documents using collection clean array */
    public static function getCollection($collection)
    {
        try {
            $firestore = self::getFirestore();
            
            // If Firestore is not available, return empty array
            if ($firestore === null) {
                return [];
            }
            
            $database = $firestore->database();
            
            if ($database === null) {
                return [];
            }
            
            $documents = [];
            $snapshot = $database->collection($collection)->documents();
            
            foreach ($snapshot as $doc) {
                if ($doc->exists()) {
                    $documents[] = $doc->data();
                }
            }
            
            return $documents;
        } catch (\Throwable $e) {
            // Log error but don't throw - return empty array to prevent 500 errors
            logger()->error('Firestore getCollection error', ['collection' => $collection, 'error' => $e->getMessage()]);
            return [];
        }
    }

    /** Get document using query clean array */
    public static function queryCollection($collection, $field, $op, $value)
    {
        try {
            $firestore = self::getFirestore();

            // If Firestore is not available, return empty array
            if ($firestore === null) {
                return [];
            }

            $database = $firestore->database();
            
            $query = $database->collection($collection);
            
            // Map operators to Firestore query methods
            switch ($op) {
                case '==':
                    $query = $query->where($field, '=', $value);
                    break;
                case '>':
                    $query = $query->where($field, '>', $value);
                    break;
                case '>=':
                    $query = $query->where($field, '>=', $value);
                    break;
                case '<':
                    $query = $query->where($field, '<', $value);
                    break;
                case '<=':
                    $query = $query->where($field, '<=', $value);
                    break;
                case '!=':
                    $query = $query->where($field, '!=', $value);
                    break;
                case 'array-contains':
                    $query = $query->where($field, 'array-contains', $value);
                    break;
                default:
                    $query = $query->where($field, '=', $value);
            }
            
            $documents = [];
            $snapshot = $query->documents();
            
            foreach ($snapshot as $doc) {
                if ($doc->exists()) {
                    $documents[] = $doc->data();
                }
            }
            
            return $documents;
        } catch (\Throwable $e) {
            logger()->error('Firestore queryCollection error', [
                'collection' => $collection,
                'field' => $field,
                'op' => $op,
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /** Set document from clean array */
    public static function setDocument($path, array $data)
    {
        try {
            $firestore = self::getFirestore();

            if ($firestore === null) {
                return null;
            }

            $database = $firestore->database();
            
            $pathParts = explode('/', $path);
            $collection = $pathParts[0];
            $documentId = $pathParts[1] ?? null;
            
            if ($documentId) {
                $docRef = $database->collection($collection)->document($documentId);
                $docRef->set($data, ['merge' => true]);
                
                $snapshot = $docRef->snapshot();
                return $snapshot->exists() ? $snapshot->data() : null;
            }
            
            return null;
        } catch (\Throwable $e) {
            logger()->error('Firestore setDocument error', ['path' => $path, 'error' => $e->getMessage()]);
            return null;
        }
    }
}