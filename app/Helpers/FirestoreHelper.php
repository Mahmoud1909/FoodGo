<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Google\Auth\Credentials\ServiceAccountCredentials;

class FirestoreHelper
{
    protected static function getAccessToken(): ?string
    {
        static $token = null;
        static $tokenExpiresAt = null;

        if (is_string($token) && is_int($tokenExpiresAt) && time() < ($tokenExpiresAt - 60)) {
            return $token;
        }

        $serviceAccountPath = config('firebase.service_account_path', storage_path('app/firebase/service-account.json'));

        if (!is_string($serviceAccountPath) || $serviceAccountPath === '' || !file_exists($serviceAccountPath)) {
            logger()->error('Firebase initialization error', ['error' => 'Service account JSON not found at: ' . (string) $serviceAccountPath]);
            return null;
        }

        try {
            $scopes = ['https://www.googleapis.com/auth/datastore'];
            $credentials = new ServiceAccountCredentials($scopes, $serviceAccountPath);
            $auth = $credentials->fetchAuthToken();

            if (!is_array($auth) || empty($auth['access_token'])) {
                logger()->error('Firebase initialization error', ['error' => 'Failed to fetch Google access token from service account']);
                return null;
            }

            $token = (string) $auth['access_token'];
            $tokenExpiresAt = isset($auth['expires_in']) ? (time() + (int) $auth['expires_in']) : (time() + 3000);

            return $token;
        } catch (\Throwable $e) {
            logger()->error('Firebase initialization error', ['error' => $e->getMessage()]);
            return null;
        }
    }

    protected static function request(string $method, string $url, array $payload = null)
    {
        $token = self::getAccessToken();
        if ($token === null) {
            return null;
        }

        $req = Http::timeout(30)
            ->withToken($token)
            ->acceptJson();

        if ($payload === null) {
            return $req->{$method}($url);
        }

        return $req->{$method}($url, $payload);
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
            return ['integerValue' => (string) $value];
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
            $projectId = config('firebase.project_id', env('FIREBASE_PROJECT_ID'));

            if (empty($projectId)) {
                logger()->warning('FIREBASE_PROJECT_ID not set. Please check your .env file or config/firebase.php');
                return null;
            }

            $url = rtrim(self::baseUrl(), '/') . '/' . ltrim($path, '/');
            $res = self::request('get', $url);

            if ($res === null) {
                return null;
            }

            if ($res->status() === 404) {
                return null;
            }

            if (!$res->successful()) {
                logger()->error('Firestore getDocument error', ['path' => $path, 'error' => $res->body()]);
                return null;
            }

            $doc = $res->json();
            if (!is_array($doc) || empty($doc['fields']) || !is_array($doc['fields'])) {
                return null;
            }

            return self::decodeFields($doc['fields']);
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
            $projectId = config('firebase.project_id', env('FIREBASE_PROJECT_ID'));

            if (empty($projectId)) {
                logger()->warning('FIREBASE_PROJECT_ID not set. Please check your .env file or config/firebase.php');
                return [];
            }

            $url = rtrim(self::baseUrl(), '/') . '/' . ltrim($collection, '/');
            $res = self::request('get', $url);

            if ($res === null) {
                return [];
            }

            if (!$res->successful()) {
                logger()->error('Firestore getCollection error', ['collection' => $collection, 'error' => $res->body()]);
                return [];
            }

            $json = $res->json();
            if (!is_array($json) || empty($json['documents']) || !is_array($json['documents'])) {
                return [];
            }

            $documents = [];
            foreach ($json['documents'] as $doc) {
                if (is_array($doc) && !empty($doc['fields']) && is_array($doc['fields'])) {
                    $documents[] = self::decodeFields($doc['fields']);
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
            $projectId = config('firebase.project_id', env('FIREBASE_PROJECT_ID'));

            if (empty($projectId)) {
                logger()->warning('FIREBASE_PROJECT_ID not set. Please check your .env file or config/firebase.php');
                return [];
            }

            $opMap = [
                '==' => 'EQUAL',
                '=' => 'EQUAL',
                '>' => 'GREATER_THAN',
                '>=' => 'GREATER_THAN_OR_EQUAL',
                '<' => 'LESS_THAN',
                '<=' => 'LESS_THAN_OR_EQUAL',
                '!=' => 'NOT_EQUAL',
                'array-contains' => 'ARRAY_CONTAINS',
            ];

            $firestoreOp = $opMap[$op] ?? 'EQUAL';

            $payload = [
                'structuredQuery' => [
                    'from' => [
                        ['collectionId' => $collection],
                    ],
                    'where' => [
                        'fieldFilter' => [
                            'field' => ['fieldPath' => $field],
                            'op' => $firestoreOp,
                            'value' => self::getFirestoreValue($value),
                        ],
                    ],
                ],
            ];

            $url = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents:runQuery";
            $res = self::request('post', $url, $payload);

            if ($res === null) {
                return [];
            }

            if (!$res->successful()) {
                logger()->error('Firestore queryCollection error', [
                    'collection' => $collection,
                    'field' => $field,
                    'op' => $op,
                    'error' => $res->body(),
                ]);
                return [];
            }

            $rows = $res->json();
            if (!is_array($rows)) {
                return [];
            }

            $documents = [];
            foreach ($rows as $row) {
                if (is_array($row) && isset($row['document']) && is_array($row['document']) && !empty($row['document']['fields'])) {
                    $documents[] = self::decodeFields($row['document']['fields']);
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
            $projectId = config('firebase.project_id', env('FIREBASE_PROJECT_ID'));

            if (empty($projectId)) {
                logger()->warning('FIREBASE_PROJECT_ID not set. Please check your .env file or config/firebase.php');
                return null;
            }

            if (empty($data)) {
                return null;
            }

            $url = rtrim(self::baseUrl(), '/') . '/' . ltrim($path, '/');
            $mask = implode('&', array_map(static fn($k) => 'updateMask.fieldPaths=' . urlencode((string) $k), array_keys($data)));
            if ($mask !== '') {
                $url .= '?' . $mask;
            }

            $payload = ['fields' => self::encodeFields($data)];
            $res = self::request('patch', $url, $payload);

            if ($res === null) {
                return null;
            }

            if (!$res->successful()) {
                logger()->error('Firestore setDocument error', ['path' => $path, 'error' => $res->body()]);
                return null;
            }

            $doc = $res->json();
            if (!is_array($doc) || empty($doc['fields']) || !is_array($doc['fields'])) {
                return null;
            }

            return self::decodeFields($doc['fields']);
        } catch (\Throwable $e) {
            logger()->error('Firestore setDocument error', ['path' => $path, 'error' => $e->getMessage()]);
            return null;
        }
    }
}