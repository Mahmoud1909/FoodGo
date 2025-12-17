/**
 * Firestore Helper Functions
 * Use these functions in all pages to ensure proper Firestore connection
 */

// Wait for Firestore to be ready and execute callback
window.waitForFirestore = function(callback, retryCount) {
    retryCount = retryCount || 0;
    var maxRetries = 20; // 10 seconds max
    
    var db = window.getFirestoreDatabase();
    if (db) {
        callback(db);
    } else if (retryCount < maxRetries) {
        setTimeout(function() {
            window.waitForFirestore(callback, retryCount + 1);
        }, 500);
    } else {
        console.error('❌ Firestore not available after 10 seconds');
        if (callback) {
            callback(null); // Call with null to indicate failure
        }
    }
};

// Get Firestore database instance
window.getFirestoreDatabase = function() {
    // Try to use global database from app.blade.php
    if (typeof database !== 'undefined' && database !== null) {
        return database;
    }
    
    // Try to use window.firestoreDatabase
    if (typeof window.firestoreDatabase !== 'undefined' && window.firestoreDatabase !== null) {
        return window.firestoreDatabase;
    }
    
    // Try to create new instance if Firebase is ready
    if (typeof firebase !== 'undefined' && firebase.apps && firebase.apps.length > 0) {
        try {
            return firebase.firestore();
        } catch (e) {
            console.error('Error getting Firestore:', e);
            return null;
        }
    }
    
    console.warn('Firestore not initialized yet');
    return null;
};

// Safe Firestore query with error handling
window.safeFirestoreQuery = function(query, onSuccess, onError) {
    if (!query) {
        if (onError) onError(new Error('Query is null'));
        return;
    }
    
    query.get().then(function(snapshot) {
        if (onSuccess) onSuccess(snapshot);
    }).catch(function(error) {
        console.error('Firestore query error:', error);
        if (onError) {
            onError(error);
        } else {
            // Default error handling
            if (error.code === 'failed-precondition') {
                console.warn('Query requires an index. Please create it in Firebase Console.');
            }
        }
    });
};

// Safe Firestore document update
window.safeFirestoreUpdate = function(docRef, data, onSuccess, onError) {
    if (!docRef) {
        if (onError) onError(new Error('Document reference is null'));
        return;
    }
    
    docRef.update(data).then(function() {
        if (onSuccess) onSuccess();
    }).catch(function(error) {
        console.error('Firestore update error:', error);
        if (onError) {
            onError(error);
        }
    });
};

// Safe Firestore document set
window.safeFirestoreSet = function(docRef, data, onSuccess, onError) {
    if (!docRef) {
        if (onError) onError(new Error('Document reference is null'));
        return;
    }
    
    docRef.set(data).then(function() {
        if (onSuccess) onSuccess();
    }).catch(function(error) {
        console.error('Firestore set error:', error);
        if (onError) {
            onError(error);
        }
    });
};
















