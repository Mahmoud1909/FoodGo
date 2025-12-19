/**
 * Global Firestore Fix for All Pages
 * This script automatically fixes Firestore initialization issues in all pages
 */

(function() {
    'use strict';
    
    // Override firebase.firestore() to use the global database instance
    var originalFirestore = null;
    var isFixed = false;
    
    // Wait for Firebase to be ready
    function initGlobalFirestore() {
        if (typeof firebase === 'undefined') {
            setTimeout(initGlobalFirestore, 100);
            return;
        }
        
        // Check if Firebase is initialized
        if (!firebase.apps || firebase.apps.length === 0) {
            setTimeout(initGlobalFirestore, 100);
            return;
        }
        
        // Store original firestore function and override it
        if (firebase.firestore && !isFixed) {
            originalFirestore = firebase.firestore;
            
            // Override firebase.firestore() to return the global database
            firebase.firestore = function() {
                // Try to use global database first (from app.blade.php)
                if (typeof database !== 'undefined' && database !== null) {
                    return database;
                }
                
                // Try window.firestoreDatabase
                if (typeof window.firestoreDatabase !== 'undefined' && window.firestoreDatabase !== null) {
                    return window.firestoreDatabase;
                }
                
                // Fallback to original function
                if (originalFirestore) {
                    try {
                        // Check if Firebase is initialized before calling firestore()
                        if (!firebase.apps || firebase.apps.length === 0) {
                            console.warn('⚠️ Firebase not initialized yet, cannot create Firestore instance');
                            return null;
                        }
                        var db = originalFirestore();
                        // Store it globally for next time
                        window.firestoreDatabase = db;
                        // Also set global database variable if not set
                        if (typeof database === 'undefined') {
                            window.database = db;
                        }
                        return db;
                    } catch (e) {
                        if (e.message && e.message.includes('No Firebase App')) {
                            console.warn('⚠️ Firebase not initialized yet:', e.message);
                        } else {
                            console.error('Error creating Firestore instance:', e);
                        }
                        return null;
                    }
                }
                
                return null;
            };
            
            isFixed = true;
            console.log('✅ Global Firestore fix applied');
        }
    }
    
    // Also create a global database variable if it doesn't exist
    function ensureGlobalDatabase() {
        if (typeof firebase === 'undefined') {
            setTimeout(ensureGlobalDatabase, 100);
            return;
        }
        
        if (!firebase.apps || firebase.apps.length === 0) {
            setTimeout(ensureGlobalDatabase, 100);
            return;
        }
        
        // If database is not defined, create it
        if (typeof database === 'undefined') {
            try {
                // Check if Firebase is initialized
                if (firebase.apps && firebase.apps.length > 0 && firebase.firestore) {
                    window.database = firebase.firestore();
                    console.log('✅ Global database variable created');
                } else {
                    console.warn('⚠️ Firebase not initialized yet, will retry...');
                    setTimeout(ensureGlobalDatabase, 200);
                }
            } catch (e) {
                console.warn('Could not create global database:', e);
                if (e.message && e.message.includes('No Firebase App')) {
                    setTimeout(ensureGlobalDatabase, 200);
                }
            }
        }
    }
    
    // Start initialization when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initGlobalFirestore();
            ensureGlobalDatabase();
        });
    } else {
        initGlobalFirestore();
        ensureGlobalDatabase();
    }
    
    // Also try when window loads
    window.addEventListener('load', function() {
        setTimeout(function() {
            initGlobalFirestore();
            ensureGlobalDatabase();
        }, 500);
    });
    
    // Intercept and fix database initialization in script tags
    function interceptScriptTags() {
        // Find all script tags and fix them
        var scripts = document.querySelectorAll('script:not([src])');
        scripts.forEach(function(script) {
            if (script.dataset.firestoreFixed) return; // Already fixed
            
            var code = script.innerHTML;
            if (code && code.includes('var database = firebase.firestore()')) {
                // Replace with safe version
                code = code.replace(
                    /var\s+database\s*=\s*firebase\.firestore\(\)/g,
                    'var database = (typeof database !== "undefined" && database !== null) ? database : (window.getFirestoreDatabase ? window.getFirestoreDatabase() : (typeof firebase !== "undefined" && firebase.firestore ? firebase.firestore() : null))'
                );
                script.innerHTML = code;
                script.dataset.firestoreFixed = 'true';
            }
        });
    }
    
    // Run after DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(interceptScriptTags, 500);
        });
    } else {
        setTimeout(interceptScriptTags, 500);
    }
    
    // Also intercept new script tags added dynamically
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.tagName === 'SCRIPT' && !node.src) {
                    setTimeout(interceptScriptTags, 100);
                }
            });
        });
    });
    
    observer.observe(document.body || document.documentElement, {
        childList: true,
        subtree: true
    });
})();


