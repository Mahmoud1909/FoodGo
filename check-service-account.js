/**
 * 🔍 Script to check Service Account details
 * This helps identify which Service Account is being used
 */

const path = require('path');
const fs = require('fs');

console.log('🔍 ============================================');
console.log('🔍 Checking Service Account Configuration');
console.log('🔍 ============================================');
console.log('');

// Check if credentials.json exists
const credentialsPath = path.join(__dirname, 'credentials.json');
if (!fs.existsSync(credentialsPath)) {
    console.error('❌ ERROR: credentials.json not found!');
    console.error('❌ Path:', credentialsPath);
    process.exit(1);
}

// Load service account
let serviceAccount;
try {
    serviceAccount = require(credentialsPath);
    console.log('✅ credentials.json loaded successfully');
    console.log('');
} catch (error) {
    console.error('❌ ERROR: Failed to load credentials.json');
    console.error('❌ Error:', error.message);
    process.exit(1);
}

// Display Service Account information
console.log('📋 Service Account Information:');
console.log('============================================');
console.log('  Project ID:', serviceAccount.project_id || 'N/A');
console.log('  Client Email:', serviceAccount.client_email || 'N/A');
console.log('  Private Key ID:', serviceAccount.private_key_id ? serviceAccount.private_key_id.substring(0, 20) + '...' : 'N/A');
console.log('  Auth URI:', serviceAccount.auth_uri || 'N/A');
console.log('  Token URI:', serviceAccount.token_uri || 'N/A');
console.log('  Auth Provider X509 Cert URL:', serviceAccount.auth_provider_x509_cert_url || 'N/A');
console.log('  Client X509 Cert URL:', serviceAccount.client_x509_cert_url || 'N/A');
console.log('============================================');
console.log('');

// Important: Service Account Email
if (serviceAccount.client_email) {
    console.log('⚠️  IMPORTANT:');
    console.log('============================================');
    console.log('  Service Account Email:', serviceAccount.client_email);
    console.log('');
    console.log('  هذا هو الـ Service Account الذي يجب أن تضيف له الصلاحيات في Google Cloud Console');
    console.log('');
    console.log('  الخطوات:');
    console.log('    1. اذهب إلى: https://console.cloud.google.com/iam-admin/iam?project=foodgo-e1252');
    console.log('    2. ابحث عن:', serviceAccount.client_email);
    console.log('    3. اضغط على Edit (قلم)');
    console.log('    4. أضف الأدوار:');
    console.log('       - Firebase Admin SDK Administrator Service Agent');
    console.log('       - Cloud Datastore User');
    console.log('    5. اضغط Save');
    console.log('    6. انتظر 2-3 دقائق');
    console.log('============================================');
} else {
    console.error('❌ ERROR: client_email not found in credentials.json');
    console.error('❌ This file might be corrupted or invalid');
    process.exit(1);
}

console.log('');
console.log('✅ ============================================');
console.log('✅ Service Account check completed');
console.log('✅ ============================================');


 * 🔍 Script to check Service Account details
 * This helps identify which Service Account is being used
 */

const path = require('path');
const fs = require('fs');

console.log('🔍 ============================================');
console.log('🔍 Checking Service Account Configuration');
console.log('🔍 ============================================');
console.log('');

// Check if credentials.json exists
const credentialsPath = path.join(__dirname, 'credentials.json');
if (!fs.existsSync(credentialsPath)) {
    console.error('❌ ERROR: credentials.json not found!');
    console.error('❌ Path:', credentialsPath);
    process.exit(1);
}

// Load service account
let serviceAccount;
try {
    serviceAccount = require(credentialsPath);
    console.log('✅ credentials.json loaded successfully');
    console.log('');
} catch (error) {
    console.error('❌ ERROR: Failed to load credentials.json');
    console.error('❌ Error:', error.message);
    process.exit(1);
}

// Display Service Account information
console.log('📋 Service Account Information:');
console.log('============================================');
console.log('  Project ID:', serviceAccount.project_id || 'N/A');
console.log('  Client Email:', serviceAccount.client_email || 'N/A');
console.log('  Private Key ID:', serviceAccount.private_key_id ? serviceAccount.private_key_id.substring(0, 20) + '...' : 'N/A');
console.log('  Auth URI:', serviceAccount.auth_uri || 'N/A');
console.log('  Token URI:', serviceAccount.token_uri || 'N/A');
console.log('  Auth Provider X509 Cert URL:', serviceAccount.auth_provider_x509_cert_url || 'N/A');
console.log('  Client X509 Cert URL:', serviceAccount.client_x509_cert_url || 'N/A');
console.log('============================================');
console.log('');

// Important: Service Account Email
if (serviceAccount.client_email) {
    console.log('⚠️  IMPORTANT:');
    console.log('============================================');
    console.log('  Service Account Email:', serviceAccount.client_email);
    console.log('');
    console.log('  هذا هو الـ Service Account الذي يجب أن تضيف له الصلاحيات في Google Cloud Console');
    console.log('');
    console.log('  الخطوات:');
    console.log('    1. اذهب إلى: https://console.cloud.google.com/iam-admin/iam?project=foodgo-e1252');
    console.log('    2. ابحث عن:', serviceAccount.client_email);
    console.log('    3. اضغط على Edit (قلم)');
    console.log('    4. أضف الأدوار:');
    console.log('       - Firebase Admin SDK Administrator Service Agent');
    console.log('       - Cloud Datastore User');
    console.log('    5. اضغط Save');
    console.log('    6. انتظر 2-3 دقائق');
    console.log('============================================');
} else {
    console.error('❌ ERROR: client_email not found in credentials.json');
    console.error('❌ This file might be corrupted or invalid');
    process.exit(1);
}

console.log('');
console.log('✅ ============================================');
console.log('✅ Service Account check completed');
console.log('✅ ============================================');







