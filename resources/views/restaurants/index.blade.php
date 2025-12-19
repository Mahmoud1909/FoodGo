@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{ trans('lang.restaurant_plural') }}</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ trans('lang.dashboard') }}</a></li>
                    <li class="breadcrumb-item">{{ trans('lang.restaurant_plural') }}</li>
                    <li class="breadcrumb-item active">{{ trans('lang.restaurant_table') }}</li>
                </ol>
            </div>
            <div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="admin-top-section">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex top-title-section pb-4 justify-content-between">
                            <div class="d-flex top-title-left align-self-center">
                                <span class="icon mr-3"><img src="{{ asset('images/restaurant.png') }}"></span>
                                <h3 class="mb-0">{{ trans('lang.restaurant_plural') }}</h3>
                                <span class="counter ml-3 rest_count"></span>
                            </div>
                            <div class="d-flex top-title-right align-self-center">
                                <div class="select-box pl-3">
                                    <select class="form-control restaurant_type_selector">
                                        <option value="">{{ trans('lang.restaurant_type') }}</option>
                                        <option value="true">{{ trans('lang.dine_in') }}</option>
                                    </select>
                                </div>
                                <div class="select-box pl-3">
                                    <select class="form-control business_model_selector">
                                        <option value="" disabled selected>{{ trans('lang.business_model') }}</option>
                                    </select>
                                </div>
                                <div class="select-box pl-3">
                                    <select class="form-control cuisine_selector">
                                        <option value="" disabled selected>{{ trans('lang.select_cuisines') }}</option>
                                    </select>
                                </div>
                                <div class="select-box pl-3">
                                    <select class="form-control zone_selector">
                                        <option value="" disabled selected>{{ trans('lang.select_zone') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card border">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card card-box-with-icon bg--1">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div class="card-box-with-content">
                                                    <h4 class="text-dark-2 mb-1 h4 rest_count">00</h4>
                                                    <p class="mb-0 small text-dark-2">{{ trans('lang.dashboard_total_restaurants') }}</p>
                                                </div>
                                                <span class="box-icon ab"><img src="{{ asset('images/restaurant_icon.png') }}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-box-with-icon bg--5">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div class="card-box-with-content">
                                                    <h4 class="text-dark-2 mb-1 h4 rest_active_count">00</h4>
                                                    <p class="mb-0 small text-dark-2">{{ trans('lang.active_restaurants') }}</p>
                                                </div>
                                                <span class="box-icon ab"><img src="{{ asset('images/active_restaurant.png') }}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-box-with-icon bg--8">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div class="card-box-with-content">
                                                    <h4 class="text-dark-2 mb-1 h4 rest_inactive_count">00</h4>
                                                    <p class="mb-0 small text-dark-2">{{ trans('lang.inactive_restaurants') }}</p>
                                                </div>
                                                <span class="box-icon ab"><img src="{{ asset('images/inactive_restaurant.png') }}"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-box-with-icon bg--6">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div class="card-box-with-content">
                                                    <h4 class="text-dark-2 mb-1 h4 new_joined_rest">00</h4>
                                                    <p class="mb-0 small text-dark-2">{{ trans('lang.new_joined_restaurants') }}</p>
                                                </div>
                                                <span class="box-icon ab"><img src="{{ asset('images/new_restaurant.png') }}"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-list">
                <div class="row">
                    <div class="col-12">
                        <div class="card border">
                            <div class="card-header d-flex justify-content-between align-items-center border-0">
                                <div class="card-header-title">
                                    <h3 class="text-dark-2 mb-2 h4">{{ trans('lang.restaurant_table') }}</h3>
                                    <p class="mb-0 text-dark-2">{{ trans('lang.restaurants_table_text') }}</p>
                                </div>
                                <div class="card-header-right d-flex align-items-center">
                                    <div class="card-header-btn mr-3">
                                        <a href="{!! route('restaurants.create') !!}" class="btn-primary btn rounded-full"><i class="mdi mdi-plus mr-2"></i>{{ trans('lang.create_restaurant') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive m-t-10">
                                    <table id="storeTable" class="display nowrap table table-hover table-striped table-bordered table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <?php if (in_array('restaurant.delete', json_decode(@session('user_permissions'), true))) { ?>
                                                <th class="delete-all"><input type="checkbox" id="is_active"><label class="col-3 control-label" for="is_active"><a id="deleteAll" class="do_not_delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i> {{ trans('lang.all') }}</a></label>
                                                </th>
                                                <?php } ?>
                                                <th>{{ trans('lang.restaurant_info') }}</th>
                                                <th>{{ trans('lang.owner_info') }}</th>
                                                <th>{{ trans('lang.date') }}</th>
                                                <th>{{ trans('lang.wallet_history') }}</th>
                                                <th>{{ trans('lang.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="append_restaurants"></tbody>
                                    </table>
                                </div>
                                <!-- Popup -->
                                <div class="modal fade" id="create_vendor" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered notification-main" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ trans('lang.copy_vendor') }}
                                                    <span id="vendor_title_lable"></span>
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">
                                                    {{ trans('lang.processing') }}
                                                </div>
                                                <div class="error_top"></div>
                                                <!-- Form -->
                                                <form id="vendor-clone-form" method="post" action="javascript:void(0);">
                                                    <div class="form-row">
                                                        <div class="col-md-12 form-group">
                                                            <label class="form-label">{{ trans('lang.first_name') }}</label>
                                                            <div class="input-group">
                                                                <input placeholder="Name" type="text" id="user_name" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <label class="form-label">{{ trans('lang.last_name') }}</label>
                                                            <div class="input-group">
                                                                <input placeholder="Name" type="text" id="user_last_name" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <label class="form-label">{{ trans('lang.vendor_title') }}</label>
                                                            <div class="input-group">
                                                                <input placeholder="Vendor Title" type="text" id="vendor_title" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form-group"><label class="form-label">{{ trans('lang.email') }}</label><input placeholder="Email" value="" id="user_email" type="text" class="form-control"></div>
                                                        <div class="col-md-12 form-group"><label class="form-label">{{ trans('lang.password') }}</label><input placeholder="Password" id="user_password" type="password" class="form-control" autocomplete="new-password"></div>
                                                    </div>
                                                </form>
                                                <!-- Form -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary save-form-btn">{{ trans('lang.create') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Popup -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        console.log('🚀 [PAGE LOAD] ========================================');
        console.log('🚀 [PAGE LOAD] Restaurants Page Script Started');
        console.log('🚀 [PAGE LOAD] ========================================');
        console.log('📅 [PAGE LOAD] Timestamp:', new Date().toISOString());
        
        var database = null;
        var refData = null;
        var currentCurrency = '';
        var currencyAtRight = false;
        var decimal_degits = 0;
        
        console.log('✅ [PAGE LOAD] Variables initialized');
        
        // Helper function to send logs to Laravel backend
        function sendLogToServer(level, message, data) {
            // Default empty object if data is not provided
            if (typeof data === 'undefined' || data === null) {
                data = {};
            }
            
            // Log to console first - safely log data
            if (level === 'error') {
                console.error('❌', message);
                if (data && typeof data === 'object') {
                    try {
                        Object.keys(data).forEach(function(key) {
                            console.error('❌', key + ':', data[key]);
                        });
                    } catch (e) {
                        console.error('❌', 'Data:', JSON.stringify(data));
                    }
                } else if (data) {
                    console.error('❌', 'Data:', data);
                }
            } else if (level === 'warning') {
                console.warn('⚠️', message);
                if (data && typeof data === 'object') {
                    try {
                        Object.keys(data).forEach(function(key) {
                            console.warn('⚠️', key + ':', data[key]);
                        });
                    } catch (e) {
                        console.warn('⚠️', 'Data:', JSON.stringify(data));
                    }
                } else if (data) {
                    console.warn('⚠️', 'Data:', data);
                }
            } else {
                console.log('📝', message);
                if (data && typeof data === 'object') {
                    try {
                        Object.keys(data).forEach(function(key) {
                            console.log('📝', key + ':', data[key]);
                        });
                    } catch (e) {
                        console.log('📝', 'Data:', JSON.stringify(data));
                    }
                } else if (data) {
                    console.log('📝', 'Data:', data);
                }
            }
            
            // Send to Laravel backend
            try {
                $.ajax({
                    url: '{{ route("restaurants.log") }}',
                    method: 'POST',
                    data: {
                        level: level,
                        message: message,
                        data: data,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Log sent successfully
                    },
                    error: function(xhr, status, error) {
                        // Silently fail - don't log errors about logging
                    }
                });
            } catch (e) {
                // Silently fail
            }
        }
        
        // Wait for Firestore to be ready - same as drivers page
        console.log('🔄 [INIT] Waiting for Firestore to be ready...');
        window.waitForFirestore(function(db) {
            console.log('🔄 [INIT] waitForFirestore callback called');
            console.log('🔄 [INIT] Database received:', !!db);
            
            if (!db) {
                console.error('❌ [INIT] ========================================');
                console.error('❌ [INIT] Firestore NOT AVAILABLE!');
                console.error('❌ [INIT] ========================================');
                console.error('❌ [INIT] Cannot initialize restaurants page');
                console.error('❌ [INIT] Check Firebase configuration');
                return;
            }
            
            console.log('✅ [INIT] Firestore is available!');
            database = db;
            refData = database.collection('vendors');
            console.log('✅ [INIT] Database and refData initialized');
            console.log('✅ [INIT] Collection: vendors');
            
            // 🔥 إضافة Real-time Listener للـ vendors collection
            console.log('🔥 [REALTIME] Setting up Real-time listeners...');
            setupRealtimeListeners();
            
            // 🔥 تأكيد الاتصال 100% مع Firestore
            console.log('🔥 [FIRESTORE TEST] ========================================');
            console.log('🔥 [FIRESTORE TEST] اختبار الاتصال مع Firestore...');
            console.log('🔥 [FIRESTORE TEST] ========================================');
            
            // Test 1: Test basic connection
            var testConnection = database.collection('vendors').limit(1);
            testConnection.get().then(function(testSnapshot) {
                console.log('✅ [FIRESTORE TEST] ✅ Test 1: Basic Connection - SUCCESS');
                console.log('✅ [FIRESTORE TEST] Firestore is responding correctly');
                console.log('✅ [FIRESTORE TEST] Can read from vendors collection');
                console.log('✅ [FIRESTORE TEST] Documents found:', testSnapshot.docs.length);
                
                // Test 2: Test with orderBy
                var testOrderBy = database.collection('vendors').orderBy('createdAt', 'desc').limit(1);
                testOrderBy.get().then(function(orderBySnapshot) {
                    console.log('✅ [FIRESTORE TEST] ✅ Test 2: OrderBy Query - SUCCESS');
                    console.log('✅ [FIRESTORE TEST] Index is working correctly');
                    console.log('✅ [FIRESTORE TEST] ========================================');
                    console.log('✅ [FIRESTORE TEST] ✅✅✅ Firestore متصل 100% ✅✅✅');
                    console.log('✅ [FIRESTORE TEST] ========================================');
                }).catch(function(orderByError) {
                    if (orderByError.code === 'failed-precondition') {
                        console.warn('⚠️ [FIRESTORE TEST] ⚠️ Test 2: OrderBy Query - INDEX MISSING');
                        console.warn('⚠️ [FIRESTORE TEST] Basic connection works, but index is missing');
                        console.warn('⚠️ [FIRESTORE TEST] Run: firebase deploy --only firestore:indexes');
                    } else {
                        console.error('❌ [FIRESTORE TEST] ❌ Test 2: OrderBy Query - FAILED');
                        console.error('❌ [FIRESTORE TEST] Error:', orderByError.message);
                    }
                    console.log('✅ [FIRESTORE TEST] ========================================');
                    console.log('✅ [FIRESTORE TEST] ✅ Firestore متصل (مع تحذيرات)');
                    console.log('✅ [FIRESTORE TEST] ========================================');
                });
            }).catch(function(testError) {
                console.error('❌ [FIRESTORE TEST] ❌ Test 1: Basic Connection - FAILED');
                console.error('❌ [FIRESTORE TEST] Error Code:', testError.code);
                console.error('❌ [FIRESTORE TEST] Error Message:', testError.message);
                if (testError.code === 'permission-denied') {
                    console.error('🚫 [FIRESTORE TEST] PERMISSION DENIED!');
                    console.error('🚫 [FIRESTORE TEST] Firestore Rules are blocking access');
                    console.error('🚫 [FIRESTORE TEST] Run: firebase deploy --only firestore:rules');
                }
                console.error('❌ [FIRESTORE TEST] ========================================');
                console.error('❌ [FIRESTORE TEST] ❌ Firestore غير متصل');
                console.error('❌ [FIRESTORE TEST] ========================================');
            });
            
            // Load placeholder image
            var placeholder = database.collection('settings').doc('placeHolderImage');
            placeholder.get().then(async function(snapshotsimage) {
                if (snapshotsimage.exists) {
                    var placeholderImageData = snapshotsimage.data();
                    if (placeholderImageData && placeholderImageData.image) {
                        placeholderImage = placeholderImageData.image;
                    }
                }
            }).catch(function(error) {
                console.warn('Error loading placeholder image');
                console.warn('Error Code:', error.code || 'N/A');
                console.warn('Error Message:', error.message || 'Unknown error');
            });
            
            // Load currency
            var refCurrency = database.collection('currencies').where('isActive', '==', true);
            refCurrency.get().then(async function(snapshots) {
                if (snapshots.docs.length > 0) {
                    var currencyData = snapshots.docs[0].data();
                    currentCurrency = currencyData.symbol || '$';
                    currencyAtRight = currencyData.symbolAtRight || false;
                    if (currencyData.decimal_degits) {
                        decimal_degits = currencyData.decimal_degits;
                    }
                } else {
                    currentCurrency = '$';
                    currencyAtRight = false;
                    decimal_degits = 2;
                }
                // Initialize page after currency is loaded
                initRestaurantsPage();
            }).catch(function(error) {
                console.warn('Error loading currency');
                console.warn('Error Code:', error.code || 'N/A');
                console.warn('Error Message:', error.message || 'Unknown error');
                currentCurrency = '$';
                currencyAtRight = false;
                decimal_degits = 2;
                // Initialize page even if currency fails
            initRestaurantsPage();
            });
        });
        
        function initRestaurantsPage() {
            console.log('📋 [INIT PAGE] initRestaurantsPage() called');
            if (!database) {
                console.error('❌ [INIT PAGE] Database not available in initRestaurantsPage');
                console.error('❌ [INIT PAGE] database variable:', database);
                console.error('❌ [INIT PAGE] window.database:', window.database);
                return;
            }
            
            console.log('✅ [INIT PAGE] Database is available');
            console.log('✅ [INIT PAGE] Initializing restaurants page...');
            
            // Initialize refData
            refData = database.collection('vendors');
            console.log('✅ [INIT PAGE] refData initialized to vendors collection');
            console.log('✅ [INIT PAGE] refData type:', typeof refData);
            
            // Setup filter change handler
            console.log('🔧 [INIT PAGE] Setting up filter change handlers...');
            $('select').change(async function() {
                console.log('🔄 [FILTER] Filter change detected');
                if (!database) {
                    console.error('❌ [FILTER] Database not available');
                    return;
                }
                var zoneValue = $('.zone_selector').val();
                var restaurantTypeValue = $('.restaurant_type_selector').val();
                var businessModelValue = $('.business_model_selector').val();
                var cuisineValue = $('.cuisine_selector').val();
                console.log('🔄 [FILTER] Filter values:');
                console.log('🔄 [FILTER] Zone:', zoneValue);
                console.log('🔄 [FILTER] Restaurant Type:', restaurantTypeValue);
                console.log('🔄 [FILTER] Business Model:', businessModelValue);
                console.log('🔄 [FILTER] Cuisine:', cuisineValue);
                
                refData = database.collection('vendors');
                console.log('🔄 [FILTER] Starting with base vendors collection');
                
                if (zoneValue) {
                    refData = refData.where('zoneId', '==', zoneValue);
                    console.log('🔄 [FILTER] Added zone filter:', zoneValue);
                }
                if (restaurantTypeValue == "true") {
                    refData = refData.where('enabledDiveInFuture', '==', true);
                    console.log('🔄 [FILTER] Added restaurant type filter: dine-in');
                }
                if (businessModelValue) {
                    console.log('🔄 [FILTER] Getting vendor IDs for business model:', businessModelValue);
                    var vendorSelectedIds = await subscriptionPlanVendorIds(businessModelValue);
                    console.log('🔄 [FILTER] Vendor IDs found:', vendorSelectedIds.length, vendorSelectedIds);
                    if (vendorSelectedIds.length > 0) {
                        refData = refData.where('id', 'in', vendorSelectedIds);
                        console.log('🔄 [FILTER] Added business model filter with', vendorSelectedIds.length, 'vendor IDs');
                    } else {
                        refData = refData.where('id', '==', null);
                        console.log('🔄 [FILTER] No vendor IDs found, filtering to null');
                    }
                }
                if (cuisineValue) {
                    refData = refData.where('categoryID', '==', cuisineValue);
                    console.log('🔄 [FILTER] Added cuisine filter:', cuisineValue);
                }
                console.log('🔄 [FILTER] Final query reference created');
                console.log('🔄 [FILTER] Reloading table...');
                if ($.fn.DataTable.isDataTable('#storeTable')) {
                    console.log('✅ [FILTER] DataTable exists, calling ajax.reload()');
                    $('#storeTable').DataTable().ajax.reload();
                } else {
                    console.warn('⚠️ [FILTER] DataTable not initialized yet');
                }
            });
            console.log('✅ [INIT PAGE] Filter handlers set up');
            
            // Load dropdowns data
            console.log('📋 [INIT PAGE] Loading dropdowns data...');
            loadDropdownsData();
            
            // Initialize DataTable
            console.log('📋 [INIT PAGE] Initializing DataTable...');
            // Use setTimeout to ensure DOM is ready
            setTimeout(function() {
                initializeDataTable();
            }, 100);
            console.log('✅ [INIT PAGE] initRestaurantsPage() completed');
        }
        
        // 🔥 Real-time Listeners Setup
        var vendorsListener = null;
        var zonesListener = null;
        var categoriesListener = null;
        var subscriptionPlansListener = null;
        
        function setupRealtimeListeners() {
            console.log('🔥 [REALTIME] ========================================');
            console.log('🔥 [REALTIME] Setting up Real-time Firebase Listeners');
            console.log('🔥 [REALTIME] ========================================');
            
            if (!database) {
                console.error('❌ [REALTIME] Database not available');
                return;
            }
            
            // 1. Real-time Listener للـ vendors collection
            console.log('🔥 [REALTIME] Setting up vendors collection listener...');
            if (vendorsListener) {
                vendorsListener(); // Unsubscribe previous listener
            }
            
            vendorsListener = database.collection('vendors')
                .orderBy('createdAt', 'desc')
                .onSnapshot(function(querySnapshot) {
                    console.log('🔥 [REALTIME] ========================================');
                    console.log('🔥 [REALTIME] 🔥 VENDORS COLLECTION UPDATED! 🔥');
                    console.log('🔥 [REALTIME] ========================================');
                    console.log('🔥 [REALTIME] Changes detected:', querySnapshot.docChanges().length);
                    
                    var hasChanges = false;
                    querySnapshot.docChanges().forEach(function(change) {
                        if (change.type === 'added') {
                            console.log('🔥 [REALTIME] ➕ NEW RESTAURANT ADDED:', change.doc.id);
                            hasChanges = true;
                        } else if (change.type === 'modified') {
                            console.log('🔥 [REALTIME] ✏️ RESTAURANT UPDATED:', change.doc.id);
                            hasChanges = true;
                        } else if (change.type === 'removed') {
                            console.log('🔥 [REALTIME] 🗑️ RESTAURANT DELETED:', change.doc.id);
                            hasChanges = true;
                        }
                    });
                    
                    if (hasChanges) {
                        console.log('🔥 [REALTIME] Refreshing DataTable...');
                        // Refresh DataTable
                        if ($.fn.DataTable.isDataTable('#storeTable')) {
                            $('#storeTable').DataTable().ajax.reload(null, false); // false = don't reset pagination
                            console.log('✅ [REALTIME] DataTable refreshed successfully');
                        }
                        
                        // Update statistics
                        updateStatisticsRealtime();
                    }
                    
                    console.log('🔥 [REALTIME] Total documents:', querySnapshot.size);
                    console.log('🔥 [REALTIME] ========================================');
                }, function(error) {
                    console.error('❌ [REALTIME] Error in vendors listener:', error);
                    console.error('❌ [REALTIME] Error code:', error.code);
                    console.error('❌ [REALTIME] Error message:', error.message);
                    
                    if (error.code === 'failed-precondition') {
                        console.warn('⚠️ [REALTIME] Index missing, using fallback listener...');
                        // Fallback: listener without orderBy
                        if (vendorsListener) {
                            vendorsListener();
                        }
                        vendorsListener = database.collection('vendors')
                            .onSnapshot(function(querySnapshot) {
                                console.log('🔥 [REALTIME] Fallback listener triggered');
                                if ($.fn.DataTable.isDataTable('#storeTable')) {
                                    $('#storeTable').DataTable().ajax.reload(null, false);
                                }
                                updateStatisticsRealtime();
                            }, function(err) {
                                console.error('❌ [REALTIME] Fallback listener error:', err);
                            });
                    }
                });
            
            console.log('✅ [REALTIME] Vendors listener set up successfully');
            
            // 2. Real-time Listener للـ zones collection
            console.log('🔥 [REALTIME] Setting up zones collection listener...');
            if (zonesListener) {
                zonesListener();
            }
            
            zonesListener = database.collection('zone')
                .where('publish', '==', true)
                .orderBy('name', 'asc')
                .onSnapshot(function(querySnapshot) {
                    console.log('🔥 [REALTIME] Zones collection updated!');
                    console.log('🔥 [REALTIME] Zones count:', querySnapshot.size);
                    
                    // Clear and repopulate zones dropdown
                    $('.zone_selector').empty().append($("<option></option>").attr("value", "").text("Select Zone"));
                    querySnapshot.docs.forEach(function(doc) {
                        var data = doc.data();
                        $('.zone_selector').append($("<option></option>")
                            .attr("value", data.id)
                            .text(data.name));
                    });
                    
                    // Trigger Select2 update
                    if ($('.zone_selector').hasClass('select2-hidden-accessible')) {
                        $('.zone_selector').trigger('change.select2');
                    }
                }, function(error) {
                    console.warn('⚠️ [REALTIME] Zones listener error (using fallback):', error);
                    // Fallback without orderBy
                    if (zonesListener) {
                        zonesListener();
                    }
                    zonesListener = database.collection('zone')
                        .where('publish', '==', true)
                        .onSnapshot(function(querySnapshot) {
                            $('.zone_selector').empty().append($("<option></option>").attr("value", "").text("Select Zone"));
                            querySnapshot.docs.forEach(function(doc) {
                                var data = doc.data();
                                $('.zone_selector').append($("<option></option>")
                                    .attr("value", data.id)
                                    .text(data.name));
                            });
                            if ($('.zone_selector').hasClass('select2-hidden-accessible')) {
                                $('.zone_selector').trigger('change.select2');
                            }
                        });
                });
            
            console.log('✅ [REALTIME] Zones listener set up successfully');
            
            // 3. Real-time Listener للـ categories collection
            console.log('🔥 [REALTIME] Setting up categories collection listener...');
            if (categoriesListener) {
                categoriesListener();
            }
            
            categoriesListener = database.collection('vendor_categories')
                .where('publish', '==', true)
                .onSnapshot(function(querySnapshot) {
                    console.log('🔥 [REALTIME] Categories collection updated!');
                    console.log('🔥 [REALTIME] Categories count:', querySnapshot.size);
                    
                    // Clear and repopulate categories dropdown
                    $('.cuisine_selector').empty().append($("<option></option>").attr("value", "").text("Select Cuisines"));
                    querySnapshot.docs.forEach(function(doc) {
                        var data = doc.data();
                        $('.cuisine_selector').append($("<option></option>")
                            .attr("value", data.id)
                            .text(data.title));
                    });
                    
                    // Trigger Select2 update
                    if ($('.cuisine_selector').hasClass('select2-hidden-accessible')) {
                        $('.cuisine_selector').trigger('change.select2');
                    }
                }, function(error) {
                    console.warn('⚠️ [REALTIME] Categories listener error:', error);
                });
            
            console.log('✅ [REALTIME] Categories listener set up successfully');
            
            // 4. Real-time Listener للـ subscription_plans collection
            console.log('🔥 [REALTIME] Setting up subscription plans collection listener...');
            if (subscriptionPlansListener) {
                subscriptionPlansListener();
            }
            
            subscriptionPlansListener = database.collection('subscription_plans')
                .where('isEnable', '==', true)
                .orderBy('name', 'asc')
                .onSnapshot(function(querySnapshot) {
                    console.log('🔥 [REALTIME] Subscription plans collection updated!');
                    console.log('🔥 [REALTIME] Plans count:', querySnapshot.size);
                    
                    // Clear and repopulate subscription plans dropdown
                    $('.business_model_selector').empty().append($("<option></option>").attr("value", "").text("Business Model"));
                    querySnapshot.docs.forEach(function(doc) {
                        var data = doc.data();
                        var expiryDay = data.expiryDay;
                        var createdAt = data.createdAt;
                        var id = data.id;
                        var name = data.name;
                        var type = data.type;
                        
                        if (expiryDay && createdAt) {
                            var expiryDate = new Date(createdAt.toDate());
                            expiryDate.setDate(expiryDate.getDate() + parseInt(expiryDay, 10));
                            $('.business_model_selector').append($("<option>").attr("value", id).text(name));
                        }
                    });
                    
                    // Trigger Select2 update
                    if ($('.business_model_selector').hasClass('select2-hidden-accessible')) {
                        $('.business_model_selector').trigger('change.select2');
                    }
                }, function(error) {
                    console.warn('⚠️ [REALTIME] Subscription plans listener error (using fallback):', error);
                    // Fallback without orderBy
                    if (subscriptionPlansListener) {
                        subscriptionPlansListener();
                    }
                    subscriptionPlansListener = database.collection('subscription_plans')
                        .where('isEnable', '==', true)
                        .onSnapshot(function(querySnapshot) {
                            $('.business_model_selector').empty().append($("<option></option>").attr("value", "").text("Business Model"));
                            querySnapshot.docs.forEach(function(doc) {
                                var data = doc.data();
                                var expiryDay = data.expiryDay;
                                var createdAt = data.createdAt;
                                var id = data.id;
                                var name = data.name;
                                var type = data.type;
                                
                                if (expiryDay && createdAt) {
                                    var expiryDate = new Date(createdAt.toDate());
                                    expiryDate.setDate(expiryDate.getDate() + parseInt(expiryDay, 10));
                                    $('.business_model_selector').append($("<option>").attr("value", id).text(name));
                                }
                            });
                            if ($('.business_model_selector').hasClass('select2-hidden-accessible')) {
                                $('.business_model_selector').trigger('change.select2');
                            }
                        });
                });
            
            console.log('✅ [REALTIME] Subscription plans listener set up successfully');
            
            console.log('🔥 [REALTIME] ========================================');
            console.log('🔥 [REALTIME] ✅✅✅ ALL REAL-TIME LISTENERS ACTIVE! ✅✅✅');
            console.log('🔥 [REALTIME] ========================================');
            console.log('🔥 [REALTIME] The page will now update automatically when:');
            console.log('🔥 [REALTIME]   - A restaurant is added/modified/deleted');
            console.log('🔥 [REALTIME]   - A zone is added/modified/deleted');
            console.log('🔥 [REALTIME]   - A category is added/modified/deleted');
            console.log('🔥 [REALTIME]   - A subscription plan is added/modified/deleted');
            console.log('🔥 [REALTIME] ========================================');
        }
        
        // Function to update statistics in real-time
        async function updateStatisticsRealtime() {
            console.log('📊 [REALTIME STATS] Updating statistics in real-time...');
            
            if (!database) {
                console.error('❌ [REALTIME STATS] Database not available');
                return;
            }
            
            try {
                // Get all vendors
                var vendorsSnapshot = await database.collection('vendors').get();
                var totalRecords = vendorsSnapshot.size;
                
                var active_rest = 0;
                var inactive_rest = 0;
                var new_joined_rest = 0;
                const today = new Date().setHours(0, 0, 0, 0);
                
                // Process each vendor to get active status
                await Promise.all(vendorsSnapshot.docs.map(async function(doc) {
                    var childData = doc.data();
                    childData.id = doc.id;
                    
                    var isActive = false;
                    if (childData.author) {
                        isActive = await vendorStatus(childData.author);
                    }
                    
                    if (isActive) {
                        active_rest += 1;
                    } else {
                        inactive_rest += 1;
                    }
                    
                    if (childData.createdAt && new Date(childData.createdAt.seconds * 1000).setHours(0, 0, 0, 0) === today) {
                        new_joined_rest += 1;
                    }
                }));
                
                // Update UI
                $('.rest_count').text(totalRecords);
                $('.rest_active_count').text(active_rest);
                $('.rest_inactive_count').text(inactive_rest);
                $('.new_joined_rest').text(new_joined_rest);
                
                console.log('✅ [REALTIME STATS] Statistics updated:');
                console.log('✅ [REALTIME STATS] Total:', totalRecords);
                console.log('✅ [REALTIME STATS] Active:', active_rest);
                console.log('✅ [REALTIME STATS] Inactive:', inactive_rest);
                console.log('✅ [REALTIME STATS] New Today:', new_joined_rest);
            } catch (error) {
                console.error('❌ [REALTIME STATS] Error updating statistics:', error);
            }
        }
        
        // Cleanup listeners when page unloads
        $(window).on('beforeunload', function() {
            console.log('🧹 [REALTIME] Cleaning up listeners...');
            if (vendorsListener) {
                vendorsListener();
                vendorsListener = null;
            }
            if (zonesListener) {
                zonesListener();
                zonesListener = null;
            }
            if (categoriesListener) {
                categoriesListener();
                categoriesListener = null;
            }
            if (subscriptionPlansListener) {
                subscriptionPlansListener();
                subscriptionPlansListener = null;
            }
            console.log('✅ [REALTIME] Listeners cleaned up');
        });
        
        async function subscriptionPlanVendorIds(businessModelValue) {
            console.log('🔍 [SUBSCRIPTION] subscriptionPlanVendorIds() called with:', businessModelValue);
            if (!database) {
                console.error('❌ [SUBSCRIPTION] Database not available in subscriptionPlanVendorIds');
                return [];
            }
            var vendorIds = []
            try {
                console.log('🔍 [SUBSCRIPTION] Querying users collection...');
                console.log('🔍 [SUBSCRIPTION] Collection: users');
                console.log('🔍 [SUBSCRIPTION] Filter: subscriptionPlanId ==', businessModelValue);
                const querySnapshot = await database.collection('users').where('subscriptionPlanId', '==', businessModelValue).get();
                console.log('✅ [SUBSCRIPTION] Query successful!');
                console.log('✅ [SUBSCRIPTION] Documents found:', querySnapshot.docs.length);
                console.log('✅ [SUBSCRIPTION] Query metadata:');
                console.log('✅ [SUBSCRIPTION] From Cache:', querySnapshot.metadata.fromCache);
                console.log('✅ [SUBSCRIPTION] Has Pending Writes:', querySnapshot.metadata.hasPendingWrites);
                
                vendorIds = querySnapshot.docs.map(doc => doc.data().vendorID).filter(vendorID => vendorID !== undefined && vendorID !== null && vendorID !== '');
                console.log('✅ [SUBSCRIPTION] Vendor IDs extracted:', vendorIds.length, vendorIds);
            } catch (error) {
                console.error('❌ [SUBSCRIPTION] Error fetching users from Firestore!');
                console.error('❌ [SUBSCRIPTION] Error code:', error.code);
                console.error('❌ [SUBSCRIPTION] Error message:', error.message);
                console.error('❌ [SUBSCRIPTION] Error stack:', error.stack);
                console.error('❌ [SUBSCRIPTION] Error Code:', error.code || 'N/A');
                console.error('❌ [SUBSCRIPTION] Error Message:', error.message || 'Unknown error');
                
                if (error.code === 'permission-denied') {
                    console.error('🚫 [SUBSCRIPTION] PERMISSION DENIED!');
                    console.error('🚫 [SUBSCRIPTION] Firestore Rules are blocking access to users collection');
                    console.error('🚫 [SUBSCRIPTION] Please check Firestore Rules in Firebase Console');
                    console.error('🚫 [SUBSCRIPTION] Collection path: /users');
                    console.error('🚫 [SUBSCRIPTION] Query: where subscriptionPlanId ==', businessModelValue);
                } else if (error.code === 'unavailable') {
                    console.error('🚫 [SUBSCRIPTION] SERVICE UNAVAILABLE!');
                    console.error('🚫 [SUBSCRIPTION] Firestore service is not available');
                } else if (error.code === 'failed-precondition') {
                    console.error('🚫 [SUBSCRIPTION] FAILED PRECONDITION!');
                    console.error('🚫 [SUBSCRIPTION] Index may be missing for users collection');
                    console.error('🚫 [SUBSCRIPTION] Required index: users/subscriptionPlanId');
                }
            }
            console.log('📤 [SUBSCRIPTION] Returning', vendorIds.length, 'vendor IDs');
            return vendorIds;
        }
        
        function loadDropdownsData() {
            console.log('📋 [DROPDOWNS] loadDropdownsData() called');
            if (!database) {
                console.error('❌ [DROPDOWNS] Database not available in loadDropdownsData');
                return;
            }
            
            console.log('✅ [DROPDOWNS] Database is available');
            var userData = [];
            var vendorData = [];
            var vendorProducts = [];
            
            // Load zones
            console.log('🌍 [DROPDOWNS] Loading zones from Firestore...');
            console.log('🌍 [DROPDOWNS] Collection: zone');
            console.log('🌍 [DROPDOWNS] Filters: publish == true, orderBy: name asc');
            database.collection('zone').where('publish', '==', true).orderBy('name', 'asc').get().then(async function(snapshots) {
                console.log('✅ [DROPDOWNS] Zones query successful!');
                console.log('✅ [DROPDOWNS] Zones found:', snapshots.docs.length);
                console.log('✅ [DROPDOWNS] Query metadata:');
                console.log('✅ [DROPDOWNS] From Cache:', snapshots.metadata.fromCache);
                console.log('✅ [DROPDOWNS] Has Pending Writes:', snapshots.metadata.hasPendingWrites);
                snapshots.docs.forEach((listval) => {
                    var data = listval.data();
                    $('.zone_selector').append($("<option></option>")
                        .attr("value", data.id)
                        .text(data.name));
                });
                console.log('✅ [DROPDOWNS] Zones loaded into dropdown');
            }).catch(function(error) {
                console.error('❌ [DROPDOWNS] Error loading zones (index may be needed)!');
                console.error('❌ [DROPDOWNS] Error code:', error.code);
                console.error('❌ [DROPDOWNS] Error message:', error.message);
                console.error('❌ [DROPDOWNS] Error Code:', error.code || 'N/A');
                console.error('❌ [DROPDOWNS] Error Message:', error.message || 'Unknown error');
                
                if (error.code === 'permission-denied') {
                    console.error('🚫 [DROPDOWNS] PERMISSION DENIED for zones!');
                    console.error('🚫 [DROPDOWNS] Collection path: /zone');
                } else if (error.code === 'failed-precondition') {
                    console.error('🚫 [DROPDOWNS] FAILED PRECONDITION - Index missing for zones!');
                    console.error('🚫 [DROPDOWNS] Required index: zone/publish+name');
                }
                
                // Fallback without orderBy
                console.log('🔄 [DROPDOWNS] Trying fallback query for zones (without orderBy)...');
                database.collection('zone').where('publish', '==', true).get().then(async function(snapshots) {
                    console.log('✅ [DROPDOWNS] Zones fallback query successful!');
                    console.log('✅ [DROPDOWNS] Zones found:', snapshots.docs.length);
                    snapshots.docs.forEach((listval) => {
                        var data = listval.data();
                        $('.zone_selector').append($("<option></option>")
                            .attr("value", data.id)
                            .text(data.name));
                    });
                    console.log('✅ [DROPDOWNS] Zones loaded into dropdown (fallback)');
                }).catch(function(err) {
                    console.error('❌ [DROPDOWNS] Error loading zones (fallback):', err);
                    console.error('❌ [DROPDOWNS] Error code:', err.code);
                    console.error('❌ [DROPDOWNS] Error message:', err.message);
                });
            });
            
            // Load categories
            console.log('🍽️ [DROPDOWNS] Loading categories from Firestore...');
            console.log('🍽️ [DROPDOWNS] Collection: vendor_categories');
            console.log('🍽️ [DROPDOWNS] Filter: publish == true');
            database.collection('vendor_categories').where('publish', '==', true).get().then(async function(snapshots) {
                console.log('✅ [DROPDOWNS] Categories query successful!');
                console.log('✅ [DROPDOWNS] Categories found:', snapshots.docs.length);
                console.log('✅ [DROPDOWNS] Query metadata:');
                console.log('✅ [DROPDOWNS] From Cache:', snapshots.metadata.fromCache);
                console.log('✅ [DROPDOWNS] Has Pending Writes:', snapshots.metadata.hasPendingWrites);
                snapshots.docs.forEach((listval) => {
                    var data = listval.data();
                    $('.cuisine_selector').append($("<option></option>")
                        .attr("value", data.id)
                        .text(data.title));
                });
                console.log('✅ [DROPDOWNS] Categories loaded into dropdown');
            }).catch(function(error) {
                console.error('❌ [DROPDOWNS] Error loading categories!');
                console.error('❌ [DROPDOWNS] Error code:', error.code);
                console.error('❌ [DROPDOWNS] Error message:', error.message);
                console.error('❌ [DROPDOWNS] Error Code:', error.code || 'N/A');
                console.error('❌ [DROPDOWNS] Error Message:', error.message || 'Unknown error');
                
                if (error.code === 'permission-denied') {
                    console.error('🚫 [DROPDOWNS] PERMISSION DENIED for categories!');
                    console.error('🚫 [DROPDOWNS] Collection path: /vendor_categories');
                }
            });
            
            // Load subscription plans
            console.log('💳 [DROPDOWNS] Loading subscription plans from Firestore...');
            console.log('💳 [DROPDOWNS] Collection: subscription_plans');
            console.log('💳 [DROPDOWNS] Filters: isEnable == true, orderBy: name asc');
            database.collection('subscription_plans').where('isEnable', '==', true).orderBy('name', 'asc').get().then(snapshots => {
                console.log('✅ [DROPDOWNS] Subscription plans query successful!');
                console.log('✅ [DROPDOWNS] Plans found:', snapshots.docs.length);
                console.log('✅ [DROPDOWNS] Query metadata:');
                console.log('✅ [DROPDOWNS] From Cache:', snapshots.metadata.fromCache);
                console.log('✅ [DROPDOWNS] Has Pending Writes:', snapshots.metadata.hasPendingWrites);
                snapshots.docs.forEach(doc => {
                    const {
                        expiryDay,
                        createdAt,
                        id,
                        name,
                        type
                    } = doc.data();
                    if (expiryDay && createdAt) {
                        const expiryDate = new Date(createdAt.toDate());
                        expiryDate.setDate(expiryDate.getDate() + parseInt(expiryDay, 10));
                        if (type !== "free" && expiryDate > new Date()) {
                            $('.business_model_selector').append($("<option>").attr("value", id).text(name));
                        } else {
                            $('.business_model_selector').append($("<option>").attr("value", id).text(name));
                        }
                    }
                });
                console.log('✅ [DROPDOWNS] Subscription plans loaded into dropdown');
            }).catch(function(error) {
                console.error('❌ [DROPDOWNS] Error loading subscription plans (index may be needed)!');
                console.error('❌ [DROPDOWNS] Error code:', error.code);
                console.error('❌ [DROPDOWNS] Error message:', error.message);
                console.error('❌ [DROPDOWNS] Error Code:', error.code || 'N/A');
                console.error('❌ [DROPDOWNS] Error Message:', error.message || 'Unknown error');
                
                if (error.code === 'permission-denied') {
                    console.error('🚫 [DROPDOWNS] PERMISSION DENIED for subscription plans!');
                    console.error('🚫 [DROPDOWNS] Collection path: /subscription_plans');
                } else if (error.code === 'failed-precondition') {
                    console.error('🚫 [DROPDOWNS] FAILED PRECONDITION - Index missing for subscription plans!');
                    console.error('🚫 [DROPDOWNS] Required index: subscription_plans/isEnable+name');
                }
                
                // Fallback without orderBy
                console.log('🔄 [DROPDOWNS] Trying fallback query for subscription plans (without orderBy)...');
                database.collection('subscription_plans').where('isEnable', '==', true).get().then(snapshots => {
                    console.log('✅ [DROPDOWNS] Subscription plans fallback query successful!');
                    console.log('✅ [DROPDOWNS] Plans found:', snapshots.docs.length);
                    snapshots.docs.forEach(doc => {
                        const {
                            expiryDay,
                            createdAt,
                            id,
                            name,
                            type
                        } = doc.data();
                        if (expiryDay && createdAt) {
                            const expiryDate = new Date(createdAt.toDate());
                            expiryDate.setDate(expiryDate.getDate() + parseInt(expiryDay, 10));
                            if (type !== "free" && expiryDate > new Date()) {
                                $('.business_model_selector').append($("<option>").attr("value", id).text(name));
                            } else {
                                $('.business_model_selector').append($("<option>").attr("value", id).text(name));
                            }
                        }
                    });
                    console.log('✅ [DROPDOWNS] Subscription plans loaded into dropdown (fallback)');
                }).catch(function(err) {
                    console.error('❌ [DROPDOWNS] Error loading subscription plans (fallback):', err);
                    console.error('❌ [DROPDOWNS] Error code:', err.code);
                    console.error('❌ [DROPDOWNS] Error message:', err.message);
                });
            });
            
            // Initialize Select2
            $('.zone_selector').select2({
                placeholder: "{{ trans('lang.select_zone') }}",
                minimumResultsForSearch: Infinity,
                allowClear: true
            });
            $('.restaurant_type_selector').select2({
                placeholder: "{{ trans('lang.restaurant_type') }}",
                minimumResultsForSearch: Infinity,
                allowClear: true
            });
            $('.business_model_selector').select2({
                placeholder: "{{ trans('lang.business_model') }}",
                minimumResultsForSearch: Infinity,
                allowClear: true
            });
            $('.cuisine_selector').select2({
                placeholder: "{{ trans('lang.select_cuisines') }}",
                minimumResultsForSearch: Infinity,
                allowClear: true
            });
            $('select').on("select2:unselecting", function(e) {
                var self = $(this);
                setTimeout(function() {
                    self.select2('close');
                }, 0);
            });
        }
        
        function initializeDataTable() {
            console.log('📊 [DATATABLE] initializeDataTable() called');
            if (!database) {
                console.error('❌ [DATATABLE] Database not available in initializeDataTable');
                console.error('❌ [DATATABLE] database variable:', database);
                return;
            }
            console.log('✅ [DATATABLE] Database is available');
            
            var append_list = '';
            var placeholderImage = '';
            var user_permissions = '<?php echo @session('user_permissions'); ?>';
            user_permissions = Object.values(JSON.parse(user_permissions));
            var checkDeletePermission = false;
            if ($.inArray('restaurant.delete', user_permissions) >= 0) {
                checkDeletePermission = true;
            }
            
            // Load placeholder image
            var placeholder = database.collection('settings').doc('placeHolderImage');
            placeholder.get().then(async function(snapshotsimage) {
                if (snapshotsimage.exists) {
                    var placeholderImageData = snapshotsimage.data();
                    placeholderImage = placeholderImageData.image;
                }
            }).catch(function(error) {
                console.warn('⚠️ Error loading placeholder image:', error);
            });
            
            jQuery("#data-table_processing").show();
            $(document).on('click', '.dt-button-collection .dt-button', function() {
                $('.dt-button-collection').hide();
                $('.dt-button-background').hide();
            });
            $(document).on('click', function(event) {
                if (!$(event.target).closest('.dt-button-collection, .dt-buttons').length) {
                    $('.dt-button-collection').hide();
                    $('.dt-button-background').hide();
                }
            });
            
            var fieldConfig = {
                columns: [{
                        key: 'id',
                        header: "{{ trans('lang.id') }}"
                    },
                    {
                        key: 'title',
                        header: "{{ trans('lang.restaurant') }}"
                    },
                    {
                        key: 'authorName',
                        header: "{{ trans('lang.owner_name') }}"
                    },
                    {
                        key: 'phonenumber',
                        header: "{{ trans('lang.phone') }}"
                    },
                    {
                        key: 'createdAt',
                        header: "{{ trans('lang.created_at') }}"
                    },
                    {
                        key: 'location',
                        header: "{{ trans('lang.location') }}"
                    },
                ],
                fileName: "{{ trans('lang.restaurant_table') }}",
            };
            console.log('📊 [DATATABLE] Creating DataTable instance...');
            console.log('📊 [DATATABLE] Table element exists:', $('#storeTable').length > 0);
            console.log('📊 [DATATABLE] jQuery DataTable plugin loaded:', typeof $.fn.DataTable !== 'undefined');
            
            const table = $('#storeTable').DataTable({
                pageLength: 10,
                processing: false,
                serverSide: true,
                responsive: true,
                ajax: function(data, callback, settings) {
                    console.log('🔄 [AJAX] ========================================');
                    console.log('🔄 [AJAX] DataTable AJAX Request Started');
                    console.log('🔄 [AJAX] ========================================');
                    
                    const start = data.start;
                    const length = data.length;
                    const searchValue = data.search.value.toLowerCase();
                    const orderColumnIndex = data.order[0].column;
                    const orderDirection = data.order[0].dir;
                    const orderableColumns = (checkDeletePermission) ? ['', 'title', 'authorName', 'createdAt', '', ''] : ['title', 'authorName', 'createdAt', '', ''];
                    const orderByField = orderableColumns[orderColumnIndex];
                    
                    console.log('📊 [AJAX] Request Parameters:');
                    console.log('📊 [AJAX] Start:', start);
                    console.log('📊 [AJAX] Length:', length);
                    console.log('📊 [AJAX] Search Value:', searchValue);
                    console.log('📊 [AJAX] Order Column Index:', orderColumnIndex);
                    console.log('📊 [AJAX] Order Direction:', orderDirection);
                    console.log('📊 [AJAX] Order By Field:', orderByField);
                    
                    // Check database and refData
                    console.log('🔍 [AJAX] Checking database availability...');
                    console.log('🔍 [AJAX] database exists:', !!database);
                    console.log('🔍 [AJAX] refData exists:', !!refData);
                    console.log('🔍 [AJAX] refData type:', typeof refData);
                    
                    if (!database) {
                        console.error('❌ [AJAX] Database is not available!');
                        console.error('❌ [AJAX] Cannot proceed with query');
                        $('#data-table_processing').hide();
                        callback({
                            draw: data.draw,
                            recordsTotal: 0,
                            recordsFiltered: 0,
                            filteredData: [],
                            data: []
                        });
                        return;
                    }
                    
                    if (!refData) {
                        console.error('❌ [AJAX] refData is not initialized!');
                        console.error('❌ [AJAX] Initializing refData to vendors collection...');
                        refData = database.collection('vendors');
                        console.log('✅ [AJAX] refData initialized');
                    }
                    
                    console.log('🔍 [AJAX] refData collection path:', refData._delegate ? refData._delegate._query._path.segments : 'unknown');
                    
                    if (searchValue.length >= 3 || searchValue.length === 0) {
                        $('#data-table_processing').show();
                    }
                    
                    console.log('📤 [AJAX] Starting Firestore Query...');
                    console.log('📤 [AJAX] Query: vendors collection');
                    console.log('📤 [AJAX] OrderBy: createdAt DESC');
                    console.log('📤 [AJAX] Collection reference:', refData);
                    
                    // Try with orderBy, fallback to without if index doesn't exist
                    var queryPromise = refData.orderBy('createdAt', 'desc').get().catch(function(error) {
                        console.error('❌ [AJAX] Query with orderBy failed!');
                        console.error('❌ [AJAX] Error code:', error.code);
                        console.error('❌ [AJAX] Error message:', error.message);
                        console.error('❌ [AJAX] Error Code:', error.code || 'N/A');
                        console.error('❌ [AJAX] Error Message:', error.message || 'Unknown error');
                        
                        if (error.code === 'failed-precondition') {
                            console.warn('⚠️ [AJAX] Index required. Using query without orderBy.');
                            console.warn('⚠️ [AJAX] Index needed: vendors/createdAt DESC + id ASC');
                            console.warn('⚠️ [AJAX] Create index or wait for it to be enabled');
                            // Fallback: get without orderBy and sort in memory
                            console.log('🔄 [AJAX] Trying fallback query (without orderBy)...');
                            return refData.get();
                        }
                        throw error;
                    });
                    
                    console.log('⏳ [AJAX] Waiting for query result...');
                    
                    queryPromise.then(async function(querySnapshot) {
                        console.log('✅ [AJAX] ========================================');
                        console.log('✅ [AJAX] Query Completed Successfully!');
                        console.log('✅ [AJAX] ========================================');
                        console.log('📊 [AJAX] Query Result:');
                        console.log('📊 [AJAX] Empty:', querySnapshot.empty);
                        console.log('📊 [AJAX] Size:', querySnapshot.size);
                        console.log('📊 [AJAX] Docs Count:', querySnapshot.docs.length);
                        console.log('📊 [AJAX] From Cache:', querySnapshot.metadata.fromCache);
                        console.log('📊 [AJAX] Has Pending Writes:', querySnapshot.metadata.hasPendingWrites);
                        
                        if (querySnapshot.empty) {
                            console.error('❌ [AJAX] ========================================');
                            console.error('❌ [AJAX] QUERY RESULT: EMPTY!');
                            console.error('❌ [AJAX] ========================================');
                            console.error('❌ [AJAX] No documents found in vendors collection!');
                            console.error('❌ [AJAX] Possible reasons:');
                            console.error('   1. No data in Firestore vendors collection');
                            console.error('   2. Firestore Rules blocking access');
                            console.error('   3. Collection name mismatch');
                            console.error('❌ [AJAX] Solution:');
                            console.error('   1. Check Firebase Console → Firestore → Data → vendors');
                            console.error('   2. Import data: node import-firestore.js');
                            console.error('   3. Check Firestore Rules');
                            
                            $('.rest_count').text(0);
                            $('.rest_active_count').text(0);
                            $('.rest_inactive_count').text(0);
                            $('.new_joined_rest').text(0);
                            console.error("❌ [AJAX] No data found in Firestore.");
                            $('#data-table_processing').hide();
                            callback({
                                draw: data.draw,
                                recordsTotal: 0,
                                recordsFiltered: 0,
                                filteredData: [],
                                data: []
                            });
                            return;
                        }
                        
                        console.log('✅ [AJAX] Found', querySnapshot.docs.length, 'documents');
                        console.log('📋 [AJAX] ========================================');
                        console.log('📋 [AJAX] 📊 إحصائيات البيانات الكاملة');
                        console.log('📋 [AJAX] ========================================');
                        console.log('📋 [AJAX] العدد الكلي للمطاعم في Firestore:', querySnapshot.docs.length);
                        console.log('📋 [AJAX] Processing documents...');
                        let records = [];
                        let filteredRecords = [];
                        let docCount = 0;
                        let allVendorsData = [];
                        
                        querySnapshot.forEach(function(doc) {
                            docCount++;
                            let childData = doc.data();
                            childData.id = doc.id;
                            
                            // حفظ جميع البيانات للمقارنة
                            allVendorsData.push({
                                id: doc.id,
                                title: childData.title || 'NO TITLE',
                                author: childData.author || 'NO AUTHOR',
                                authorName: childData.authorName || 'NO AUTHOR NAME',
                                phonenumber: childData.phonenumber || 'NO PHONE',
                                photo: childData.photo || 'NO PHOTO',
                                createdAt: childData.createdAt ? 'HAS DATE' : 'NO DATE',
                                isActive: childData.isActive !== undefined ? childData.isActive : 'UNDEFINED'
                            });
                            
                            // عرض أول 5 مطاعم بالتفصيل
                            if (docCount <= 5) {
                                console.log('📄 [AJAX] ========================================');
                                console.log('📄 [AJAX] مطعم رقم', docCount, 'من', querySnapshot.docs.length);
                                console.log('📄 [AJAX] ========================================');
                                console.log('📄 [AJAX] ID:', doc.id);
                                console.log('📄 [AJAX] العنوان:', childData.title || 'NO TITLE');
                                console.log('📄 [AJAX] المؤلف ID:', childData.author || 'NO AUTHOR');
                                console.log('📄 [AJAX] اسم المؤلف:', childData.authorName || 'NO AUTHOR NAME');
                                console.log('📄 [AJAX] الهاتف:', childData.phonenumber || 'NO PHONE');
                                console.log('📄 [AJAX] الصورة:', childData.photo ? 'HAS PHOTO' : 'NO PHOTO');
                                console.log('📄 [AJAX] تاريخ الإنشاء:', childData.createdAt ? 'HAS DATE' : 'NO DATE');
                                console.log('📄 [AJAX] نشط:', childData.isActive !== undefined ? childData.isActive : 'UNDEFINED');
                                console.log('📄 [AJAX] ========================================');
                            }
                            childData.phone = (childData.phonenumber != '' && childData.phonenumber != null && childData.phonenumber.slice(0, 1) == '+') ? childData.phonenumber.slice(1) : childData.phonenumber;
                            childData.phonenumber = shortEditNumber(childData.phonenumber);
                            
                            if (searchValue) {
                                var date = '';
                                var time = '';
                                if (childData.hasOwnProperty("createdAt")) {
                                    try {
                                        date = childData.createdAt.toDate().toDateString();
                                        time = childData.createdAt.toDate().toLocaleTimeString('en-US');
                                    } catch (err) {}
                                }
                                var createdAt = date + ' ' + time;
                                if (
                                    (childData.title && childData.title.toString().toLowerCase().includes(searchValue)) ||
                                    (createdAt && createdAt.toString().toLowerCase().indexOf(searchValue) > -1) ||
                                    (childData.email && childData.email.toString().includes(searchValue)) ||
                                    (childData.phoneNumber && childData.phoneNumber.toString().includes(searchValue))
                                ) {
                                    filteredRecords.push(childData);
                                }
                            } else {
                                filteredRecords.push(childData);
                            }
                        });
                        // Sort filtered records - handle createdAt properly
                        filteredRecords.sort((a, b) => {
                            let aValue = a[orderByField] ? a[orderByField].toString().toLowerCase() : '';
                            let bValue = b[orderByField] ? b[orderByField].toString().toLowerCase() : '';
                            if (orderByField === 'createdAt') {
                                try {
                                    // Handle Firestore Timestamp
                                    if (a[orderByField] && typeof a[orderByField].toDate === 'function') {
                                        aValue = a[orderByField].toDate().getTime();
                                    } else if (a[orderByField] && a[orderByField].seconds) {
                                        aValue = a[orderByField].seconds * 1000;
                                    } else {
                                        aValue = 0;
                                    }
                                    if (b[orderByField] && typeof b[orderByField].toDate === 'function') {
                                        bValue = b[orderByField].toDate().getTime();
                                    } else if (b[orderByField] && b[orderByField].seconds) {
                                        bValue = b[orderByField].seconds * 1000;
                                    } else {
                                        bValue = 0;
                                    }
                                } catch (err) {
                                    console.warn('⚠️ [DATATABLE AJAX] Error sorting by createdAt:', err);
                                    aValue = 0;
                                    bValue = 0;
                                }
                            }
                            if (orderDirection === 'asc') {
                                return (aValue > bValue) ? 1 : -1;
                            } else {
                                return (aValue < bValue) ? 1 : -1;
                            }
                        });
                        const totalRecords = filteredRecords.length;
                        console.log('📊 [AJAX] ========================================');
                        console.log('📊 [AJAX] 📊 إحصائيات بعد التصفية');
                        console.log('📊 [AJAX] ========================================');
                        console.log('📊 [AJAX] العدد الكلي من Firestore:', querySnapshot.docs.length);
                        console.log('📊 [AJAX] العدد بعد التصفية (Filtered):', totalRecords);
                        console.log('📊 [AJAX] Processing statistics...');
                        
                        let active_rest = 0;
                        let inactive_rest = 0;
                        let new_joined_rest = 0;
                        const today = new Date().setHours(0, 0, 0, 0);
                        
                        await Promise.all(filteredRecords.map(async (childData) => {
                            var isActive = false;
                            if (childData.author) {
                                const user_id = childData.author;
                                isActive = await vendorStatus(user_id);
                            }
                            if (isActive) {
                                active_rest += 1;
                            } else {
                                inactive_rest += 1;
                            }
                            if (childData.createdAt && new Date(childData.createdAt.seconds * 1000).setHours(0, 0, 0, 0) === today) {
                                new_joined_rest += 1;
                            }
                        }));
                        console.log('📊 [AJAX] ========================================');
                        console.log('📊 [AJAX] 📊 الإحصائيات النهائية');
                        console.log('📊 [AJAX] ========================================');
                        console.log('📊 [AJAX] العدد الكلي:', totalRecords);
                        console.log('📊 [AJAX] المطاعم النشطة:', active_rest);
                        console.log('📊 [AJAX] المطاعم غير النشطة:', inactive_rest);
                        console.log('📊 [AJAX] المطاعم الجديدة اليوم:', new_joined_rest);
                        console.log('📊 [AJAX] ========================================');
                        
                        // عرض جميع البيانات
                        console.log('📋 [AJAX] ========================================');
                        console.log('📋 [AJAX] 📋 جميع بيانات المطاعم (للمقارنة)');
                        console.log('📋 [AJAX] ========================================');
                        console.log('📋 [AJAX] عدد المطاعم:', allVendorsData.length);
                        allVendorsData.forEach(function(vendor, index) {
                            var vendorTitle = (vendor.title && typeof vendor.title === 'string') ? vendor.title.substring(0, 50) : 'NO TITLE';
                            var vendorAuthor = vendor.author || 'NO AUTHOR';
                            var vendorAuthorName = (vendor.authorName && typeof vendor.authorName === 'string') ? vendor.authorName.substring(0, 50) : 'NO AUTHOR NAME';
                            var vendorPhone = vendor.phonenumber || 'NO PHONE';
                            
                            console.log('📋 [AJAX] مطعم', (index + 1), ':');
                            console.log('📋 [AJAX] ID:', vendor.id || 'NO ID');
                            console.log('📋 [AJAX] Title:', vendorTitle);
                            console.log('📋 [AJAX] Author:', vendorAuthor);
                            console.log('📋 [AJAX] Author Name:', vendorAuthorName);
                            console.log('📋 [AJAX] Phone:', vendorPhone);
                        });
                        console.log('📋 [AJAX] ========================================');
                        
                        $('.rest_count').text(totalRecords);
                        $('.rest_active_count').text(active_rest);
                        $('.rest_inactive_count').text(inactive_rest);
                        $('.new_joined_rest').text(new_joined_rest);
                        
                        const paginatedRecords = filteredRecords.slice(start, start + length);
                        console.log('📄 [AJAX] Pagination:');
                        console.log('📄 [AJAX] Start:', start);
                        console.log('📄 [AJAX] Length:', length);
                        console.log('📄 [AJAX] Paginated:', paginatedRecords.length);
                        console.log('📄 [AJAX] Total:', filteredRecords.length);
                        
                        console.log('🔄 [AJAX] Building HTML for', paginatedRecords.length, 'records...');
                        let builtCount = 0;
                        let failedCount = 0;
                        
                        await Promise.all(paginatedRecords.map(async (childData) => {
                            var getData = await buildHTML(childData);
                            if (getData && getData.length > 0) {
                                records.push(getData);
                                builtCount++;
                            } else {
                                failedCount++;
                                console.warn('⚠️ [AJAX] buildHTML returned empty for:', childData.id || 'unknown');
                                console.warn('⚠️ [AJAX] Document ID:', childData.id || 'NO ID');
                                console.warn('⚠️ [AJAX] Document Title:', childData.title || 'NO TITLE');
                                console.warn('⚠️ [AJAX] Document Author:', childData.author || 'NO AUTHOR');
                            }
                        }));
                        
                        console.log('✅ [AJAX] ========================================');
                        console.log('✅ [AJAX] 📊 إحصائيات بناء HTML');
                        console.log('✅ [AJAX] ========================================');
                        console.log('✅ [AJAX] عدد الصفوف المبنية بنجاح:', builtCount);
                        console.log('✅ [AJAX] عدد الصفوف الفاشلة:', failedCount);
                        console.log('✅ [AJAX] العدد الكلي للصفوف:', records.length);
                        console.log('✅ [AJAX] ========================================');
                        
                        sendLogToServer('info', '✅ Built table rows', { 
                            recordsBuilt: records.length,
                            totalRecords: totalRecords
                        });
                        
                        console.log('✅ [AJAX] ========================================');
                        console.log('✅ [AJAX] SUCCESS - Returning Data to DataTable');
                        console.log('✅ [AJAX] ========================================');
                        console.log('📊 [AJAX] ========================================');
                        console.log('📊 [AJAX] 📊 النتائج النهائية');
                        console.log('📊 [AJAX] ========================================');
                        console.log('📊 [AJAX] الصفوف المبنية:', records.length);
                        console.log('📊 [AJAX] العدد الكلي:', totalRecords);
                        console.log('📊 [AJAX] بعد التصفية:', filteredRecords.length);
                        console.log('📊 [AJAX] في الصفحة الحالية:', paginatedRecords.length);
                        console.log('📊 [AJAX] ========================================');
                        
                        if (records.length > 0) {
                            console.log('✅ [AJAX] Sample record (first row) exists:', !!records[0]);
                            console.log('✅ [AJAX] First record length:', records[0] ? records[0].length : 0);
                        } else {
                            console.warn('⚠️ [AJAX] No records to display!');
                        }
                        
                        $('#data-table_processing').hide();
                        callback({
                            draw: data.draw,
                            recordsTotal: totalRecords,
                            recordsFiltered: totalRecords,
                            filteredData: filteredRecords,
                            data: records
                        });
                        
                        console.log('✅ [AJAX] ========================================');
                        console.log('✅ [AJAX] ✅ تم إرسال البيانات إلى DataTable بنجاح!');
                        console.log('✅ [AJAX] ========================================');
                        console.log('✅ [AJAX] عدد الصفوف المرسلة:', records.length);
                        console.log('✅ [AJAX] يجب أن تظهر', records.length, 'مطعم في الجدول');
                        console.log('✅ [AJAX] ========================================');
                    }).catch(function(error) {
                        console.error('❌ [AJAX] ========================================');
                        console.error('❌ [AJAX] QUERY FAILED WITH ERROR!');
                        console.error('❌ [AJAX] ========================================');
                        console.error('❌ [AJAX] Error Code:', error.code || 'N/A');
                        console.error('❌ [AJAX] Error Message:', error.message || 'Unknown error');
                        if (error.stack) {
                            console.error('❌ [AJAX] Error Stack:', error.stack);
                        }
                        console.error('❌ [AJAX] Error Name:', error.name || 'Error');
                        
                        if (error.code === 'permission-denied') {
                            console.error('🚫 [AJAX] ========================================');
                            console.error('🚫 [AJAX] PERMISSION DENIED ERROR!');
                            console.error('🚫 [AJAX] ========================================');
                            console.error('🚫 [AJAX] Firestore Rules are blocking access!');
                            console.error('🚫 [AJAX] Collection: /vendors');
                            console.error('🚫 [AJAX] Solution:');
                            console.error('   1. Go to Firebase Console → Firestore → Rules');
                            console.error('   2. Add Firestore rule:');
                            console.error('      match /vendors/[document] { allow read: if true; }');
                            console.error('   Note: Replace [document] with document wildcard pattern');
                            console.error('   3. Or deploy rules: firebase deploy --only firestore:rules');
                        } else if (error.code === 'unavailable') {
                            console.error('🚫 [AJAX] ========================================');
                            console.error('🚫 [AJAX] SERVICE UNAVAILABLE ERROR!');
                            console.error('🚫 [AJAX] ========================================');
                            console.error('🚫 [AJAX] Firestore service is not available');
                            console.error('🚫 [AJAX] Check:');
                            console.error('   1. Internet connection');
                            console.error('   2. Firebase project status');
                            console.error('   3. Firestore API is enabled');
                        } else if (error.code === 'deadline-exceeded') {
                            console.error('🚫 [AJAX] ========================================');
                            console.error('🚫 [AJAX] DEADLINE EXCEEDED ERROR!');
                            console.error('🚫 [AJAX] ========================================');
                            console.error('🚫 [AJAX] Query took too long to execute');
                            console.error('🚫 [AJAX] Possible causes:');
                            console.error('   1. Network issues');
                            console.error('   2. Very large collection');
                            console.error('   3. Missing index');
                        } else if (error.code === 'failed-precondition') {
                            console.error('🚫 [AJAX] ========================================');
                            console.error('🚫 [AJAX] FAILED PRECONDITION ERROR!');
                            console.error('🚫 [AJAX] ========================================');
                            console.error('🚫 [AJAX] Index is missing or not enabled!');
                            console.error('🚫 [AJAX] Required Index:');
                            console.error('   Collection: vendors');
                            console.error('   Fields: createdAt (DESCENDING) + id (ASCENDING)');
                            console.error('🚫 [AJAX] Solution:');
                            console.error('   1. Go to Firebase Console → Firestore → Indexes');
                            console.error('   2. Create the index manually');
                            console.error('   3. Or deploy: firebase deploy --only firestore:indexes');
                            console.error('   4. Wait 2-5 minutes for index to be enabled');
                        } else {
                            console.error('🚫 [AJAX] ========================================');
                            console.error('🚫 [AJAX] UNKNOWN ERROR!');
                            console.error('🚫 [AJAX] ========================================');
                            console.error('🚫 [AJAX] Error Code:', error.code || 'N/A');
                            console.error('🚫 [AJAX] Error Message:', error.message || 'Unknown error');
                            console.error('🚫 [AJAX] Error Name:', error.name || 'Error');
                        }
                        
                        sendLogToServer('error', '❌ Error fetching data from Firestore', { 
                            error: error.message,
                            code: error.code,
                            name: error.name
                        });
                        
                        // Return empty result on error
                        console.error('❌ [AJAX] Returning empty result due to error');
                        $('#data-table_processing').hide();
                        callback({
                            draw: data.draw,
                            recordsTotal: 0,
                            recordsFiltered: 0,
                            filteredData: [],
                            data: []
                        });
                        console.error('❌ [AJAX] ========================================');
                    } catch (queryError) {
                        console.error('❌ [AJAX] ========================================');
                        console.error('❌ [AJAX] EXCEPTION IN QUERY SETUP!');
                        console.error('❌ [AJAX] ========================================');
                        var errorType = 'Unknown';
                        var errorMessage = 'Unknown error';
                        var errorCode = 'N/A';
                        var errorStack = null;
                        
                        try {
                            if (queryError && queryError.constructor) {
                                errorType = queryError.constructor.name || 'Error';
                            }
                            errorMessage = (queryError && queryError.message) ? queryError.message : 'Unknown error';
                            errorCode = (queryError && queryError.code) ? queryError.code : 'N/A';
                            errorStack = (queryError && queryError.stack) ? queryError.stack : null;
                        } catch (e) {
                            errorType = 'Error';
                            errorMessage = String(queryError || 'Unknown error');
                        }
                        
                        console.error('❌ [AJAX] Exception Type:', errorType);
                        console.error('❌ [AJAX] Exception Message:', errorMessage);
                        console.error('❌ [AJAX] Exception Code:', errorCode);
                        if (errorStack) {
                            console.error('❌ [AJAX] Exception Stack:', errorStack);
                        }
                        
                        if (errorCode === 'permission-denied') {
                            console.error('🚫 [AJAX] PERMISSION DENIED in catch block!');
                            console.error('🚫 [AJAX] Firestore Rules are blocking access');
                            console.error('🚫 [AJAX] Solution: firebase deploy --only firestore:rules');
                        } else if (errorCode === 'failed-precondition') {
                            console.error('🚫 [AJAX] INDEX MISSING in catch block!');
                            console.error('🚫 [AJAX] Required index: vendors/createdAt DESC + id ASC');
                            console.error('🚫 [AJAX] Solution: firebase deploy --only firestore:indexes');
                        }
                        
                        sendLogToServer('error', '❌ Error in query setup', { 
                            error: errorMessage,
                            code: errorCode,
                            type: errorType
                        });
                        $('#data-table_processing').hide();
                        callback({
                            draw: data.draw,
                            recordsTotal: 0,
                            recordsFiltered: 0,
                            filteredData: [],
                            data: []
                        });
                        console.error('❌ [AJAX] ========================================');
                    }
                },
                order: (checkDeletePermission) ? [
                    [4, 'desc']
                ] : [
                    [3, 'desc']
                ],
                columnDefs: [{
                        targets: (checkDeletePermission) ? 4 : 3,
                        type: 'date',
                        render: function(data) {
                            return data;
                        }
                    },
                    {
                        orderable: false,
                        targets: (checkDeletePermission) ? [0, 4, 5] : [3, 4]
                    },
                ],
                "language": {
                    "zeroRecords": "{{ trans('lang.no_record_found') }}",
                    "emptyTable": "{{ trans('lang.no_record_found') }}",
                    "processing": ""
                },
                dom: 'lfrtipB',
                buttons: [{
                    extend: 'collection',
                    text: '<i class="mdi mdi-cloud-download"></i> Export as',
                    className: 'btn btn-info',
                    buttons: [{
                            extend: 'excelHtml5',
                            text: 'Export Excel',
                            action: function(e, dt, button, config) {
                                exportData(dt, 'excel', fieldConfig);
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'Export PDF',
                            action: function(e, dt, button, config) {
                                exportData(dt, 'pdf', fieldConfig);
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            text: 'Export CSV',
                            action: function(e, dt, button, config) {
                                exportData(dt, 'csv', fieldConfig);
                            }
                        }
                    ]
                }],
                initComplete: function() {
                    console.log('✅ [DATATABLE] ========================================');
                    console.log('✅ [DATATABLE] DataTable Initialized Successfully!');
                    console.log('✅ [DATATABLE] ========================================');
                    console.log('✅ [DATATABLE] Table ID: #storeTable');
                    console.log('✅ [DATATABLE] Ready to load data');
                    console.log('✅ [DATATABLE] DataTable instance:', table);
                    console.log('✅ [DATATABLE] AJAX will be called automatically');
                    $('#data-table_processing').hide();
                    $(".dataTables_filter").append($(".dt-buttons").detach());
                    $('.dataTables_filter input').attr('placeholder', 'Search here...').attr('autocomplete', 'new-password').val('');
                    $('.dataTables_filter label').contents().filter(function() {
                        return this.nodeType === 3;
                    }).remove();
                    console.log('✅ [DATATABLE] UI elements configured');
                }
            });
            
            console.log('✅ [DATATABLE] DataTable instance created');
            console.log('✅ [DATATABLE] Table variable exists:', !!table);

            function debounce(func, wait) {
                let timeout;
                const context = this;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }
            $('#search-input').on('input', debounce(function() {
                const searchValue = $(this).val();
                if (searchValue.length >= 3) {
                    $('#data-table_processing').show();
                    table.search(searchValue).draw();
                } else if (searchValue.length === 0) {
                    $('#data-table_processing').show();
                    table.search('').draw();
                }
            }, 300));
        });
        async function buildHTML(val) {
            console.log('🔨 [BUILD HTML] Building HTML for restaurant:', val.id || 'unknown');
            var html = [];
            // Check if id exists
            if (!val || !val.id) {
                console.error('❌ [BUILD HTML] Restaurant data missing id:', val);
                console.error('❌ [BUILD HTML] Cannot build HTML without ID');
                return [];
            }
            
            console.log('✅ [BUILD HTML] Restaurant ID:', val.id);
            console.log('📋 [BUILD HTML] Restaurant data:');
            console.log('📋 [BUILD HTML] ID:', val.id || 'NO ID');
            var safeTitle = (val.title && typeof val.title === 'string') ? val.title.substring(0, 50) : 'NO TITLE';
            var safeAuthor = (val.author && typeof val.author === 'string') ? val.author : 'NO AUTHOR';
            console.log('📋 [BUILD HTML] Title:', safeTitle);
            console.log('📋 [BUILD HTML] Author:', safeAuthor);
            console.log('📋 [BUILD HTML] Has Photo:', !!val.photo);
            console.log('📋 [BUILD HTML] Has Created At:', !!val.createdAt);
            var id = val.id;
            var vendorUserId = val.author;
            
            // Get author name - use existing authorName if available, otherwise fetch from users collection
            if (!val.authorName || val.authorName.trim() === '') {
                if (vendorUserId && vendorUserId.trim() !== '') {
                    try {
                        console.log('👤 [BUILD HTML] Fetching author name from users collection for:', vendorUserId);
                        const userDoc = await database.collection('users').doc(vendorUserId).get();
                        if (userDoc.exists) {
                            const userData = userDoc.data();
                            val.authorName = (userData.firstName || '') + ' ' + (userData.lastName || '');
                            console.log('✅ [BUILD HTML] Fetched author name:', val.authorName);
                        } else {
                            console.warn('⚠️ [BUILD HTML] User document not found:', vendorUserId);
                            val.authorName = val.authorName || 'N/A';
                        }
                    } catch (err) {
                        console.warn('⚠️ [BUILD HTML] Error fetching user data:', err);
                        val.authorName = val.authorName || 'N/A';
                    }
                } else {
                    console.warn('⚠️ [BUILD HTML] No author ID provided, using existing authorName or N/A');
                    val.authorName = val.authorName || 'N/A';
                }
            } else {
                console.log('✅ [BUILD HTML] Using existing authorName from document:', val.authorName);
            }
            var route1 = '{{ route('restaurants.edit', ':id') }}';
            route1 = route1.replace(':id', id);
            var route_view = '{{ route('restaurants.view', ':id') }}';
            route_view = route_view.replace(':id', id);
            if (checkDeletePermission) {
                html.push('<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '" author="' + (val.author || '') + '"><label class="col-3 control-label" for="is_open_' + id + '"></label></td>');
            }
            var restaurantInfo = '';
            if (val.photo != '' && val.photo != null) {
                restaurantInfo += '<img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="" width="100%" style="width:70px;height:70px;" src="' + val.photo + '" alt="image">';
            } else {
                restaurantInfo += '<img alt="" width="100%" style="width:70px;height:70px;" src="' + placeholderImage + '" alt="image">';
            }
            if (val.title && val.title != " " && val.title != "null" && val.title != null && val.title != "") {
                restaurantInfo += '<a href="' + route_view + '">' + val.title + '</a>';
            } else {
                restaurantInfo += 'UNKNOWN';
            }
            html.push(restaurantInfo);
            var ownerInfo = '';
            if (val.authorName) {
                ownerInfo += '<a href="' + route_view + '">' + val.authorName + '</a><br>';
            }
            if (val.hasOwnProperty('phonenumber') && val.phonenumber != null && val.phonenumber != "") {
                ownerInfo += '<a>' + val.phonenumber + '</a>';
            } else {
                ownerInfo += '';
            }
            html.push(ownerInfo);
            var date = '';
            var time = '';
            if (val.hasOwnProperty("createdAt")) {
                try {
                    date = val.createdAt.toDate().toDateString();
                    time = val.createdAt.toDate().toLocaleTimeString('en-US');
                } catch (err) {}
                html.push('<span class="dt-time">' + date + ' ' + time + '</span>');
            } else {
                html.push('');
            }
            var payoutRequests = '{{ route('users.walletstransaction', ':id') }}';
            var walletHistoryText = '{{ trans('lang.wallet_history') }}';
            if (val.author) {
                payoutRequests = payoutRequests.replace(':id', val.author);
                html.push('<a href="' + payoutRequests + '">' + walletHistoryText + '</a>');
            } else {
                html.push('');
            }
            var active = val.isActive;
            var vendorId = val.id;
            if (!vendorId) {
                console.error('❌ Restaurant missing id:', val);
                return [];
            }
            var food_url = '{{ route('restaurants.foods', ':id') }}';
            food_url = food_url.replace(":id", vendorId);
            var vendor_url = '{{ route('restaurants.orders', ':id') }}';
            vendor_url = vendor_url.replace(":id", vendorId);
            var actionHtml = '';
            actionHtml += '<span class="action-btn">';
            actionHtml += '<a href="' + food_url + '"><i class="mdi mdi-food" title="Foods"></i></a>';
            actionHtml += '<a href="' + vendor_url + '"><i class="mdi mdi-view-list" title="Orders"></i></a>';
            actionHtml += '<a href="javascript:void(0)" vendor_id="' + val.id + '" author="' + (val.author || '') + '" name="vendor-clone" title="Copy"><i class="mdi mdi-content-copy"></i></a>';
            actionHtml += '<a href="' + route_view + '"><i class="mdi mdi-eye" title="View"></i></a>';
            var currentStatus = val.approvalStatus || 'waiting';
            var statusIcon = '';
            var statusColor = '#2c9653';
            if (currentStatus === 'approved') {
                statusIcon = 'mdi-check-circle';
                statusColor = '#2c9653';
            } else if (currentStatus === 'rejected') {
                statusIcon = 'mdi-close-circle';
                statusColor = '#dc3545';
            } else {
                statusIcon = 'mdi-clock-outline';
                statusColor = '#ffc107';
            }
            actionHtml += '<div class="dropdown" style="display: inline-block;"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" vendor_id="' + val.id + '" approval_status="' + currentStatus + '" name="vendor-status-dropdown-index" title="Change Status"><i class="mdi ' + statusIcon + '" style="color: ' + statusColor + '; font-size: 18px;"></i></a><ul class="dropdown-menu status-dropdown-menu" role="menu"><li><a href="javascript:void(0)" class="status-option-vendor-index" data-status="waiting" data-vendor-id="' + val.id + '"><i class="mdi mdi-clock-outline" style="color: #ffc107;"></i> Waiting</a></li><li><a href="javascript:void(0)" class="status-option-vendor-index" data-status="rejected" data-vendor-id="' + val.id + '"><i class="mdi mdi-close-circle" style="color: #dc3545;"></i> Rejected</a></li><li><a href="javascript:void(0)" class="status-option-vendor-index" data-status="approved" data-vendor-id="' + val.id + '"><i class="mdi mdi-check-circle" style="color: #2c9653;"></i> Approved</a></li></ul></div>';
            if (checkDeletePermission) {
                actionHtml += '<a id="' + val.id + '" author="' + (val.author || '') + '" name="vendor-delete" class="delete-btn" href="javascript:void(0)" title="Delete"><i class="mdi mdi-delete"></i></a>';
            }
            actionHtml += '</span>';
            html.push(actionHtml);
            
            console.log('✅ [BUILD HTML] HTML built successfully for restaurant:', id);
            console.log('📊 [BUILD HTML] HTML array contains', html.length, 'elements');
            
            return html;
        }
        async function vendorStatus(id) {
            console.log('👤 [VENDOR STATUS] vendorStatus() called for user ID:', id);
            let status = true;
            try {
                console.log('👤 [VENDOR STATUS] Querying users collection for user:', id);
                console.log('👤 [VENDOR STATUS] Collection: users');
                console.log('👤 [VENDOR STATUS] Document ID:', id);
            await database.collection('users').doc(id).get().then((snapshots) => {
                    console.log('✅ [VENDOR STATUS] User document query successful');
                    console.log('✅ [VENDOR STATUS] Document exists:', snapshots.exists);
                let data = snapshots.data();
                if (data) {
                    status = data.active;
                        console.log('✅ [VENDOR STATUS] User active status:', status);
                    } else {
                        console.warn('⚠️ [VENDOR STATUS] User document has no data');
                    }
                }).catch(function(error) {
                    console.error('❌ [VENDOR STATUS] Error fetching user document!');
                    console.error('❌ [VENDOR STATUS] Error code:', error.code);
                    console.error('❌ [VENDOR STATUS] Error message:', error.message);
                    if (error.code === 'permission-denied') {
                        console.error('🚫 [VENDOR STATUS] PERMISSION DENIED!');
                        console.error('🚫 [VENDOR STATUS] Collection path: /users/' + id);
                    }
                });
            } catch (error) {
                console.error('❌ [VENDOR STATUS] Exception in vendorStatus');
                console.error('❌ [VENDOR STATUS] Error Code:', error.code || 'N/A');
                console.error('❌ [VENDOR STATUS] Error Message:', error.message || 'Unknown error');
            }
            console.log('📤 [VENDOR STATUS] Returning status:', status);
            return status;
        }
        /*async function getTotalProduct(id) {
            let productSnapshots = await database.collection('vendor_products').where('vendorID', '==', id).get();
            return productSnapshots.docs.length;
        }
        async function getTotalOrders(id) {
            let productSnapshots = await database.collection('restaurant_orders').where('vendorID', '==', id).get();
            return productSnapshots.docs.length;
        }*/
        async function getOrdersWithdrawAmount(id) {
            var total_withdraws = 0;
            await database.collection('payouts').where('vendorID', '==', id).where('paymentStatus', '==', 'Success').get().then(async function(productSnapshots) {
                if (productSnapshots && productSnapshots.docs && productSnapshots.docs.length > 0) {
                    productSnapshots.docs.forEach(function(doc) {
                        var order = doc.data();
                        withdraws = parseFloat(order.amount).toFixed(decimal_degits);
                        total_withdraws += parseFloat(withdraws);
                    });
                }
            });
            return total_withdraws;
        }
        async function getOrdersTotalData(id) {
            var order_total = 0;
            var commission_total = 0;
            await database.collection('restaurant_orders').where('status', '==', 'Order Completed').where('vendorID', '==', id).get().then(async function(productSnapshots) {
                if (productSnapshots && productSnapshots.docs && productSnapshots.docs.length > 0) {
                    productSnapshots.docs.forEach(function(doc) {
                        var order = doc.data();
                        var buildOrderTotalData = buildOrderTotal(order);
                        total = parseFloat(buildOrderTotalData.totalPrice).toFixed(decimal_degits);
                        order_total += parseFloat(total);
                        commission = parseFloat(buildOrderTotalData.adminCommission).toFixed(decimal_degits);
                        commission_total += parseFloat(commission);
                    });
                }
            });
            return {
                adminCommission: commission_total,
                totalPrice: order_total
            };
        }

        function buildOrderTotal(snapshotsProducts) {
            var total_price = 0;
            var final_price = 0;
            var adminCommission = snapshotsProducts.adminCommission;
            var adminCommissionType = snapshotsProducts.adminCommissionType;
            var discount = snapshotsProducts.discount;
            var couponCode = snapshotsProducts.couponCode;
            var extras = snapshotsProducts.extras;
            var extras_price = snapshotsProducts.extras_price;
            var rejectedByDrivers = snapshotsProducts.rejectedByDrivers;
            var takeAway = snapshotsProducts.takeAway;
            var tip_amount = snapshotsProducts.tip_amount;
            var notes = snapshotsProducts.notes;
            var tax_amount = snapshotsProducts.vendor.tax_amount;
            var status = snapshotsProducts.status;
            var products = snapshotsProducts.products;
            deliveryCharge = snapshotsProducts.deliveryCharge;
            var specialDiscount = snapshotsProducts.specialDiscount;
            var intRegex = /^\d+$/;
            var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
            if (products) {
                products.forEach((product) => {
                    var val = product;
                    if (val.discountPrice != 0 && val.discountPrice != "" && val.discountPrice != null && !isNaN(val.discountPrice)) {
                        final_price = parseFloat(val.discountPrice);
                    } else {
                        final_price = parseFloat(val.price);
                    }
                    price_item = final_price.toFixed(decimal_degits);
                    totalProductPrice = parseFloat(price_item) * parseInt(val.quantity);
                    var extras_price = 0;
                    if (product.extras != undefined && product.extras != '' && product.extras.length > 0) {
                        extras_price_item = (parseFloat(val.extras_price) * parseInt(val.quantity)).toFixed(decimal_degits);
                        if (parseFloat(extras_price_item) != NaN && val.extras_price != undefined) {
                            extras_price = extras_price_item;
                        }
                        totalProductPrice = parseFloat(extras_price) + parseFloat(totalProductPrice);
                    }
                    totalProductPrice = parseFloat(totalProductPrice).toFixed(decimal_degits);
                    total_price += parseFloat(totalProductPrice);
                });
            }
            if (currencyAtRight) {
                var sub_total = parseFloat(total_price).toFixed(decimal_degits) + "" + currentCurrency;
            } else {
                var sub_total = currentCurrency + "" + parseFloat(total_price).toFixed(decimal_degits);
            }
            if (intRegex.test(discount) || floatRegex.test(discount)) {
                discount = parseFloat(discount).toFixed(decimal_degits);
                total_price -= parseFloat(discount);
            }
            if (specialDiscount != undefined) {
                special_discount = parseFloat(specialDiscount.special_discount).toFixed(2);
                total_price -= parseFloat(special_discount);
            }
            var total_item_price = total_price;
            var tax = 0;
            taxlabel = '';
            taxlabeltype = '';
            if (snapshotsProducts.hasOwnProperty('taxSetting') && snapshotsProducts.taxSetting.length > 0) {
                var total_tax_amount = 0;
                for (var i = 0; i < snapshotsProducts.taxSetting.length; i++) {
                    var data = snapshotsProducts.taxSetting[i];
                    if (data.type && data.tax) {
                        if (data.type == "percentage") {
                            tax = (data.tax * total_price) / 100;
                            var taxvalue = data.tax;
                            taxlabeltype = "%";
                        } else {
                            tax = data.tax;
                            taxlabeltype = "";
                            if (currencyAtRight) {
                                var taxvalue = parseFloat(data.tax).toFixed(decimal_degits) + "" + currentCurrency;
                            } else {
                                var taxvalue = currentCurrency + "" + parseFloat(data.tax).toFixed(decimal_degits);
                            }
                        }
                        taxlabel = data.title;
                    }
                    total_tax_amount += parseFloat(tax);
                }
                total_price = parseFloat(total_price) + parseFloat(total_tax_amount);
            }
            if (intRegex.test(deliveryCharge) || floatRegex.test(deliveryCharge)) {
                deliveryCharge = parseFloat(deliveryCharge).toFixed(decimal_degits);
                total_price += parseFloat(deliveryCharge);
            }
            if (intRegex.test(tip_amount) || floatRegex.test(tip_amount)) {
                tip_amount = parseFloat(tip_amount).toFixed(decimal_degits);
                total_price += parseFloat(tip_amount);
                total_price = parseFloat(total_price).toFixed(decimal_degits);
            }
            if (intRegex.test(adminCommission) || floatRegex.test(adminCommission)) {
                if (adminCommissionType == "Percent") {
                    adminCommission = parseFloat(parseFloat(total_item_price * adminCommission) / 100).toFixed(decimal_degits);
                } else {
                    adminCommission = parseFloat(adminCommission).toFixed(decimal_degits);
                }
            }
            return {
                adminCommission: adminCommission,
                totalPrice: total_price
            };
        }
        $("#is_active").click(function() {
            $("#storeTable .is_open").prop('checked', $(this).prop('checked'));
        });
        $("#deleteAll").click(function() {
            if ($('#storeTable .is_open:checked').length) {
                if (confirm("{{ trans('lang.selected_delete_alert') }}")) {
                    jQuery("#data-table_processing").show();
                    $('#storeTable .is_open:checked').each(function() {
                        var dataId = $(this).attr('dataId');
                        var author = $(this).attr('author');
                        database.collection('users').doc(author).update({
                            'vendorID': ""
                        }).then(function(result) {
                            deleteDocumentWithImage('vendors', dataId, "photo", ['restaurantMenuPhotos', 'photos'])
                                .then(() => {
                                    return deleteStoreData(dataId);
                                })
                                .then(() => {
                                    window.location.reload();
                                })
                                .catch((error) => {
                                    console.error('Error deleting document or store data');
                                    console.error('Error Code:', error.code || 'N/A');
                                    console.error('Error Message:', error.message || 'Unknown error');
                                });
                        });
                    });
                }
            } else {
                alert("{{ trans('lang.select_delete_alert') }}");
            }
        });
        $(document.body).on('click', '.redirecttopage', function() {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });
        $(document).on("click", "a[name='vendor-delete']", function(e) {
            var id = this.id;
            jQuery("#data-table_processing").show();
            var author = $(this).attr('author');
            if (confirm("{{ trans('lang.selected_delete_alert') }}")) {
                deleteDocumentWithImage('vendors', id, "photo", ['restaurantMenuPhotos', 'photos'])
                    .then(() => {
                        return deleteStoreData(id);
                    })
                    .then(() => {
                        window.location.reload();
                    })
                    .catch((error) => {
                        console.error('Error deleting document with image or store data');
                        console.error('Error Code:', error.code || 'N/A');
                        console.error('Error Message:', error.message || 'Unknown error');
                    });
            }
        });
        async function deleteStoreData(storeId) {
            await database.collection('users').where('vendorID', '==', storeId).where('role', '==', 'vendor').get().then(async function(userssanpshots) {
                if (userssanpshots.docs.length > 0) {
                    var item_data = userssanpshots.docs[0].data();
                    var walletSnapshot = await database.collection('wallet').where('user_id', '==', item_data.id).get();
                    if (!walletSnapshot.empty) {
                        for (const doc of walletSnapshot.docs) {
                            await database.collection('wallet').doc(doc.id).delete();
                        }
                    }

                    database.collection('settings').doc("Version").get().then(function(snapshot) {
                        var settingData = snapshot.data();
                        if (settingData && settingData.storeUrl) {
                            var siteurl = settingData.storeUrl + "/api/delete-user";
                            var dataObject = {
                                "uuid": item_data.id
                            };
                            jQuery.ajax({
                                url: siteurl,
                                method: 'POST',
                                contentType: "application/json; charset=utf-8",
                                data: JSON.stringify(dataObject),
                                success: function(data) {
                                    console.log('Delete user from sql success:', data);
                                },
                                error: function(error) {
                                    console.log('Delete user from sql error:', error.responseJSON.message);
                                }
                            });
                        }
                    });
                    var projectId = '<?php echo env('FIREBASE_PROJECT_ID'); ?>';
                    var dataObject = {
                        "data": {
                            "uid": item_data.id
                        }
                    };
                    jQuery.ajax({
                        url: 'https://us-central1-' + projectId + '.cloudfunctions.net/deleteUser',
                        method: 'POST',
                        contentType: "application/json; charset=utf-8",
                        data: JSON.stringify(dataObject),
                        success: async function(data) {
                            console.log('Delete user success:', data.result);
                            await deleteDocumentWithImage('users', item_data.id, 'profilePictureURL');
                        },
                        error: function(xhr, status, error) {
                            var responseText = JSON.parse(xhr.responseText);
                            console.log('Delete user error:', responseText.error);
                        }
                    });
                }
            });
            var productSnapshot = await database.collection('vendor_products').where('vendorID', '==', storeId).get();

            if (!productSnapshot.empty) {

                for (const doc of productSnapshot.docs) {

                    await deleteDocumentWithImage('vendor_products', doc.id, 'photo', 'photos');

                }

            }
            var reviewSnapshot = await database.collection('foods_review').where('VendorId', '==', storeId).get();

            if (!reviewSnapshot.empty) {

                for (const doc of reviewSnapshot.docs) {

                    await deleteDocumentWithImage('items_review', doc.id, '', 'photos');

                }

            }
            var couponSnapshot = await database.collection('coupons').where('vendorID', '==', storeId).get();

            if (!couponSnapshot.empty) {

                for (const doc of couponSnapshot.docs) {

                    await deleteDocumentWithImage('coupons', doc.id, 'image');

                }

            }
            /*await database.collection('favorite_restaurant').where('restaurant_id', '==', storeId).get().then(async function (snapshotsItem) {
                if (snapshotsItem.docs.length > 0) {
                    snapshotsItem.docs.forEach((temData) => {
                        var item_data = temData.data();
                        database.collection('favorite_restaurant').doc(item_data.restaurant_id).delete().then(function () {
                        });
                    });
                }
            })*/
            var payoutSnapshot = await database.collection('payouts').where('vendorID', '==', storeId).get();

            if (!payoutSnapshot.empty) {

                for (const doc of payoutSnapshot.docs) {

                    await database.collection('payouts').doc(doc.id).delete()

                }

            }
            var bookTabelSnapshot = await database.collection('booked_table').where('vendorID', '==', storeId).get();

            if (!bookTabelSnapshot.empty) {

                for (const doc of bookTabelSnapshot.docs) {

                    await database.collection('booked_table').doc(doc.id).delete();

                }

            }
            const storySnapshot = await database.collection('story').where('vendorID', '==', storeId).get();

            if (!storySnapshot.empty) {

                for (const doc of storySnapshot.docs) {

                    await deleteDocumentWithImage('story', doc.id, 'videoThumbnail', 'videoUrl');

                }

            }
            const snapshots = await database.collection('advertisements').where('vendorId', '==', storeId).get();
            if (!snapshots.empty) {
                for (const doc of snapshots.docs) {
                    await deleteDocumentWithImage('advertisements', doc.id);
                }
            }

            const driverSnapshots = await database.collection('users').where('role', '==', 'driver').where('vendorID', '==', storeId).get();
            if (!driverSnapshots.empty) {
                for (const doc of driverSnapshots.docs) {
                    await deleteDocumentWithImage('users', doc.id, 'profilePictureURL');
                }
            }
        }
        $(document).on("click", "a[name='vendor-clone']", async function(e) {
            var id = $(this).attr('vendor_id');
            var author = $(this).attr('author');
            await database.collection('users').doc(author).get().then(async function(snapshotsusers) {
                userData = snapshotsusers.data();
            });
            await database.collection('vendors').doc(id).get().then(async function(snapshotsvendors) {
                vendorData = snapshotsvendors.data();
            });
            await database.collection('vendor_products').where('vendorID', '==', id).get().then(async function(snapshotsproducts) {
                vendorProducts = [];
                snapshotsproducts.docs.forEach(async (product) => {
                    vendorProducts.push(product.data());
                });
            });
            if (userData && vendorData) {
                jQuery("#create_vendor").modal('show');
                jQuery("#vendor_title_lable").text(vendorData.title);
            }
        });
        $(document).on("click", ".save-form-btn", async function(e) {
            var vendor_id = database.collection("tmp").doc().id;
            if (userData && vendorData) {
                var vendor_title = jQuery("#vendor_title").val();
                var userFirstName = jQuery("#user_name").val();
                var userLastName = jQuery("#user_last_name").val();
                var email = jQuery("#user_email").val();
                var password = jQuery("#user_password").val();
                if (userFirstName == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.user_name_required') }}</p>");
                    window.scrollTo(0, 0);
                } else if (userLastName == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.user_last_name_required') }}</p>");
                    window.scrollTo(0, 0);
                } else if (vendor_title == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.vendor_title_required') }}</p>");
                    window.scrollTo(0, 0);
                } else if (email == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.user_email_required') }}</p>");
                    window.scrollTo(0, 0);
                } else if (password == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.enter_owners_password_error') }}</p>");
                    window.scrollTo(0, 0);
                } else {
                    jQuery("#data-table_processing2").show();
                    firebase.auth().createUserWithEmailAndPassword(email, password).then(async function(firebaseUser) {
                        var user_id = firebaseUser.user.uid;
                        userData.email = email;
                        userData.firstName = userFirstName;
                        userData.lastName = userLastName;
                        userData.id = user_id;
                        userData.vendorID = vendor_id;
                        userData.createdAt = createdAt;
                        userData.wallet_amount = 0;
                        vendorData.author = user_id;
                        vendorData.authorName = userFirstName + ' ' + userLastName;
                        vendorData.title = vendor_title;
                        vendorData.id = vendor_id;
                        coordinates = new firebase.firestore.GeoPoint(vendorData.latitude, vendorData.longitude);
                        vendorData.coordinates = coordinates;
                        vendorData.createdAt = createdAt;
                        await database.collection('users').doc(user_id).set(userData).then(async function(result) {
                            await geoFirestore.collection('vendors').doc(vendor_id).set(vendorData).then(async function(result) {
                                var count = 0;
                                await vendorProducts.forEach(async (product) => {
                                    var product_id = await database.collection("tmp").doc().id;
                                    product.id = product_id;
                                    product.vendorID = vendor_id;
                                    await database.collection('vendor_products').doc(product_id).set(product).then(function(result) {
                                        count++;
                                        if (count == vendorProducts.length) {
                                            jQuery("#data-table_processing2").hide();
                                            alert('Successfully created.');
                                            jQuery("#create_vendor").modal('hide');
                                            location.reload();
                                        }
                                    });
                                });
                            });
                        })
                    }).catch(function(error) {
                        $(".error_top").show();
                        jQuery("#data-table_processing2").hide();
                        $(".error_top").html("");
                        $(".error_top").append("<p>" + error + "</p>");
                    });
                }
            }
        });
    </script>
@endsection

                            console.error('   3. Or deploy: firebase deploy --only firestore:indexes');
                            console.error('   4. Wait 2-5 minutes for index to be enabled');
                        } else {
                            console.error('🚫 [AJAX] ========================================');
                            console.error('🚫 [AJAX] UNKNOWN ERROR!');
                            console.error('🚫 [AJAX] ========================================');
                            console.error('🚫 [AJAX] Error Code:', error.code || 'N/A');
                            console.error('🚫 [AJAX] Error Message:', error.message || 'Unknown error');
                            console.error('🚫 [AJAX] Error Name:', error.name || 'Error');
                        }
                        
                        sendLogToServer('error', '❌ Error fetching data from Firestore', { 
                            error: error.message,
                            code: error.code,
                            name: error.name
                        });
                        
                        // Return empty result on error
                        console.error('❌ [AJAX] Returning empty result due to error');
                        $('#data-table_processing').hide();
                        callback({
                            draw: data.draw,
                            recordsTotal: 0,
                            recordsFiltered: 0,
                            filteredData: [],
                            data: []
                        });
                        console.error('❌ [AJAX] ========================================');
                    } catch (queryError) {
                        console.error('❌ [AJAX] ========================================');
                        console.error('❌ [AJAX] EXCEPTION IN QUERY SETUP!');
                        console.error('❌ [AJAX] ========================================');
                        var errorType = 'Unknown';
                        var errorMessage = 'Unknown error';
                        var errorCode = 'N/A';
                        var errorStack = null;
                        
                        try {
                            if (queryError && queryError.constructor) {
                                errorType = queryError.constructor.name || 'Error';
                            }
                            errorMessage = (queryError && queryError.message) ? queryError.message : 'Unknown error';
                            errorCode = (queryError && queryError.code) ? queryError.code : 'N/A';
                            errorStack = (queryError && queryError.stack) ? queryError.stack : null;
                        } catch (e) {
                            errorType = 'Error';
                            errorMessage = String(queryError || 'Unknown error');
                        }
                        
                        console.error('❌ [AJAX] Exception Type:', errorType);
                        console.error('❌ [AJAX] Exception Message:', errorMessage);
                        console.error('❌ [AJAX] Exception Code:', errorCode);
                        if (errorStack) {
                            console.error('❌ [AJAX] Exception Stack:', errorStack);
                        }
                        
                        if (errorCode === 'permission-denied') {
                            console.error('🚫 [AJAX] PERMISSION DENIED in catch block!');
                            console.error('🚫 [AJAX] Firestore Rules are blocking access');
                            console.error('🚫 [AJAX] Solution: firebase deploy --only firestore:rules');
                        } else if (errorCode === 'failed-precondition') {
                            console.error('🚫 [AJAX] INDEX MISSING in catch block!');
                            console.error('🚫 [AJAX] Required index: vendors/createdAt DESC + id ASC');
                            console.error('🚫 [AJAX] Solution: firebase deploy --only firestore:indexes');
                        }
                        
                        sendLogToServer('error', '❌ Error in query setup', { 
                            error: errorMessage,
                            code: errorCode,
                            type: errorType
                        });
                        $('#data-table_processing').hide();
                        callback({
                            draw: data.draw,
                            recordsTotal: 0,
                            recordsFiltered: 0,
                            filteredData: [],
                            data: []
                        });
                        console.error('❌ [AJAX] ========================================');
                    }
                },
                order: (checkDeletePermission) ? [
                    [4, 'desc']
                ] : [
                    [3, 'desc']
                ],
                columnDefs: [{
                        targets: (checkDeletePermission) ? 4 : 3,
                        type: 'date',
                        render: function(data) {
                            return data;
                        }
                    },
                    {
                        orderable: false,
                        targets: (checkDeletePermission) ? [0, 4, 5] : [3, 4]
                    },
                ],
                "language": {
                    "zeroRecords": "{{ trans('lang.no_record_found') }}",
                    "emptyTable": "{{ trans('lang.no_record_found') }}",
                    "processing": ""
                },
                dom: 'lfrtipB',
                buttons: [{
                    extend: 'collection',
                    text: '<i class="mdi mdi-cloud-download"></i> Export as',
                    className: 'btn btn-info',
                    buttons: [{
                            extend: 'excelHtml5',
                            text: 'Export Excel',
                            action: function(e, dt, button, config) {
                                exportData(dt, 'excel', fieldConfig);
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'Export PDF',
                            action: function(e, dt, button, config) {
                                exportData(dt, 'pdf', fieldConfig);
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            text: 'Export CSV',
                            action: function(e, dt, button, config) {
                                exportData(dt, 'csv', fieldConfig);
                            }
                        }
                    ]
                }],
                initComplete: function() {
                    console.log('✅ [DATATABLE] ========================================');
                    console.log('✅ [DATATABLE] DataTable Initialized Successfully!');
                    console.log('✅ [DATATABLE] ========================================');
                    console.log('✅ [DATATABLE] Table ID: #storeTable');
                    console.log('✅ [DATATABLE] Ready to load data');
                    console.log('✅ [DATATABLE] DataTable instance:', table);
                    console.log('✅ [DATATABLE] AJAX will be called automatically');
                    $('#data-table_processing').hide();
                    $(".dataTables_filter").append($(".dt-buttons").detach());
                    $('.dataTables_filter input').attr('placeholder', 'Search here...').attr('autocomplete', 'new-password').val('');
                    $('.dataTables_filter label').contents().filter(function() {
                        return this.nodeType === 3;
                    }).remove();
                    console.log('✅ [DATATABLE] UI elements configured');
                }
            });
            
            console.log('✅ [DATATABLE] DataTable instance created');
            console.log('✅ [DATATABLE] Table variable exists:', !!table);

            function debounce(func, wait) {
                let timeout;
                const context = this;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }
            $('#search-input').on('input', debounce(function() {
                const searchValue = $(this).val();
                if (searchValue.length >= 3) {
                    $('#data-table_processing').show();
                    table.search(searchValue).draw();
                } else if (searchValue.length === 0) {
                    $('#data-table_processing').show();
                    table.search('').draw();
                }
            }, 300));
        });
        async function buildHTML(val) {
            console.log('🔨 [BUILD HTML] Building HTML for restaurant:', val.id || 'unknown');
            var html = [];
            // Check if id exists
            if (!val || !val.id) {
                console.error('❌ [BUILD HTML] Restaurant data missing id:', val);
                console.error('❌ [BUILD HTML] Cannot build HTML without ID');
                return [];
            }
            
            console.log('✅ [BUILD HTML] Restaurant ID:', val.id);
            console.log('📋 [BUILD HTML] Restaurant data:');
            console.log('📋 [BUILD HTML] ID:', val.id || 'NO ID');
            var safeTitle = (val.title && typeof val.title === 'string') ? val.title.substring(0, 50) : 'NO TITLE';
            var safeAuthor = (val.author && typeof val.author === 'string') ? val.author : 'NO AUTHOR';
            console.log('📋 [BUILD HTML] Title:', safeTitle);
            console.log('📋 [BUILD HTML] Author:', safeAuthor);
            console.log('📋 [BUILD HTML] Has Photo:', !!val.photo);
            console.log('📋 [BUILD HTML] Has Created At:', !!val.createdAt);
            var id = val.id;
            var vendorUserId = val.author;
            
            // Get author name - use existing authorName if available, otherwise fetch from users collection
            if (!val.authorName || val.authorName.trim() === '') {
                if (vendorUserId && vendorUserId.trim() !== '') {
                    try {
                        console.log('👤 [BUILD HTML] Fetching author name from users collection for:', vendorUserId);
                        const userDoc = await database.collection('users').doc(vendorUserId).get();
                        if (userDoc.exists) {
                            const userData = userDoc.data();
                            val.authorName = (userData.firstName || '') + ' ' + (userData.lastName || '');
                            console.log('✅ [BUILD HTML] Fetched author name:', val.authorName);
                        } else {
                            console.warn('⚠️ [BUILD HTML] User document not found:', vendorUserId);
                            val.authorName = val.authorName || 'N/A';
                        }
                    } catch (err) {
                        console.warn('⚠️ [BUILD HTML] Error fetching user data:', err);
                        val.authorName = val.authorName || 'N/A';
                    }
                } else {
                    console.warn('⚠️ [BUILD HTML] No author ID provided, using existing authorName or N/A');
                    val.authorName = val.authorName || 'N/A';
                }
            } else {
                console.log('✅ [BUILD HTML] Using existing authorName from document:', val.authorName);
            }
            var route1 = '{{ route('restaurants.edit', ':id') }}';
            route1 = route1.replace(':id', id);
            var route_view = '{{ route('restaurants.view', ':id') }}';
            route_view = route_view.replace(':id', id);
            if (checkDeletePermission) {
                html.push('<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '" author="' + (val.author || '') + '"><label class="col-3 control-label" for="is_open_' + id + '"></label></td>');
            }
            var restaurantInfo = '';
            if (val.photo != '' && val.photo != null) {
                restaurantInfo += '<img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="" width="100%" style="width:70px;height:70px;" src="' + val.photo + '" alt="image">';
            } else {
                restaurantInfo += '<img alt="" width="100%" style="width:70px;height:70px;" src="' + placeholderImage + '" alt="image">';
            }
            if (val.title && val.title != " " && val.title != "null" && val.title != null && val.title != "") {
                restaurantInfo += '<a href="' + route_view + '">' + val.title + '</a>';
            } else {
                restaurantInfo += 'UNKNOWN';
            }
            html.push(restaurantInfo);
            var ownerInfo = '';
            if (val.authorName) {
                ownerInfo += '<a href="' + route_view + '">' + val.authorName + '</a><br>';
            }
            if (val.hasOwnProperty('phonenumber') && val.phonenumber != null && val.phonenumber != "") {
                ownerInfo += '<a>' + val.phonenumber + '</a>';
            } else {
                ownerInfo += '';
            }
            html.push(ownerInfo);
            var date = '';
            var time = '';
            if (val.hasOwnProperty("createdAt")) {
                try {
                    date = val.createdAt.toDate().toDateString();
                    time = val.createdAt.toDate().toLocaleTimeString('en-US');
                } catch (err) {}
                html.push('<span class="dt-time">' + date + ' ' + time + '</span>');
            } else {
                html.push('');
            }
            var payoutRequests = '{{ route('users.walletstransaction', ':id') }}';
            var walletHistoryText = '{{ trans('lang.wallet_history') }}';
            if (val.author) {
                payoutRequests = payoutRequests.replace(':id', val.author);
                html.push('<a href="' + payoutRequests + '">' + walletHistoryText + '</a>');
            } else {
                html.push('');
            }
            var active = val.isActive;
            var vendorId = val.id;
            if (!vendorId) {
                console.error('❌ Restaurant missing id:', val);
                return [];
            }
            var food_url = '{{ route('restaurants.foods', ':id') }}';
            food_url = food_url.replace(":id", vendorId);
            var vendor_url = '{{ route('restaurants.orders', ':id') }}';
            vendor_url = vendor_url.replace(":id", vendorId);
            var actionHtml = '';
            actionHtml += '<span class="action-btn">';
            actionHtml += '<a href="' + food_url + '"><i class="mdi mdi-food" title="Foods"></i></a>';
            actionHtml += '<a href="' + vendor_url + '"><i class="mdi mdi-view-list" title="Orders"></i></a>';
            actionHtml += '<a href="javascript:void(0)" vendor_id="' + val.id + '" author="' + (val.author || '') + '" name="vendor-clone" title="Copy"><i class="mdi mdi-content-copy"></i></a>';
            actionHtml += '<a href="' + route_view + '"><i class="mdi mdi-eye" title="View"></i></a>';
            var currentStatus = val.approvalStatus || 'waiting';
            var statusIcon = '';
            var statusColor = '#2c9653';
            if (currentStatus === 'approved') {
                statusIcon = 'mdi-check-circle';
                statusColor = '#2c9653';
            } else if (currentStatus === 'rejected') {
                statusIcon = 'mdi-close-circle';
                statusColor = '#dc3545';
            } else {
                statusIcon = 'mdi-clock-outline';
                statusColor = '#ffc107';
            }
            actionHtml += '<div class="dropdown" style="display: inline-block;"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" vendor_id="' + val.id + '" approval_status="' + currentStatus + '" name="vendor-status-dropdown-index" title="Change Status"><i class="mdi ' + statusIcon + '" style="color: ' + statusColor + '; font-size: 18px;"></i></a><ul class="dropdown-menu status-dropdown-menu" role="menu"><li><a href="javascript:void(0)" class="status-option-vendor-index" data-status="waiting" data-vendor-id="' + val.id + '"><i class="mdi mdi-clock-outline" style="color: #ffc107;"></i> Waiting</a></li><li><a href="javascript:void(0)" class="status-option-vendor-index" data-status="rejected" data-vendor-id="' + val.id + '"><i class="mdi mdi-close-circle" style="color: #dc3545;"></i> Rejected</a></li><li><a href="javascript:void(0)" class="status-option-vendor-index" data-status="approved" data-vendor-id="' + val.id + '"><i class="mdi mdi-check-circle" style="color: #2c9653;"></i> Approved</a></li></ul></div>';
            if (checkDeletePermission) {
                actionHtml += '<a id="' + val.id + '" author="' + (val.author || '') + '" name="vendor-delete" class="delete-btn" href="javascript:void(0)" title="Delete"><i class="mdi mdi-delete"></i></a>';
            }
            actionHtml += '</span>';
            html.push(actionHtml);
            
            console.log('✅ [BUILD HTML] HTML built successfully for restaurant:', id);
            console.log('📊 [BUILD HTML] HTML array contains', html.length, 'elements');
            
            return html;
        }
        async function vendorStatus(id) {
            console.log('👤 [VENDOR STATUS] vendorStatus() called for user ID:', id);
            let status = true;
            try {
                console.log('👤 [VENDOR STATUS] Querying users collection for user:', id);
                console.log('👤 [VENDOR STATUS] Collection: users');
                console.log('👤 [VENDOR STATUS] Document ID:', id);
            await database.collection('users').doc(id).get().then((snapshots) => {
                    console.log('✅ [VENDOR STATUS] User document query successful');
                    console.log('✅ [VENDOR STATUS] Document exists:', snapshots.exists);
                let data = snapshots.data();
                if (data) {
                    status = data.active;
                        console.log('✅ [VENDOR STATUS] User active status:', status);
                    } else {
                        console.warn('⚠️ [VENDOR STATUS] User document has no data');
                    }
                }).catch(function(error) {
                    console.error('❌ [VENDOR STATUS] Error fetching user document!');
                    console.error('❌ [VENDOR STATUS] Error code:', error.code);
                    console.error('❌ [VENDOR STATUS] Error message:', error.message);
                    if (error.code === 'permission-denied') {
                        console.error('🚫 [VENDOR STATUS] PERMISSION DENIED!');
                        console.error('🚫 [VENDOR STATUS] Collection path: /users/' + id);
                    }
                });
            } catch (error) {
                console.error('❌ [VENDOR STATUS] Exception in vendorStatus');
                console.error('❌ [VENDOR STATUS] Error Code:', error.code || 'N/A');
                console.error('❌ [VENDOR STATUS] Error Message:', error.message || 'Unknown error');
            }
            console.log('📤 [VENDOR STATUS] Returning status:', status);
            return status;
        }
        /*async function getTotalProduct(id) {
            let productSnapshots = await database.collection('vendor_products').where('vendorID', '==', id).get();
            return productSnapshots.docs.length;
        }
        async function getTotalOrders(id) {
            let productSnapshots = await database.collection('restaurant_orders').where('vendorID', '==', id).get();
            return productSnapshots.docs.length;
        }*/
        async function getOrdersWithdrawAmount(id) {
            var total_withdraws = 0;
            await database.collection('payouts').where('vendorID', '==', id).where('paymentStatus', '==', 'Success').get().then(async function(productSnapshots) {
                if (productSnapshots && productSnapshots.docs && productSnapshots.docs.length > 0) {
                    productSnapshots.docs.forEach(function(doc) {
                        var order = doc.data();
                        withdraws = parseFloat(order.amount).toFixed(decimal_degits);
                        total_withdraws += parseFloat(withdraws);
                    });
                }
            });
            return total_withdraws;
        }
        async function getOrdersTotalData(id) {
            var order_total = 0;
            var commission_total = 0;
            await database.collection('restaurant_orders').where('status', '==', 'Order Completed').where('vendorID', '==', id).get().then(async function(productSnapshots) {
                if (productSnapshots && productSnapshots.docs && productSnapshots.docs.length > 0) {
                    productSnapshots.docs.forEach(function(doc) {
                        var order = doc.data();
                        var buildOrderTotalData = buildOrderTotal(order);
                        total = parseFloat(buildOrderTotalData.totalPrice).toFixed(decimal_degits);
                        order_total += parseFloat(total);
                        commission = parseFloat(buildOrderTotalData.adminCommission).toFixed(decimal_degits);
                        commission_total += parseFloat(commission);
                    });
                }
            });
            return {
                adminCommission: commission_total,
                totalPrice: order_total
            };
        }

        function buildOrderTotal(snapshotsProducts) {
            var total_price = 0;
            var final_price = 0;
            var adminCommission = snapshotsProducts.adminCommission;
            var adminCommissionType = snapshotsProducts.adminCommissionType;
            var discount = snapshotsProducts.discount;
            var couponCode = snapshotsProducts.couponCode;
            var extras = snapshotsProducts.extras;
            var extras_price = snapshotsProducts.extras_price;
            var rejectedByDrivers = snapshotsProducts.rejectedByDrivers;
            var takeAway = snapshotsProducts.takeAway;
            var tip_amount = snapshotsProducts.tip_amount;
            var notes = snapshotsProducts.notes;
            var tax_amount = snapshotsProducts.vendor.tax_amount;
            var status = snapshotsProducts.status;
            var products = snapshotsProducts.products;
            deliveryCharge = snapshotsProducts.deliveryCharge;
            var specialDiscount = snapshotsProducts.specialDiscount;
            var intRegex = /^\d+$/;
            var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
            if (products) {
                products.forEach((product) => {
                    var val = product;
                    if (val.discountPrice != 0 && val.discountPrice != "" && val.discountPrice != null && !isNaN(val.discountPrice)) {
                        final_price = parseFloat(val.discountPrice);
                    } else {
                        final_price = parseFloat(val.price);
                    }
                    price_item = final_price.toFixed(decimal_degits);
                    totalProductPrice = parseFloat(price_item) * parseInt(val.quantity);
                    var extras_price = 0;
                    if (product.extras != undefined && product.extras != '' && product.extras.length > 0) {
                        extras_price_item = (parseFloat(val.extras_price) * parseInt(val.quantity)).toFixed(decimal_degits);
                        if (parseFloat(extras_price_item) != NaN && val.extras_price != undefined) {
                            extras_price = extras_price_item;
                        }
                        totalProductPrice = parseFloat(extras_price) + parseFloat(totalProductPrice);
                    }
                    totalProductPrice = parseFloat(totalProductPrice).toFixed(decimal_degits);
                    total_price += parseFloat(totalProductPrice);
                });
            }
            if (currencyAtRight) {
                var sub_total = parseFloat(total_price).toFixed(decimal_degits) + "" + currentCurrency;
            } else {
                var sub_total = currentCurrency + "" + parseFloat(total_price).toFixed(decimal_degits);
            }
            if (intRegex.test(discount) || floatRegex.test(discount)) {
                discount = parseFloat(discount).toFixed(decimal_degits);
                total_price -= parseFloat(discount);
            }
            if (specialDiscount != undefined) {
                special_discount = parseFloat(specialDiscount.special_discount).toFixed(2);
                total_price -= parseFloat(special_discount);
            }
            var total_item_price = total_price;
            var tax = 0;
            taxlabel = '';
            taxlabeltype = '';
            if (snapshotsProducts.hasOwnProperty('taxSetting') && snapshotsProducts.taxSetting.length > 0) {
                var total_tax_amount = 0;
                for (var i = 0; i < snapshotsProducts.taxSetting.length; i++) {
                    var data = snapshotsProducts.taxSetting[i];
                    if (data.type && data.tax) {
                        if (data.type == "percentage") {
                            tax = (data.tax * total_price) / 100;
                            var taxvalue = data.tax;
                            taxlabeltype = "%";
                        } else {
                            tax = data.tax;
                            taxlabeltype = "";
                            if (currencyAtRight) {
                                var taxvalue = parseFloat(data.tax).toFixed(decimal_degits) + "" + currentCurrency;
                            } else {
                                var taxvalue = currentCurrency + "" + parseFloat(data.tax).toFixed(decimal_degits);
                            }
                        }
                        taxlabel = data.title;
                    }
                    total_tax_amount += parseFloat(tax);
                }
                total_price = parseFloat(total_price) + parseFloat(total_tax_amount);
            }
            if (intRegex.test(deliveryCharge) || floatRegex.test(deliveryCharge)) {
                deliveryCharge = parseFloat(deliveryCharge).toFixed(decimal_degits);
                total_price += parseFloat(deliveryCharge);
            }
            if (intRegex.test(tip_amount) || floatRegex.test(tip_amount)) {
                tip_amount = parseFloat(tip_amount).toFixed(decimal_degits);
                total_price += parseFloat(tip_amount);
                total_price = parseFloat(total_price).toFixed(decimal_degits);
            }
            if (intRegex.test(adminCommission) || floatRegex.test(adminCommission)) {
                if (adminCommissionType == "Percent") {
                    adminCommission = parseFloat(parseFloat(total_item_price * adminCommission) / 100).toFixed(decimal_degits);
                } else {
                    adminCommission = parseFloat(adminCommission).toFixed(decimal_degits);
                }
            }
            return {
                adminCommission: adminCommission,
                totalPrice: total_price
            };
        }
        $("#is_active").click(function() {
            $("#storeTable .is_open").prop('checked', $(this).prop('checked'));
        });
        $("#deleteAll").click(function() {
            if ($('#storeTable .is_open:checked').length) {
                if (confirm("{{ trans('lang.selected_delete_alert') }}")) {
                    jQuery("#data-table_processing").show();
                    $('#storeTable .is_open:checked').each(function() {
                        var dataId = $(this).attr('dataId');
                        var author = $(this).attr('author');
                        database.collection('users').doc(author).update({
                            'vendorID': ""
                        }).then(function(result) {
                            deleteDocumentWithImage('vendors', dataId, "photo", ['restaurantMenuPhotos', 'photos'])
                                .then(() => {
                                    return deleteStoreData(dataId);
                                })
                                .then(() => {
                                    window.location.reload();
                                })
                                .catch((error) => {
                                    console.error('Error deleting document or store data');
                                    console.error('Error Code:', error.code || 'N/A');
                                    console.error('Error Message:', error.message || 'Unknown error');
                                });
                        });
                    });
                }
            } else {
                alert("{{ trans('lang.select_delete_alert') }}");
            }
        });
        $(document.body).on('click', '.redirecttopage', function() {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });
        $(document).on("click", "a[name='vendor-delete']", function(e) {
            var id = this.id;
            jQuery("#data-table_processing").show();
            var author = $(this).attr('author');
            if (confirm("{{ trans('lang.selected_delete_alert') }}")) {
                deleteDocumentWithImage('vendors', id, "photo", ['restaurantMenuPhotos', 'photos'])
                    .then(() => {
                        return deleteStoreData(id);
                    })
                    .then(() => {
                        window.location.reload();
                    })
                    .catch((error) => {
                        console.error('Error deleting document with image or store data');
                        console.error('Error Code:', error.code || 'N/A');
                        console.error('Error Message:', error.message || 'Unknown error');
                    });
            }
        });
        async function deleteStoreData(storeId) {
            await database.collection('users').where('vendorID', '==', storeId).where('role', '==', 'vendor').get().then(async function(userssanpshots) {
                if (userssanpshots.docs.length > 0) {
                    var item_data = userssanpshots.docs[0].data();
                    var walletSnapshot = await database.collection('wallet').where('user_id', '==', item_data.id).get();
                    if (!walletSnapshot.empty) {
                        for (const doc of walletSnapshot.docs) {
                            await database.collection('wallet').doc(doc.id).delete();
                        }
                    }

                    database.collection('settings').doc("Version").get().then(function(snapshot) {
                        var settingData = snapshot.data();
                        if (settingData && settingData.storeUrl) {
                            var siteurl = settingData.storeUrl + "/api/delete-user";
                            var dataObject = {
                                "uuid": item_data.id
                            };
                            jQuery.ajax({
                                url: siteurl,
                                method: 'POST',
                                contentType: "application/json; charset=utf-8",
                                data: JSON.stringify(dataObject),
                                success: function(data) {
                                    console.log('Delete user from sql success:', data);
                                },
                                error: function(error) {
                                    console.log('Delete user from sql error:', error.responseJSON.message);
                                }
                            });
                        }
                    });
                    var projectId = '<?php echo env('FIREBASE_PROJECT_ID'); ?>';
                    var dataObject = {
                        "data": {
                            "uid": item_data.id
                        }
                    };
                    jQuery.ajax({
                        url: 'https://us-central1-' + projectId + '.cloudfunctions.net/deleteUser',
                        method: 'POST',
                        contentType: "application/json; charset=utf-8",
                        data: JSON.stringify(dataObject),
                        success: async function(data) {
                            console.log('Delete user success:', data.result);
                            await deleteDocumentWithImage('users', item_data.id, 'profilePictureURL');
                        },
                        error: function(xhr, status, error) {
                            var responseText = JSON.parse(xhr.responseText);
                            console.log('Delete user error:', responseText.error);
                        }
                    });
                }
            });
            var productSnapshot = await database.collection('vendor_products').where('vendorID', '==', storeId).get();

            if (!productSnapshot.empty) {

                for (const doc of productSnapshot.docs) {

                    await deleteDocumentWithImage('vendor_products', doc.id, 'photo', 'photos');

                }

            }
            var reviewSnapshot = await database.collection('foods_review').where('VendorId', '==', storeId).get();

            if (!reviewSnapshot.empty) {

                for (const doc of reviewSnapshot.docs) {

                    await deleteDocumentWithImage('items_review', doc.id, '', 'photos');

                }

            }
            var couponSnapshot = await database.collection('coupons').where('vendorID', '==', storeId).get();

            if (!couponSnapshot.empty) {

                for (const doc of couponSnapshot.docs) {

                    await deleteDocumentWithImage('coupons', doc.id, 'image');

                }

            }
            /*await database.collection('favorite_restaurant').where('restaurant_id', '==', storeId).get().then(async function (snapshotsItem) {
                if (snapshotsItem.docs.length > 0) {
                    snapshotsItem.docs.forEach((temData) => {
                        var item_data = temData.data();
                        database.collection('favorite_restaurant').doc(item_data.restaurant_id).delete().then(function () {
                        });
                    });
                }
            })*/
            var payoutSnapshot = await database.collection('payouts').where('vendorID', '==', storeId).get();

            if (!payoutSnapshot.empty) {

                for (const doc of payoutSnapshot.docs) {

                    await database.collection('payouts').doc(doc.id).delete()

                }

            }
            var bookTabelSnapshot = await database.collection('booked_table').where('vendorID', '==', storeId).get();

            if (!bookTabelSnapshot.empty) {

                for (const doc of bookTabelSnapshot.docs) {

                    await database.collection('booked_table').doc(doc.id).delete();

                }

            }
            const storySnapshot = await database.collection('story').where('vendorID', '==', storeId).get();

            if (!storySnapshot.empty) {

                for (const doc of storySnapshot.docs) {

                    await deleteDocumentWithImage('story', doc.id, 'videoThumbnail', 'videoUrl');

                }

            }
            const snapshots = await database.collection('advertisements').where('vendorId', '==', storeId).get();
            if (!snapshots.empty) {
                for (const doc of snapshots.docs) {
                    await deleteDocumentWithImage('advertisements', doc.id);
                }
            }

            const driverSnapshots = await database.collection('users').where('role', '==', 'driver').where('vendorID', '==', storeId).get();
            if (!driverSnapshots.empty) {
                for (const doc of driverSnapshots.docs) {
                    await deleteDocumentWithImage('users', doc.id, 'profilePictureURL');
                }
            }
        }
        $(document).on("click", "a[name='vendor-clone']", async function(e) {
            var id = $(this).attr('vendor_id');
            var author = $(this).attr('author');
            await database.collection('users').doc(author).get().then(async function(snapshotsusers) {
                userData = snapshotsusers.data();
            });
            await database.collection('vendors').doc(id).get().then(async function(snapshotsvendors) {
                vendorData = snapshotsvendors.data();
            });
            await database.collection('vendor_products').where('vendorID', '==', id).get().then(async function(snapshotsproducts) {
                vendorProducts = [];
                snapshotsproducts.docs.forEach(async (product) => {
                    vendorProducts.push(product.data());
                });
            });
            if (userData && vendorData) {
                jQuery("#create_vendor").modal('show');
                jQuery("#vendor_title_lable").text(vendorData.title);
            }
        });
        $(document).on("click", ".save-form-btn", async function(e) {
            var vendor_id = database.collection("tmp").doc().id;
            if (userData && vendorData) {
                var vendor_title = jQuery("#vendor_title").val();
                var userFirstName = jQuery("#user_name").val();
                var userLastName = jQuery("#user_last_name").val();
                var email = jQuery("#user_email").val();
                var password = jQuery("#user_password").val();
                if (userFirstName == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.user_name_required') }}</p>");
                    window.scrollTo(0, 0);
                } else if (userLastName == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.user_last_name_required') }}</p>");
                    window.scrollTo(0, 0);
                } else if (vendor_title == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.vendor_title_required') }}</p>");
                    window.scrollTo(0, 0);
                } else if (email == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.user_email_required') }}</p>");
                    window.scrollTo(0, 0);
                } else if (password == '') {
                    $(".error_top").show();
                    $(".error_top").html("");
                    $(".error_top").append("<p>{{ trans('lang.enter_owners_password_error') }}</p>");
                    window.scrollTo(0, 0);
                } else {
                    jQuery("#data-table_processing2").show();
                    firebase.auth().createUserWithEmailAndPassword(email, password).then(async function(firebaseUser) {
                        var user_id = firebaseUser.user.uid;
                        userData.email = email;
                        userData.firstName = userFirstName;
                        userData.lastName = userLastName;
                        userData.id = user_id;
                        userData.vendorID = vendor_id;
                        userData.createdAt = createdAt;
                        userData.wallet_amount = 0;
                        vendorData.author = user_id;
                        vendorData.authorName = userFirstName + ' ' + userLastName;
                        vendorData.title = vendor_title;
                        vendorData.id = vendor_id;
                        coordinates = new firebase.firestore.GeoPoint(vendorData.latitude, vendorData.longitude);
                        vendorData.coordinates = coordinates;
                        vendorData.createdAt = createdAt;
                        await database.collection('users').doc(user_id).set(userData).then(async function(result) {
                            await geoFirestore.collection('vendors').doc(vendor_id).set(vendorData).then(async function(result) {
                                var count = 0;
                                await vendorProducts.forEach(async (product) => {
                                    var product_id = await database.collection("tmp").doc().id;
                                    product.id = product_id;
                                    product.vendorID = vendor_id;
                                    await database.collection('vendor_products').doc(product_id).set(product).then(function(result) {
                                        count++;
                                        if (count == vendorProducts.length) {
                                            jQuery("#data-table_processing2").hide();
                                            alert('Successfully created.');
                                            jQuery("#create_vendor").modal('hide');
                                            location.reload();
                                        }
                                    });
                                });
                            });
                        })
                    }).catch(function(error) {
                        $(".error_top").show();
                        jQuery("#data-table_processing2").hide();
                        $(".error_top").html("");
                        $(".error_top").append("<p>" + error + "</p>");
                    });
                }
            }
        });
    </script>
@endsection

