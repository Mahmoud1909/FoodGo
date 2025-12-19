const admin = require('firebase-admin');
const path = require('path');
const fs = require('fs');

// Check if credentials.json exists
const credentialsPath = path.join(__dirname, 'credentials.json');
if (!fs.existsSync(credentialsPath)) {
    console.error('❌ ERROR: credentials.json not found!');
    console.error('❌ Please create credentials.json with your Firebase service account key');
    process.exit(1);
}

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

// Initialize Firebase Admin SDK
if (!admin.apps.length) {
    try {
        admin.initializeApp({
            credential: admin.credential.cert(serviceAccount),
            projectId: serviceAccount.project_id
        });
        console.log('✅ Firebase Admin initialized');
    } catch (error) {
        console.error('❌ ERROR: Failed to initialize Firebase Admin');
        console.error('❌ Error:', error.message);
        process.exit(1);
    }
}

const db = admin.firestore();

// Restaurant ID
const restaurantId = '5KjbF2LDaEe19ttEFClo';

console.log('🔍 ============================================');
console.log('🔍 Fetching Restaurant Data from Firestore');
console.log('🔍 ============================================');
console.log('🔍 Restaurant ID:', restaurantId);
console.log('🔍 Collection: vendors');
console.log('🔍 ============================================');

// Get restaurant document
db.collection('vendors').doc(restaurantId).get()
    .then((docSnapshot) => {
        console.log('\n✅ ============================================');
        console.log('✅ Firestore Query Completed');
        console.log('✅ ============================================');
        
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
        console.log('\n📊 ============================================');
        console.log('📊 RESTAURANT DATA:');
        console.log('📊 ============================================');
        
        // Print all data
        console.log('\n📋 Complete Restaurant Object:');
        console.log(JSON.stringify(restaurant, null, 2));
        
        console.log('\n📋 Individual Fields:');
        console.log('  - id:', restaurant.id || 'N/A');
        console.log('  - title:', restaurant.title || 'N/A');
        console.log('  - phonenumber:', restaurant.phonenumber || 'N/A');
        console.log('  - countryCode:', restaurant.countryCode || 'N/A');
        console.log('  - location:', restaurant.location || 'N/A');
        console.log('  - latitude:', restaurant.latitude || 'N/A');
        console.log('  - longitude:', restaurant.longitude || 'N/A');
        console.log('  - description:', restaurant.description || 'N/A');
        console.log('  - zoneId:', restaurant.zoneId || 'N/A');
        console.log('  - categoryID:', restaurant.categoryID || 'N/A');
        console.log('  - photo:', restaurant.photo || 'N/A');
        console.log('  - photos:', restaurant.photos ? `Array(${restaurant.photos.length})` : 'N/A');
        console.log('  - restaurantMenuPhotos:', restaurant.restaurantMenuPhotos ? `Array(${restaurant.restaurantMenuPhotos.length})` : 'N/A');
        console.log('  - workingHours:', restaurant.workingHours ? `Array(${restaurant.workingHours.length})` : 'N/A');
        console.log('  - specialDiscount:', restaurant.specialDiscount ? `Array(${restaurant.specialDiscount.length})` : 'N/A');
        console.log('  - adminCommission:', restaurant.adminCommission || 'N/A');
        console.log('  - filters:', restaurant.filters || 'N/A');
        console.log('  - isSelfDelivery:', restaurant.isSelfDelivery || 'N/A');
        console.log('  - enabledDiveInFuture:', restaurant.enabledDiveInFuture || 'N/A');
        console.log('  - openDineTime:', restaurant.openDineTime || 'N/A');
        console.log('  - closeDineTime:', restaurant.closeDineTime || 'N/A');
        console.log('  - restaurantCost:', restaurant.restaurantCost || 'N/A');
        console.log('  - DeliveryCharge:', restaurant.DeliveryCharge || 'N/A');
        console.log('  - gst:', restaurant.gst || 'N/A');
        console.log('  - enableDND:', restaurant.enableDND || 'N/A');
        console.log('  - author:', restaurant.author || 'N/A');
        console.log('  - createdAt:', restaurant.createdAt ? restaurant.createdAt.toDate().toISOString() : 'N/A');
        
        console.log('\n✅ ============================================');
        console.log('✅ Data fetched successfully!');
        console.log('✅ ============================================');
        
        process.exit(0);
    })
    .catch((error) => {
        console.error('\n❌ ============================================');
        console.error('❌ ERROR: Failed to fetch restaurant data');
        console.error('❌ ============================================');
        console.error('❌ Error Code:', error.code || 'N/A');
        console.error('❌ Error Message:', error.message || 'N/A');
        console.error('❌ Error Name:', error.name || 'N/A');
        console.error('❌ ============================================');
        
        if (error.code === 'permission-denied') {
            console.error('\n💡 Solution:');
            console.error('   1. Check Firestore Rules');
            console.error('   2. Verify Service Account has proper IAM roles');
            console.error('   3. Grant "Firebase Admin SDK Administrator Service Agent" role');
            console.error('   4. Grant "Cloud Datastore User" role');
        } else if (error.code === 'not-found') {
            console.error('\n💡 Solution:');
            console.error('   1. Verify the restaurant ID exists in Firestore');
            console.error('   2. Check the collection name (should be "vendors")');
        }
        
        process.exit(1);
    });

