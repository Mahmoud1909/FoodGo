/**
 * 🔥 Firestore Connection Test Script
 * 
 * هذا السكريبت يختبر الاتصال بـ Firestore
 * 
 * الاستخدام:
 *   node test-firestore-connection.js
 */

const admin = require('firebase-admin');
const path = require('path');
const fs = require('fs');

console.log('🔥 [TEST] ========================================');
console.log('🔥 [TEST] Firestore Connection Test');
console.log('🔥 [TEST] ========================================');

// Check if credentials.json exists
const credentialsPath = path.join(__dirname, 'credentials.json');
if (!fs.existsSync(credentialsPath)) {
    console.error('❌ [TEST] ERROR: credentials.json not found!');
    console.error('❌ [TEST] Please create credentials.json with your Firebase service account key');
    console.error('❌ [TEST] Path:', credentialsPath);
    process.exit(1);
}

console.log('✅ [TEST] credentials.json found');

// Load service account
let serviceAccount;
try {
    serviceAccount = require(credentialsPath);
    console.log('✅ [TEST] Service account loaded');
    console.log('✅ [TEST] Project ID:', serviceAccount.project_id);
} catch (error) {
    console.error('❌ [TEST] ERROR: Failed to load credentials.json');
    console.error('❌ [TEST] Error:', error.message);
    process.exit(1);
}

// Initialize Firebase Admin
let app;
try {
    // Check if already initialized
    if (admin.apps.length > 0) {
        app = admin.app();
        console.log('✅ [TEST] Using existing Firebase app');
    } else {
        app = admin.initializeApp({
            credential: admin.credential.cert(serviceAccount),
            projectId: serviceAccount.project_id
        });
        console.log('✅ [TEST] Firebase Admin initialized');
    }
} catch (error) {
    console.error('❌ [TEST] ERROR: Failed to initialize Firebase Admin');
    console.error('❌ [TEST] Error:', error.message);
    console.error('❌ [TEST] Code:', error.code);
    process.exit(1);
}

// Get Firestore instance
const db = admin.firestore();
console.log('✅ [TEST] Firestore instance created');

// Test 1: Basic Connection
console.log('');
console.log('📋 [TEST] Test 1: Basic Connection');
console.log('📋 [TEST] Reading from vendors collection...');

db.collection('vendors').limit(1).get()
    .then((snapshot) => {
        console.log('✅ [TEST] Test 1: SUCCESS');
        console.log('✅ [TEST] Documents found:', snapshot.size);
        console.log('✅ [TEST] Collection: vendors');
        
        // Test 2: OrderBy Query
        console.log('');
        console.log('📋 [TEST] Test 2: OrderBy Query');
        console.log('📋 [TEST] Testing orderBy query...');
        
        return db.collection('vendors')
            .orderBy('createdAt', 'desc')
            .limit(1)
            .get();
    })
    .then((snapshot) => {
        console.log('✅ [TEST] Test 2: SUCCESS');
        console.log('✅ [TEST] OrderBy query works!');
        console.log('✅ [TEST] Index is available');
        
        // Test 3: Write Permission (optional)
        console.log('');
        console.log('📋 [TEST] Test 3: Write Permission (optional)');
        console.log('📋 [TEST] Testing write permission...');
        
        const testDoc = db.collection('_test').doc('connection-test');
        return testDoc.set({
            timestamp: admin.firestore.FieldValue.serverTimestamp(),
            test: true
        }).then(() => {
            console.log('✅ [TEST] Test 3: SUCCESS');
            console.log('✅ [TEST] Write permission works!');
            
            // Cleanup
            return testDoc.delete();
        }).then(() => {
            console.log('✅ [TEST] Test document deleted');
        });
    })
    .then(() => {
        console.log('');
        console.log('🔥 [TEST] ========================================');
        console.log('🔥 [TEST] ✅✅✅ ALL TESTS PASSED! ✅✅✅');
        console.log('🔥 [TEST] ========================================');
        console.log('✅ [TEST] Firestore is fully connected and working!');
        console.log('✅ [TEST] Project ID:', app.options.projectId);
        console.log('✅ [TEST] ========================================');
        process.exit(0);
    })
    .catch((error) => {
        console.log('');
        console.error('🔥 [TEST] ========================================');
        console.error('🔥 [TEST] ❌❌❌ TEST FAILED! ❌❌❌');
        console.error('🔥 [TEST] ========================================');
        console.error('❌ [TEST] Error Code:', error.code || 'N/A');
        console.error('❌ [TEST] Error Message:', error.message || 'Unknown error');
        console.error('❌ [TEST] Error Name:', error.name || 'Error');
        
        if (error.code === 'permission-denied') {
            console.error('');
            console.error('🚫 [TEST] PERMISSION DENIED!');
            console.error('🚫 [TEST] Firestore Rules are blocking access');
            console.error('🚫 [TEST] Solution:');
            console.error('   1. Go to Firebase Console → Firestore → Rules');
            console.error('   2. Update rules to allow read access');
            console.error('   3. Or run: firebase deploy --only firestore:rules');
        } else if (error.code === 'failed-precondition') {
            console.error('');
            console.error('🚫 [TEST] INDEX MISSING!');
            console.error('🚫 [TEST] Required index is not available');
            console.error('🚫 [TEST] Solution:');
            console.error('   1. Go to Firebase Console → Firestore → Indexes');
            console.error('   2. Create the required index');
            console.error('   3. Or run: firebase deploy --only firestore:indexes');
            console.error('   4. Wait 2-5 minutes for index to be enabled');
        } else if (error.code === 'unauthenticated') {
            console.error('');
            console.error('🚫 [TEST] UNAUTHENTICATED!');
            console.error('🚫 [TEST] Service account credentials are invalid');
            console.error('🚫 [TEST] Solution:');
            console.error('   1. Check credentials.json file');
            console.error('   2. Verify service account has proper IAM roles');
            console.error('   3. Grant "Firebase Admin SDK Administrator Service Agent" role');
        } else if (error.code === 'unavailable') {
            console.error('');
            console.error('🚫 [TEST] SERVICE UNAVAILABLE!');
            console.error('🚫 [TEST] Firestore service is not available');
            console.error('🚫 [TEST] Solution:');
            console.error('   1. Check internet connection');
            console.error('   2. Check Firebase project status');
            console.error('   3. Verify Firestore API is enabled');
        }
        
        console.error('🔥 [TEST] ========================================');
        process.exit(1);
    });



 * 🔥 Firestore Connection Test Script
 * 
 * هذا السكريبت يختبر الاتصال بـ Firestore
 * 
 * الاستخدام:
 *   node test-firestore-connection.js
 */

const admin = require('firebase-admin');
const path = require('path');
const fs = require('fs');

console.log('🔥 [TEST] ========================================');
console.log('🔥 [TEST] Firestore Connection Test');
console.log('🔥 [TEST] ========================================');

// Check if credentials.json exists
const credentialsPath = path.join(__dirname, 'credentials.json');
if (!fs.existsSync(credentialsPath)) {
    console.error('❌ [TEST] ERROR: credentials.json not found!');
    console.error('❌ [TEST] Please create credentials.json with your Firebase service account key');
    console.error('❌ [TEST] Path:', credentialsPath);
    process.exit(1);
}

console.log('✅ [TEST] credentials.json found');

// Load service account
let serviceAccount;
try {
    serviceAccount = require(credentialsPath);
    console.log('✅ [TEST] Service account loaded');
    console.log('✅ [TEST] Project ID:', serviceAccount.project_id);
} catch (error) {
    console.error('❌ [TEST] ERROR: Failed to load credentials.json');
    console.error('❌ [TEST] Error:', error.message);
    process.exit(1);
}

// Initialize Firebase Admin
let app;
try {
    // Check if already initialized
    if (admin.apps.length > 0) {
        app = admin.app();
        console.log('✅ [TEST] Using existing Firebase app');
    } else {
        app = admin.initializeApp({
            credential: admin.credential.cert(serviceAccount),
            projectId: serviceAccount.project_id
        });
        console.log('✅ [TEST] Firebase Admin initialized');
    }
} catch (error) {
    console.error('❌ [TEST] ERROR: Failed to initialize Firebase Admin');
    console.error('❌ [TEST] Error:', error.message);
    console.error('❌ [TEST] Code:', error.code);
    process.exit(1);
}

// Get Firestore instance
const db = admin.firestore();
console.log('✅ [TEST] Firestore instance created');

// Test 1: Basic Connection
console.log('');
console.log('📋 [TEST] Test 1: Basic Connection');
console.log('📋 [TEST] Reading from vendors collection...');

db.collection('vendors').limit(1).get()
    .then((snapshot) => {
        console.log('✅ [TEST] Test 1: SUCCESS');
        console.log('✅ [TEST] Documents found:', snapshot.size);
        console.log('✅ [TEST] Collection: vendors');
        
        // Test 2: OrderBy Query
        console.log('');
        console.log('📋 [TEST] Test 2: OrderBy Query');
        console.log('📋 [TEST] Testing orderBy query...');
        
        return db.collection('vendors')
            .orderBy('createdAt', 'desc')
            .limit(1)
            .get();
    })
    .then((snapshot) => {
        console.log('✅ [TEST] Test 2: SUCCESS');
        console.log('✅ [TEST] OrderBy query works!');
        console.log('✅ [TEST] Index is available');
        
        // Test 3: Write Permission (optional)
        console.log('');
        console.log('📋 [TEST] Test 3: Write Permission (optional)');
        console.log('📋 [TEST] Testing write permission...');
        
        const testDoc = db.collection('_test').doc('connection-test');
        return testDoc.set({
            timestamp: admin.firestore.FieldValue.serverTimestamp(),
            test: true
        }).then(() => {
            console.log('✅ [TEST] Test 3: SUCCESS');
            console.log('✅ [TEST] Write permission works!');
            
            // Cleanup
            return testDoc.delete();
        }).then(() => {
            console.log('✅ [TEST] Test document deleted');
        });
    })
    .then(() => {
        console.log('');
        console.log('🔥 [TEST] ========================================');
        console.log('🔥 [TEST] ✅✅✅ ALL TESTS PASSED! ✅✅✅');
        console.log('🔥 [TEST] ========================================');
        console.log('✅ [TEST] Firestore is fully connected and working!');
        console.log('✅ [TEST] Project ID:', app.options.projectId);
        console.log('✅ [TEST] ========================================');
        process.exit(0);
    })
    .catch((error) => {
        console.log('');
        console.error('🔥 [TEST] ========================================');
        console.error('🔥 [TEST] ❌❌❌ TEST FAILED! ❌❌❌');
        console.error('🔥 [TEST] ========================================');
        console.error('❌ [TEST] Error Code:', error.code || 'N/A');
        console.error('❌ [TEST] Error Message:', error.message || 'Unknown error');
        console.error('❌ [TEST] Error Name:', error.name || 'Error');
        
        if (error.code === 'permission-denied') {
            console.error('');
            console.error('🚫 [TEST] PERMISSION DENIED!');
            console.error('🚫 [TEST] Firestore Rules are blocking access');
            console.error('🚫 [TEST] Solution:');
            console.error('   1. Go to Firebase Console → Firestore → Rules');
            console.error('   2. Update rules to allow read access');
            console.error('   3. Or run: firebase deploy --only firestore:rules');
        } else if (error.code === 'failed-precondition') {
            console.error('');
            console.error('🚫 [TEST] INDEX MISSING!');
            console.error('🚫 [TEST] Required index is not available');
            console.error('🚫 [TEST] Solution:');
            console.error('   1. Go to Firebase Console → Firestore → Indexes');
            console.error('   2. Create the required index');
            console.error('   3. Or run: firebase deploy --only firestore:indexes');
            console.error('   4. Wait 2-5 minutes for index to be enabled');
        } else if (error.code === 'unauthenticated') {
            console.error('');
            console.error('🚫 [TEST] UNAUTHENTICATED!');
            console.error('🚫 [TEST] Service account credentials are invalid');
            console.error('🚫 [TEST] Solution:');
            console.error('   1. Check credentials.json file');
            console.error('   2. Verify service account has proper IAM roles');
            console.error('   3. Grant "Firebase Admin SDK Administrator Service Agent" role');
        } else if (error.code === 'unavailable') {
            console.error('');
            console.error('🚫 [TEST] SERVICE UNAVAILABLE!');
            console.error('🚫 [TEST] Firestore service is not available');
            console.error('🚫 [TEST] Solution:');
            console.error('   1. Check internet connection');
            console.error('   2. Check Firebase project status');
            console.error('   3. Verify Firestore API is enabled');
        }
        
        console.error('🔥 [TEST] ========================================');
        process.exit(1);
    });


























