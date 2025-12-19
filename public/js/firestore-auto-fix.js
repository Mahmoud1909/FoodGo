/**
 * Auto-Fix for All Firestore Pages
 * This script automatically fixes all pages that use var database = firebase.firestore()
 * It runs after Firestore is initialized and fixes all script tags
 */

(function() {
    'use strict';
    
    var isFixed = false;
    
    function autoFixAllPages() {
        if (isFixed) return;
        
        // Wait for Firestore to be ready
        if (typeof firebase === 'undefined' || !firebase.apps || firebase.apps.length === 0) {
            setTimeout(autoFixAllPages, 200);
            return;
        }
        
        if (typeof firebase.firestore !== 'function') {
            setTimeout(autoFixAllPages, 200);
            return;
        }
        
        // Get global database
        var globalDb = null;
        if (typeof database !== 'undefined' && database !== null) {
            globalDb = database;
        } else if (typeof window.firestoreDatabase !== 'undefined' && window.firestoreDatabase !== null) {
            globalDb = window.firestoreDatabase;
        } else {
            try {
                // Check if Firebase is initialized before calling firestore()
                if (!firebase.apps || firebase.apps.length === 0) {
                    console.warn('⚠️ Firebase not initialized yet, will retry...');
                    setTimeout(autoFixAllPages, 200);
                    return;
                }
                globalDb = firebase.firestore();
                window.firestoreDatabase = globalDb;
                if (typeof database === 'undefined') {
                    window.database = globalDb;
                }
            } catch (e) {
                if (e.message && e.message.includes('No Firebase App')) {
                    console.warn('⚠️ Firebase not initialized yet:', e.message);
                    setTimeout(autoFixAllPages, 200);
                } else {
                    console.warn('Could not create Firestore instance:', e);
                    setTimeout(autoFixAllPages, 200);
                }
                return;
            }
        }
        
        // Override firebase.firestore() globally
        if (firebase.firestore && !firebase.firestore._autoFixed) {
            var originalFirestore = firebase.firestore;
            firebase.firestore = function() {
                if (globalDb) {
                    return globalDb;
                }
                return originalFirestore();
            };
            firebase.firestore._autoFixed = true;
        }
        
        // Fix all inline scripts
        var scripts = document.querySelectorAll('script:not([src])');
        scripts.forEach(function(script) {
            if (script.dataset.firestoreAutoFixed) return;
            
            var code = script.innerHTML;
            if (code && typeof code === 'string') {
                // Fix var database = firebase.firestore()
                if (code.includes('var database = firebase.firestore()')) {
                    code = code.replace(
                        /var\s+database\s*=\s*firebase\.firestore\(\)/g,
                        'var database = (typeof database !== "undefined" && database !== null) ? database : (typeof window.firestoreDatabase !== "undefined" ? window.firestoreDatabase : firebase.firestore())'
                    );
                    script.innerHTML = code;
                    script.dataset.firestoreAutoFixed = 'true';
                }
            }
        });
        
        isFixed = true;
        console.log('✅ Auto-fix applied to all pages');
    }
    
    // Start fixing when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(autoFixAllPages, 500);
        });
    } else {
        setTimeout(autoFixAllPages, 500);
    }
    
    // Also run on window load
    window.addEventListener('load', function() {
        setTimeout(autoFixAllPages, 1000);
    });
    
    // Watch for dynamically added scripts
    if (typeof MutationObserver !== 'undefined') {
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.tagName === 'SCRIPT' && !node.src) {
                        setTimeout(autoFixAllPages, 100);
                    }
                });
            });
        });
        
        if (document.body) {
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        } else {
            document.addEventListener('DOMContentLoaded', function() {
                if (document.body) {
                    observer.observe(document.body, {
                        childList: true,
                        subtree: true
                    });
                }
            });
        }
    }
})();




