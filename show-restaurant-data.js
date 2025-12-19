/**
 * 🔍 Simple script to show restaurant data in terminal
 * Restaurant ID: 5KjbF2LDaEe19ttEFClo
 */

const admin = require('firebase-admin');
const path = require('path');
const fs = require('fs');

console.log('🔍 ============================================');
console.log('🔍 Fetching Restaurant Data from Firestore');
console.log('🔍 ============================================');

// Check if credentials.json exists
const credentialsPath = path.join(__dirname, 'credentials.json');
if (!fs.existsSync(credentialsPath)) {
    console.error('❌ ERROR: credentials.json not found!');
    console.error('❌ Path:', credentialsPath);
    console.error('');
    console.error('💡 Solution:');
    console.error('   1. Download service account key from Firebase Console');
    console.error('   2. Save it as credentials.json in the project root');
    process.exit(1);
}

// Load service account
let serviceAccount;
try {
    serviceAccount = require(credentialsPath);
    console.log('✅ credentials.json loaded');
    console.log('✅ Project ID:', serviceAccount.project_id);
} catch (error) {
    console.error('❌ ERROR: Failed to load credentials.json');
    console.error('❌ Error:', error.message);
    process.exit(1);
}

// Initialize Firebase Admin
let app;
try {
    if (admin.apps.length > 0) {
        app = admin.app();
        console.log('✅ Using existing Firebase app');
    } else {
        app = admin.initializeApp({
            credential: admin.credential.cert(serviceAccount),
            projectId: serviceAccount.project_id
        });
        console.log('✅ Firebase Admin initialized');
    }
} catch (error) {
    console.error('❌ ERROR: Failed to initialize Firebase Admin');
    console.error('❌ Error:', error.message);
    process.exit(1);
}

const db = admin.firestore();
const restaurantId = '5KjbF2LDaEe19ttEFClo';

console.log('');
console.log('🔍 Restaurant ID:', restaurantId);
console.log('🔍 Collection: vendors');
console.log('🔍 ============================================');
console.log('');

// Get restaurant document
db.collection('vendors').doc(restaurantId).get()
    .then((docSnapshot) => {
        console.log('✅ ============================================');
        console.log('✅ Firestore Query Completed');
        console.log('✅ ============================================');
        console.log('');
        
        if (!docSnapshot.exists) {
            console.error('❌ Document does not exist!');
            console.error('❌ Restaurant ID:', restaurantId);
            console.error('❌ Please verify the ID in Firestore console.');
            process.exit(1);
        }
        
        const restaurant = docSnapshot.data();
        restaurant.id = docSnapshot.id;
        
        console.log('✅ Document exists: YES');
        console.log('✅ Document ID:', restaurant.id);
        console.log('');
        console.log('📊 ============================================');
        console.log('📊 RESTAURANT DATA:');
        console.log('📊 ============================================');
        console.log('');
        
        // Print all data as JSON
        console.log('📋 Complete Restaurant Object (JSON):');
        console.log('============================================');
        console.log(JSON.stringify(restaurant, null, 2));
        console.log('============================================');
        console.log('');
        
        // Print individual fields
        console.log('📋 Individual Fields:');
        console.log('============================================');
        console.log('  id:', restaurant.id || 'N/A');
        console.log('  title:', restaurant.title || 'N/A');
        console.log('  phonenumber:', restaurant.phonenumber || 'N/A');
        console.log('  countryCode:', restaurant.countryCode || 'N/A');
        console.log('  location:', restaurant.location || 'N/A');
        console.log('  latitude:', restaurant.latitude || 'N/A');
        console.log('  longitude:', restaurant.longitude || 'N/A');
        console.log('  description:', restaurant.description || 'N/A');
        console.log('  zoneId:', restaurant.zoneId || 'N/A');
        console.log('  categoryID:', Array.isArray(restaurant.categoryID) ? restaurant.categoryID.join(', ') : (restaurant.categoryID || 'N/A'));
        console.log('  photo:', restaurant.photo || 'N/A');
        console.log('  photos:', restaurant.photos ? `Array(${restaurant.photos.length} items)` : 'N/A');
        console.log('  restaurantMenuPhotos:', restaurant.restaurantMenuPhotos ? `Array(${restaurant.restaurantMenuPhotos.length} items)` : 'N/A');
        console.log('  workingHours:', restaurant.workingHours ? `Array(${restaurant.workingHours.length} items)` : 'N/A');
        console.log('  specialDiscount:', restaurant.specialDiscount ? `Array(${restaurant.specialDiscount.length} items)` : 'N/A');
        console.log('  adminCommission:', restaurant.adminCommission ? JSON.stringify(restaurant.adminCommission) : 'N/A');
        console.log('  filters:', restaurant.filters ? JSON.stringify(restaurant.filters) : 'N/A');
        console.log('  isSelfDelivery:', restaurant.isSelfDelivery || 'N/A');
        console.log('  enabledDiveInFuture:', restaurant.enabledDiveInFuture || 'N/A');
        console.log('  openDineTime:', restaurant.openDineTime || 'N/A');
        console.log('  closeDineTime:', restaurant.closeDineTime || 'N/A');
        console.log('  restaurantCost:', restaurant.restaurantCost || 'N/A');
        console.log('  DeliveryCharge:', restaurant.DeliveryCharge ? JSON.stringify(restaurant.DeliveryCharge) : 'N/A');
        console.log('  gst:', restaurant.gst || 'N/A');
        console.log('  enableDND:', restaurant.enableDND || 'N/A');
        console.log('  author:', restaurant.author || 'N/A');
        console.log('  createdAt:', restaurant.createdAt ? restaurant.createdAt.toDate().toISOString() : 'N/A');
        console.log('============================================');
        console.log('');
        console.log('✅ ============================================');
        console.log('✅ Data fetched successfully!');
        console.log('✅ ============================================');
        
        process.exit(0);
    })
    .catch((error) => {
        console.error('');
        console.error('❌ ============================================');
        console.error('❌ ERROR: Failed to fetch restaurant data');
        console.error('❌ ============================================');
        console.error('❌ Error Code:', error.code || 'N/A');
        console.error('❌ Error Message:', error.message || 'N/A');
        console.error('❌ Error Name:', error.name || 'N/A');
        console.error('❌ ============================================');
        console.error('');
        
        if (error.code === 16 || error.code === 'unauthenticated') {
            console.error('💡 Solution for UNAUTHENTICATED error:');
            console.error('   1. Go to Google Cloud Console');
            console.error('   2. IAM & Admin → IAM');
            console.error('   3. Find your Service Account');
            console.error('   4. Grant these roles:');
            console.error('      - Firebase Admin SDK Administrator Service Agent');
            console.error('      - Cloud Datastore User');
            console.error('   5. Wait 2-3 minutes for changes to take effect');
        } else if (error.code === 'permission-denied') {
            console.error('💡 Solution:');
            console.error('   1. Check Firestore Rules');
            console.error('   2. Verify Service Account has proper IAM roles');
        } else if (error.code === 'not-found') {
            console.error('💡 Solution:');
            console.error('   1. Verify the restaurant ID exists in Firestore');
            console.error('   2. Check the collection name (should be "vendors")');
        }
        
        console.error('');
        process.exit(1);
    });


 * 🔍 Simple script to show restaurant data in terminal
 * Restaurant ID: 5KjbF2LDaEe19ttEFClo
 */

const admin = require('firebase-admin');
const path = require('path');
const fs = require('fs');

console.log('🔍 ============================================');
console.log('🔍 Fetching Restaurant Data from Firestore');
console.log('🔍 ============================================');

// Check if credentials.json exists
const credentialsPath = path.join(__dirname, 'credentials.json');
if (!fs.existsSync(credentialsPath)) {
    console.error('❌ ERROR: credentials.json not found!');
    console.error('❌ Path:', credentialsPath);
    console.error('');
    console.error('💡 Solution:');
    console.error('   1. Download service account key from Firebase Console');
    console.error('   2. Save it as credentials.json in the project root');
    process.exit(1);
}

// Load service account
let serviceAccount;
try {
    serviceAccount = require(credentialsPath);
    console.log('✅ credentials.json loaded');
    console.log('✅ Project ID:', serviceAccount.project_id);
} catch (error) {
    console.error('❌ ERROR: Failed to load credentials.json');
    console.error('❌ Error:', error.message);
    process.exit(1);
}

// Initialize Firebase Admin
let app;
try {
    if (admin.apps.length > 0) {
        app = admin.app();
        console.log('✅ Using existing Firebase app');
    } else {
        app = admin.initializeApp({
            credential: admin.credential.cert(serviceAccount),
            projectId: serviceAccount.project_id
        });
        console.log('✅ Firebase Admin initialized');
    }
} catch (error) {
    console.error('❌ ERROR: Failed to initialize Firebase Admin');
    console.error('❌ Error:', error.message);
    process.exit(1);
}

const db = admin.firestore();
const restaurantId = '5KjbF2LDaEe19ttEFClo';

console.log('');
console.log('🔍 Restaurant ID:', restaurantId);
console.log('🔍 Collection: vendors');
console.log('🔍 ============================================');
console.log('');

// Get restaurant document
db.collection('vendors').doc(restaurantId).get()
    .then((docSnapshot) => {
        console.log('✅ ============================================');
        console.log('✅ Firestore Query Completed');
        console.log('✅ ============================================');
        console.log('');
        
        if (!docSnapshot.exists) {
            console.error('❌ Document does not exist!');
            console.error('❌ Restaurant ID:', restaurantId);
            console.error('❌ Please verify the ID in Firestore console.');
            process.exit(1);
        }
        
        const restaurant = docSnapshot.data();
        restaurant.id = docSnapshot.id;
        
        console.log('✅ Document exists: YES');
        console.log('✅ Document ID:', restaurant.id);
        console.log('');
        console.log('📊 ============================================');
        console.log('📊 RESTAURANT DATA:');
        console.log('📊 ============================================');
        console.log('');
        
        // Print all data as JSON
        console.log('📋 Complete Restaurant Object (JSON):');
        console.log('============================================');
        console.log(JSON.stringify(restaurant, null, 2));
        console.log('============================================');
        console.log('');
        
        // Print individual fields
        console.log('📋 Individual Fields:');
        console.log('============================================');
        console.log('  id:', restaurant.id || 'N/A');
        console.log('  title:', restaurant.title || 'N/A');
        console.log('  phonenumber:', restaurant.phonenumber || 'N/A');
        console.log('  countryCode:', restaurant.countryCode || 'N/A');
        console.log('  location:', restaurant.location || 'N/A');
        console.log('  latitude:', restaurant.latitude || 'N/A');
        console.log('  longitude:', restaurant.longitude || 'N/A');
        console.log('  description:', restaurant.description || 'N/A');
        console.log('  zoneId:', restaurant.zoneId || 'N/A');
        console.log('  categoryID:', Array.isArray(restaurant.categoryID) ? restaurant.categoryID.join(', ') : (restaurant.categoryID || 'N/A'));
        console.log('  photo:', restaurant.photo || 'N/A');
        console.log('  photos:', restaurant.photos ? `Array(${restaurant.photos.length} items)` : 'N/A');
        console.log('  restaurantMenuPhotos:', restaurant.restaurantMenuPhotos ? `Array(${restaurant.restaurantMenuPhotos.length} items)` : 'N/A');
        console.log('  workingHours:', restaurant.workingHours ? `Array(${restaurant.workingHours.length} items)` : 'N/A');
        console.log('  specialDiscount:', restaurant.specialDiscount ? `Array(${restaurant.specialDiscount.length} items)` : 'N/A');
        console.log('  adminCommission:', restaurant.adminCommission ? JSON.stringify(restaurant.adminCommission) : 'N/A');
        console.log('  filters:', restaurant.filters ? JSON.stringify(restaurant.filters) : 'N/A');
        console.log('  isSelfDelivery:', restaurant.isSelfDelivery || 'N/A');
        console.log('  enabledDiveInFuture:', restaurant.enabledDiveInFuture || 'N/A');
        console.log('  openDineTime:', restaurant.openDineTime || 'N/A');
        console.log('  closeDineTime:', restaurant.closeDineTime || 'N/A');
        console.log('  restaurantCost:', restaurant.restaurantCost || 'N/A');
        console.log('  DeliveryCharge:', restaurant.DeliveryCharge ? JSON.stringify(restaurant.DeliveryCharge) : 'N/A');
        console.log('  gst:', restaurant.gst || 'N/A');
        console.log('  enableDND:', restaurant.enableDND || 'N/A');
        console.log('  author:', restaurant.author || 'N/A');
        console.log('  createdAt:', restaurant.createdAt ? restaurant.createdAt.toDate().toISOString() : 'N/A');
        console.log('============================================');
        console.log('');
        console.log('✅ ============================================');
        console.log('✅ Data fetched successfully!');
        console.log('✅ ============================================');
        
        process.exit(0);
    })
    .catch((error) => {
        console.error('');
        console.error('❌ ============================================');
        console.error('❌ ERROR: Failed to fetch restaurant data');
        console.error('❌ ============================================');
        console.error('❌ Error Code:', error.code || 'N/A');
        console.error('❌ Error Message:', error.message || 'N/A');
        console.error('❌ Error Name:', error.name || 'N/A');
        console.error('❌ ============================================');
        console.error('');
        
        if (error.code === 16 || error.code === 'unauthenticated') {
            console.error('💡 Solution for UNAUTHENTICATED error:');
            console.error('   1. Go to Google Cloud Console');
            console.error('   2. IAM & Admin → IAM');
            console.error('   3. Find your Service Account');
            console.error('   4. Grant these roles:');
            console.error('      - Firebase Admin SDK Administrator Service Agent');
            console.error('      - Cloud Datastore User');
            console.error('   5. Wait 2-3 minutes for changes to take effect');
        } else if (error.code === 'permission-denied') {
            console.error('💡 Solution:');
            console.error('   1. Check Firestore Rules');
            console.error('   2. Verify Service Account has proper IAM roles');
        } else if (error.code === 'not-found') {
            console.error('💡 Solution:');
            console.error('   1. Verify the restaurant ID exists in Firestore');
            console.error('   2. Check the collection name (should be "vendors")');
        }
        
        console.error('');
        process.exit(1);
    });







