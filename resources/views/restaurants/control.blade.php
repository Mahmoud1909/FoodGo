@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Restaurant Control</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Restaurants</li>
                    <li class="breadcrumb-item active">Restaurant Control</li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <!-- Statistics Cards -->
            <div class="admin-top-section">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex top-title-section pb-4 justify-content-between">
                            <div class="d-flex top-title-left align-self-center">
                                <span class="icon mr-3"><img src="{{ asset('images/restaurant.png') }}"></span>
                                <h3 class="mb-0">Restaurants</h3>
                                <span class="counter ml-3 rest_count">00</span>
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

            <!-- Restaurants List -->
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
    console.log('🎛️ [RESTAURANT CONTROL] ========================================');
    console.log('🎛️ [RESTAURANT CONTROL] Restaurant Control Page Started');
    console.log('🎛️ [RESTAURANT CONTROL] ========================================');
    
    var database = null;
    var refData = null;
    var vendorsListener = null;
    var zonesListener = null;
    var categoriesListener = null;
    var subscriptionPlansListener = null;
    var currentCurrency = '£';
    var currencyAtRight = false;
    var decimal_degits = 2;
    var placeholderImage = '';
    var checkDeletePermission = false;
    var user_permissions = '<?php echo @session('user_permissions'); ?>';
    
    if (user_permissions) {
        try {
            user_permissions = Object.values(JSON.parse(user_permissions));
            if ($.inArray('restaurant.delete', user_permissions) >= 0) {
                checkDeletePermission = true;
            }
        } catch (e) {
            console.warn('⚠️ Error parsing user permissions:', e);
        }
    }
    
    // Wait for Firestore
    window.waitForFirestore(function(db) {
        console.log('🔄 [RESTAURANT CONTROL] ========================================');
        console.log('🔄 [RESTAURANT CONTROL] Checking Firestore connection...');
        console.log('🔄 [RESTAURANT CONTROL] ========================================');
        
        if (!db) {
            console.error('❌ [RESTAURANT CONTROL] ========================================');
            console.error('❌ [RESTAURANT CONTROL] FIRESTORE NOT AVAILABLE');
            console.error('❌ [RESTAURANT CONTROL] ========================================');
            console.error('❌ [RESTAURANT CONTROL] Firestore database connection failed');
            console.error('❌ [RESTAURANT CONTROL] Please check:');
            console.error('   1. Firebase configuration in layouts/app.blade.php');
            console.error('   2. Firebase project settings');
            console.error('   3. Internet connection');
            console.error('   4. Browser console for more errors');
            console.error('❌ [RESTAURANT CONTROL] ========================================');
            return;
        }
        
        console.log('✅ [RESTAURANT CONTROL] ========================================');
        console.log('✅ [RESTAURANT CONTROL] FIRESTORE CONNECTION SUCCESSFUL');
        console.log('✅ [RESTAURANT CONTROL] ========================================');
        console.log('✅ [RESTAURANT CONTROL] Database instance: OK');
        database = db;
        refData = database.collection('vendors');
        console.log('✅ [RESTAURANT CONTROL] Vendors collection reference: OK');
        console.log('🔄 [RESTAURANT CONTROL] Setting up real-time listeners...');
        
        // Setup Real-time Listeners
        setupRealtimeListeners();
        
        console.log('🔄 [RESTAURANT CONTROL] Loading initial data...');
        // Load initial data
        loadCurrency();
        loadPlaceholderImage();
        loadDropdownsData();
        console.log('🔄 [RESTAURANT CONTROL] Initializing control table...');
        initializeControlTable();
        console.log('✅ [RESTAURANT CONTROL] All initialization steps completed');
    });
    
    // Real-time Listeners Setup
    function setupRealtimeListeners() {
        console.log('🔥 [REALTIME] Setting up Real-time listeners...');
        
        if (!database) return;
        
        // Vendors Listener
        if (vendorsListener) {
            vendorsListener();
        }
        
        vendorsListener = database.collection('vendors')
            .orderBy('createdAt', 'desc')
            .onSnapshot(function(querySnapshot) {
                console.log('🔥 [REALTIME] Vendors collection updated!');
                if ($.fn.DataTable.isDataTable('#storeTable')) {
                    $('#storeTable').DataTable().ajax.reload(null, false);
                }
                updateStatisticsRealtime();
            }, function(error) {
                console.error('❌ [REALTIME] Vendors listener error:', error);
                if (error.code === 'failed-precondition') {
                    if (vendorsListener) vendorsListener();
                    vendorsListener = database.collection('vendors')
                        .onSnapshot(function(querySnapshot) {
                            if ($.fn.DataTable.isDataTable('#storeTable')) {
                                $('#storeTable').DataTable().ajax.reload(null, false);
                            }
                            updateStatisticsRealtime();
                        });
                }
            });
        
        // Zones Listener
        if (zonesListener) zonesListener();
        zonesListener = database.collection('zone')
            .where('publish', '==', true)
            .orderBy('name', 'asc')
            .onSnapshot(function(querySnapshot) {
                $('.zone_selector').empty().append($("<option></option>").attr("value", "").text("{{ trans('lang.select_zone') }}"));
                querySnapshot.docs.forEach(function(doc) {
                    var data = doc.data();
                    $('.zone_selector').append($("<option></option>")
                        .attr("value", data.id)
                        .text(data.name));
                });
            });
        
        // Categories Listener
        if (categoriesListener) categoriesListener();
        categoriesListener = database.collection('vendor_categories')
            .where('publish', '==', true)
            .onSnapshot(function(querySnapshot) {
                $('.cuisine_selector').empty().append($("<option></option>").attr("value", "").text("{{ trans('lang.select_cuisines') }}"));
                querySnapshot.docs.forEach(function(doc) {
                    var data = doc.data();
                    $('.cuisine_selector').append($("<option></option>")
                        .attr("value", data.id)
                        .text(data.title));
                });
            });
        
        // Subscription Plans Listener
        if (subscriptionPlansListener) subscriptionPlansListener();
        subscriptionPlansListener = database.collection('subscription_plans')
            .where('isEnable', '==', true)
            .orderBy('name', 'asc')
            .onSnapshot(function(querySnapshot) {
                $('.business_model_selector').empty().append($("<option></option>").attr("value", "").text("{{ trans('lang.business_model') }}"));
                querySnapshot.docs.forEach(function(doc) {
                    var data = doc.data();
                    $('.business_model_selector').append($("<option></option>")
                        .attr("value", data.id)
                        .text(data.name));
                });
            }, function(error) {
                if (subscriptionPlansListener) subscriptionPlansListener();
                subscriptionPlansListener = database.collection('subscription_plans')
                    .where('isEnable', '==', true)
                    .onSnapshot(function(querySnapshot) {
                        $('.business_model_selector').empty().append($("<option></option>").attr("value", "").text("{{ trans('lang.business_model') }}"));
                        querySnapshot.docs.forEach(function(doc) {
                            var data = doc.data();
                            $('.business_model_selector').append($("<option></option>")
                                .attr("value", data.id)
                                .text(data.name));
                        });
                    });
            });
        
        console.log('✅ [REALTIME] All listeners set up successfully');
    }
    
    // Load Currency
    function loadCurrency() {
        if (!database) return;
        var refCurrency = database.collection('currencies').where('isActive', '==', true);
        refCurrency.get().then(async function(snapshots) {
            if (snapshots.docs.length > 0) {
                var currencyData = snapshots.docs[0].data();
                currentCurrency = '£'; // Force GBP
                currencyAtRight = currencyData.symbolAtRight || false;
                if (currencyData.decimal_degits) {
                    decimal_degits = currencyData.decimal_degits;
                }
            }
        }).catch(function(error) {
            console.warn('⚠️ Error loading currency:', error);
        });
    }
    
    // Load Placeholder Image
    function loadPlaceholderImage() {
        if (!database) return;
        var placeholder = database.collection('settings').doc('placeHolderImage');
        placeholder.get().then(async function(snapshotsimage) {
            if (snapshotsimage.exists) {
                var placeholderImageData = snapshotsimage.data();
                if (placeholderImageData && placeholderImageData.image) {
                    placeholderImage = placeholderImageData.image;
                }
            }
        }).catch(function(error) {
            console.warn('⚠️ Error loading placeholder image:', error);
        });
    }
    
    // Load Dropdowns Data
    function loadDropdownsData() {
        if (!database) return;
        
        // Zones
        database.collection('zone').where('publish', '==', true).orderBy('name', 'asc').get()
            .then(function(snapshots) {
                $('.zone_selector').empty().append($("<option></option>").attr("value", "").text("{{ trans('lang.select_zone') }}"));
                snapshots.docs.forEach(function(doc) {
                    var data = doc.data();
                    $('.zone_selector').append($("<option></option>")
                        .attr("value", data.id)
                        .text(data.name));
                });
            }).catch(function(error) {
                console.warn('⚠️ Error loading zones:', error);
            });
        
        // Categories
        database.collection('vendor_categories').where('publish', '==', true).get()
            .then(function(snapshots) {
                $('.cuisine_selector').empty().append($("<option></option>").attr("value", "").text("{{ trans('lang.select_cuisines') }}"));
                snapshots.docs.forEach(function(doc) {
                    var data = doc.data();
                    $('.cuisine_selector').append($("<option></option>")
                        .attr("value", data.id)
                        .text(data.title));
                });
            }).catch(function(error) {
                console.warn('⚠️ Error loading categories:', error);
            });
        
        // Subscription Plans
        database.collection('subscription_plans').where('isEnable', '==', true).orderBy('name', 'asc').get()
            .then(function(snapshots) {
                $('.business_model_selector').empty().append($("<option></option>").attr("value", "").text("{{ trans('lang.business_model') }}"));
                snapshots.docs.forEach(function(doc) {
                    var data = doc.data();
                    $('.business_model_selector').append($("<option></option>")
                        .attr("value", data.id)
                        .text(data.name));
                });
            }).catch(function(error) {
                console.warn('⚠️ Error loading subscription plans:', error);
            });
    }
    
    // Initialize Control Table - Same as restaurants/index.blade.php
    function initializeControlTable() {
        console.log('📊 [CONTROL TABLE] ========================================');
        console.log('📊 [CONTROL TABLE] Initializing Restaurant Control DataTable');
        console.log('📊 [CONTROL TABLE] ========================================');
        
        if (!database) {
            console.error('❌ [CONTROL TABLE] Database not available');
            console.error('❌ [CONTROL TABLE] Firestore connection failed');
            console.error('❌ [CONTROL TABLE] Please refresh the page');
            return;
        }
        
        console.log('✅ [CONTROL TABLE] Database connection: OK');
        console.log('✅ [CONTROL TABLE] Reference data:', refData ? 'OK' : 'NULL');
        
        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#storeTable')) {
            console.log('⚠️ [CONTROL TABLE] DataTable already initialized, destroying existing instance...');
            $('#storeTable').DataTable().destroy();
            $('#storeTable').empty();
        }
        
        console.log('📊 [CONTROL TABLE] Initializing DataTable...');
        
        var fieldConfig = {
            columns: [{
                    key: 'title',
                    header: "{{ trans('lang.restaurant_info') }}"
                },
                {
                    key: 'authorName',
                    header: "{{ trans('lang.owner_info') }}"
                },
                {
                    key: 'createdAt',
                    header: "{{ trans('lang.date') }}"
                },
            ],
            fileName: "{{ trans('lang.restaurant_table') }}",
        };
        
        const table = $('#storeTable').DataTable({
            pageLength: 10,
            processing: false,
            serverSide: true,
            responsive: true,
            ajax: function(data, callback, settings) {
                const start = data.start;
                const length = data.length;
                const searchValue = data.search.value.toLowerCase();
                const orderColumnIndex = data.order[0].column;
                const orderDirection = data.order[0].dir;
                const orderableColumns = (checkDeletePermission) ? ['', 'title', 'authorName', 'createdAt', '', ''] : ['title', 'authorName', 'createdAt', '', ''];
                const orderByField = orderableColumns[orderColumnIndex];
                
                if (searchValue.length >= 3 || searchValue.length === 0) {
                    $('#data-table_processing').show();
                }
                
                var queryPromise = refData.orderBy('createdAt', 'desc').get().catch(function(error) {
                    if (error.code === 'failed-precondition') {
                        return refData.get();
                    }
                    throw error;
                });
                
                queryPromise.then(async function(querySnapshot) {
                    console.log('📊 [CONTROL TABLE] ========================================');
                    console.log('📊 [CONTROL TABLE] Query completed');
                    console.log('📊 [CONTROL TABLE] Query snapshot empty:', querySnapshot.empty);
                    console.log('📊 [CONTROL TABLE] Query snapshot size:', querySnapshot.size);
                    console.log('📊 [CONTROL TABLE] ========================================');
                    
                    if (querySnapshot.empty) {
                        console.warn('⚠️ [CONTROL TABLE] No restaurants found in Firestore!');
                        console.warn('⚠️ [CONTROL TABLE] Collection: vendors');
                        console.warn('⚠️ [CONTROL TABLE] Possible causes:');
                        console.warn('   1. No data in Firestore vendors collection');
                        console.warn('   2. Permission denied (check Firestore rules)');
                        console.warn('   3. Missing index (check Firestore indexes)');
                        console.warn('   4. Network error');
                        $('.rest_count').text(0);
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
                    
                    console.log('✅ [CONTROL TABLE] Found ' + querySnapshot.size + ' restaurants in Firestore');
                    
                    let records = [];
                    let filteredRecords = [];
                    let processedCount = 0;
                    
                    querySnapshot.forEach(function(doc) {
                        processedCount++;
                        let childData = doc.data();
                        childData.id = doc.id;
                        childData.phone = (childData.phonenumber != '' && childData.phonenumber != null && childData.phonenumber.slice(0, 1) == '+') ? childData.phonenumber.slice(1) : childData.phonenumber;
                        childData.phonenumber = shortEditNumber(childData.phonenumber);
                        
                        if (processedCount <= 5) {
                            console.log('📋 [CONTROL TABLE] Restaurant #' + processedCount + ':');
                            console.log('   ID:', childData.id);
                            console.log('   Title:', childData.title || 'N/A');
                            console.log('   Author:', childData.author || 'N/A');
                            console.log('   CreatedAt:', childData.createdAt ? 'Yes' : 'No');
                        }
                        
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
                    
                    console.log('📊 [CONTROL TABLE] Total processed:', processedCount);
                    console.log('📊 [CONTROL TABLE] After filtering:', filteredRecords.length);
                    
                    filteredRecords.sort((a, b) => {
                        let aValue = a[orderByField] ? a[orderByField].toString().toLowerCase() : '';
                        let bValue = b[orderByField] ? b[orderByField].toString().toLowerCase() : '';
                        if (orderByField === 'createdAt') {
                            try {
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
                    
                    $('.rest_count').text(totalRecords);
                    $('.rest_active_count').text(active_rest);
                    $('.rest_inactive_count').text(inactive_rest);
                    $('.new_joined_rest').text(new_joined_rest);
                    
                    const paginatedRecords = filteredRecords.slice(start, start + length);
                    console.log('📊 [CONTROL TABLE] Pagination: start=' + start + ', length=' + length + ', paginated=' + paginatedRecords.length);
                    
                    await Promise.all(paginatedRecords.map(async (childData) => {
                        var getData = await buildHTML(childData);
                        if (getData && getData.length > 0) {
                            records.push(getData);
                        }
                    }));
                    
                    console.log('📊 [CONTROL TABLE] Records built for DataTable:', records.length);
                    console.log('📊 [CONTROL TABLE] Total records:', totalRecords);
                    console.log('📊 [CONTROL TABLE] Active restaurants:', active_rest);
                    console.log('📊 [CONTROL TABLE] Inactive restaurants:', inactive_rest);
                    console.log('📊 [CONTROL TABLE] Newly joined restaurants:', new_joined_rest);
                    console.log('✅ [CONTROL TABLE] Data ready for display');
                    
                    $('#data-table_processing').hide();
                    callback({
                        draw: data.draw,
                        recordsTotal: totalRecords,
                        recordsFiltered: totalRecords,
                        filteredData: filteredRecords,
                        data: records
                    });
                }).catch(function(error) {
                    console.error('❌ [CONTROL TABLE] ========================================');
                    console.error('❌ [CONTROL TABLE] ERROR FETCHING DATA FROM FIRESTORE');
                    console.error('❌ [CONTROL TABLE] ========================================');
                    console.error('❌ [CONTROL TABLE] Error code:', error.code || 'N/A');
                    console.error('❌ [CONTROL TABLE] Error message:', error.message || 'N/A');
                    console.error('❌ [CONTROL TABLE] Error name:', error.name || 'N/A');
                    console.error('❌ [CONTROL TABLE] ========================================');
                    console.error('❌ [CONTROL TABLE] Possible solutions:');
                    if (error.code === 'failed-precondition') {
                        console.error('   1. Missing Firestore index for: vendors collection, orderBy createdAt DESC');
                        console.error('   2. Go to Firebase Console > Firestore > Indexes');
                        console.error('   3. Create the required index or wait for it to build');
                    } else if (error.code === 'permission-denied') {
                        console.error('   1. Permission denied - Check Firestore Security Rules');
                        console.error('   2. Update rules to allow read access to vendors collection');
                        console.error('   3. Deploy rules: firebase deploy --only firestore:rules');
                    } else if (error.code === 'unavailable') {
                        console.error('   1. Firestore service unavailable');
                        console.error('   2. Check internet connection');
                        console.error('   3. Check Firebase project status');
                    } else {
                        console.error('   1. Check browser console for more details');
                        console.error('   2. Verify Firestore connection');
                        console.error('   3. Check Firebase project configuration');
                    }
                    console.error('❌ [CONTROL TABLE] ========================================');
                    $('#data-table_processing').hide();
                    callback({
                        draw: data.draw,
                        recordsTotal: 0,
                        recordsFiltered: 0,
                        filteredData: [],
                        data: []
                    });
                });
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
                console.log('✅ [CONTROL TABLE] DataTable initialization complete');
                console.log('✅ [CONTROL TABLE] Table is ready to display data');
                $('#data-table_processing').hide();
                $(".dataTables_filter").append($(".dt-buttons").detach());
                $('.dataTables_filter input').attr('placeholder', 'Search here...').attr('autocomplete', 'new-password').val('');
                $('.dataTables_filter label').contents().filter(function() {
                    return this.nodeType === 3;
                }).remove();
            }
        });
        
        console.log('✅ [CONTROL TABLE] DataTable initialized successfully');
        console.log('📊 [CONTROL TABLE] Waiting for data from Firestore...');
    }
    
    // Build HTML - Same as restaurants/index.blade.php
    async function buildHTML(val) {
        if (!val || !val.id) {
            console.warn('⚠️ [BUILD HTML] Invalid data: missing id');
            return [];
        }
        
        var id = val.id;
        var vendorUserId = val.author;
        console.log('🔨 [BUILD HTML] Building row for restaurant ID:', id);
        
        // Get author name
        if (!val.authorName || val.authorName.trim() === '') {
            if (vendorUserId && vendorUserId.trim() !== '') {
                try {
                    const userDoc = await database.collection('users').doc(vendorUserId).get();
                    if (userDoc.exists) {
                        const userData = userDoc.data();
                        val.authorName = (userData.firstName || '') + ' ' + (userData.lastName || '');
                    } else {
                        val.authorName = val.authorName || 'N/A';
                    }
                } catch (err) {
                    val.authorName = val.authorName || 'N/A';
                }
            } else {
                val.authorName = val.authorName || 'N/A';
            }
        }
        
        var route1 = '{{ route('restaurants.edit.new', ':id') }}';
        route1 = route1.replace(':id', id);
        var route_view = '{{ route('restaurants.view', ':id') }}';
        route_view = route_view.replace(':id', id);
        
        var html = [];
        
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
        
        var vendorId = val.id;
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
        actionHtml += '<div class="dropdown" style="display: inline-block;"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" vendor_id="' + val.id + '" approval_status="' + currentStatus + '" name="vendor-status-dropdown" title="Change Status"><i class="mdi ' + statusIcon + '" style="color: ' + statusColor + '; font-size: 18px;"></i></a><ul class="dropdown-menu status-dropdown-menu" role="menu"><li><a href="javascript:void(0)" class="status-option-vendor" data-status="waiting" data-vendor-id="' + val.id + '"><i class="mdi mdi-clock-outline" style="color: #ffc107;"></i> Waiting</a></li><li><a href="javascript:void(0)" class="status-option-vendor" data-status="rejected" data-vendor-id="' + val.id + '"><i class="mdi mdi-close-circle" style="color: #dc3545;"></i> Rejected</a></li><li><a href="javascript:void(0)" class="status-option-vendor" data-status="approved" data-vendor-id="' + val.id + '"><i class="mdi mdi-check-circle" style="color: #2c9653;"></i> Approved</a></li></ul></div>';
        if (checkDeletePermission) {
            actionHtml += '<a id="' + val.id + '" author="' + (val.author || '') + '" name="vendor-delete" class="delete-btn" href="javascript:void(0)" title="Delete"><i class="mdi mdi-delete"></i></a>';
        }
        actionHtml += '</span>';
        html.push(actionHtml);
        
        console.log('✅ [BUILD HTML] Row built successfully for:', val.title || 'UNKNOWN', '| Columns:', html.length);
        return html;
    }
    
    async function vendorStatus(id) {
        if (!database || !id) return false;
        try {
            const userDoc = await database.collection('users').doc(id).get();
            if (userDoc.exists) {
                const userData = userDoc.data();
                return userData.active || false;
            }
        } catch (error) {
            console.error('❌ Error checking vendor status:', error);
        }
        return false;
    }
    
    // Update Statistics Real-time
    async function updateStatisticsRealtime() {
        if (!database) return;
        try {
            var vendorsSnapshot = await database.collection('vendors').get();
            var totalRecords = vendorsSnapshot.size;
            var active_rest = 0;
            var inactive_rest = 0;
            var new_joined_rest = 0;
            const today = new Date().setHours(0, 0, 0, 0);
            
            await Promise.all(vendorsSnapshot.docs.map(async function(doc) {
                var childData = doc.data();
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
            
            $('.rest_count').text(totalRecords);
            $('.rest_active_count').text(active_rest);
            $('.rest_inactive_count').text(inactive_rest);
            $('.new_joined_rest').text(new_joined_rest);
        } catch (error) {
            console.error('❌ Error updating statistics:', error);
        }
    }
    
    // Helper functions
    function shortEditNumber(number) {
        if (number && number.length > 4) {
            return number.slice(0, 4) + '*******';
        }
        return number || '';
    }
    
    // Delete handlers - Same as restaurants/index.blade.php
    $("#is_active").click(function() {
        $("#storeTable .is_open").prop('checked', $(this).prop('checked'));
    });
    
    $("#deleteAll").click(function() {
        if ($('#storeTable .is_open:checked').length) {
            if (confirm("{{ trans('lang.selected_delete_alert') }}")) {
                jQuery("#data-table_processing").show();
                $('#storeTable .is_open:checked').each(async function() {
                    var dataId = $(this).attr('dataId');
                    var author = $(this).attr('author');
                    if (database) {
                        try {
                            await database.collection('vendors').doc(dataId).delete();
                            if (author) {
                                await database.collection('users').doc(author).update({
                                    vendorID: ''
                                });
                            }
                        } catch (error) {
                            console.error('❌ Error deleting:', error);
                        }
                    }
                });
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            }
        } else {
            alert("{{ trans('lang.select_delete_alert') }}");
        }
    });
    
    $(document).on("click", "a[name='vendor-delete']", async function(e) {
        var id = this.id;
        var authorId = $(this).attr('author');
        
        if (!confirm("{{ trans('lang.selected_delete_alert') }}")) {
            return;
        }
        
        jQuery("#data-table_processing").show();
        
        try {
            if (database) {
                await database.collection('vendors').doc(id).delete();
                if (authorId) {
                    await database.collection('users').doc(authorId).update({
                        vendorID: ''
                    });
                }
            }
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        } catch (error) {
            console.error('❌ Error deleting restaurant:', error);
            jQuery("#data-table_processing").hide();
        }
    });
    
    // Filter Change Handlers
    $('select').on('change', function() {
        if (!database) return;
        
        refData = database.collection('vendors');
        
        var zoneValue = $('.zone_selector').val();
        var restaurantTypeValue = $('.restaurant_type_selector').val();
        var businessModelValue = $('.business_model_selector').val();
        var cuisineValue = $('.cuisine_selector').val();
        
        if (zoneValue) {
            refData = refData.where('zoneId', '==', zoneValue);
        }
        if (restaurantTypeValue == "true") {
            refData = refData.where('enabledDiveInFuture', '==', true);
        }
        if (cuisineValue) {
            refData = refData.where('categoryID', '==', cuisineValue);
        }
        
        if ($.fn.DataTable.isDataTable('#storeTable')) {
            $('#storeTable').DataTable().ajax.reload();
        }
    });
    
    // Status Change Handler for Restaurants - Dropdown
    $(document).off("click", ".status-option-vendor[data-vendor-id]").on("click", ".status-option-vendor[data-vendor-id]", async function(e) {
        e.preventDefault();
        e.stopPropagation();
        var vendorId = $(this).attr('data-vendor-id');
        var newStatus = $(this).attr('data-status');
        var $dropdown = $(this).closest('.dropdown');
        var $toggle = $dropdown.find('.dropdown-toggle');
        var currentStatus = $toggle.attr('approval_status') || 'waiting';
        var $row = $(this).closest('tr');
        
        var statusLabels = {
            'waiting': 'Waiting',
            'rejected': 'Rejected',
            'approved': 'Approved'
        };
        
        if (currentStatus === newStatus) {
            $('.dropdown-menu').removeClass('show');
            return;
        }
        
        // Use SweetAlert2 for confirmation
        const result = await Swal.fire({
            title: 'Change Status?',
            text: 'Change status to ' + statusLabels[newStatus] + '?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2c9653',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel',
            allowOutsideClick: false
        });
        
        if (!result.isConfirmed) {
            $('.dropdown-menu').removeClass('show');
            return;
        }
        
        jQuery("#data-table_processing").show();
        $('.dropdown-menu').removeClass('show');
        
        try {
            if (database) {
                // Try using set with merge first, then update
                try {
                    await database.collection('vendors').doc(vendorId).set({
                        'approvalStatus': newStatus
                    }, { merge: true });
                } catch (setError) {
                    // If set fails, try update
                    await database.collection('vendors').doc(vendorId).update({
                        'approvalStatus': newStatus
                    });
                }
                
                // Update UI immediately without reload
                updateVendorStatusIconInTable($row, newStatus);
                
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Status Updated!',
                    text: 'Status changed to ' + statusLabels[newStatus],
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                
                // Reload table data in background
                if ($.fn.DataTable.isDataTable('#storeTable')) {
                    setTimeout(function() {
                        $('#storeTable').DataTable().ajax.reload(null, false);
                    }, 500);
                }
            } else {
                throw new Error('Database not available');
            }
        } catch (error) {
            console.error('❌ Error changing status:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: error.code === 'permission-denied' 
                    ? 'Permission denied. Please check Firestore Rules.' 
                    : 'Error: ' + error.message,
                confirmButtonColor: '#2c9653'
            });
        } finally {
            jQuery("#data-table_processing").hide();
        }
    });
    
    // Function to update vendor status icon immediately in DataTable
    function updateVendorStatusIconInTable($row, newStatus) {
        var statusIcon = '';
        var statusColor = '#2c9653';
        if (newStatus === 'approved') {
            statusIcon = 'mdi-check-circle';
            statusColor = '#2c9653';
        } else if (newStatus === 'rejected') {
            statusIcon = 'mdi-close-circle';
            statusColor = '#dc3545';
        } else {
            statusIcon = 'mdi-clock-outline';
            statusColor = '#ffc107';
        }
        
        var $dropdown = $row.find('.dropdown');
        var $toggle = $dropdown.find('.dropdown-toggle');
        var $icon = $toggle.find('i.mdi');
        $icon.removeClass('mdi-check-circle mdi-close-circle mdi-clock-outline')
             .addClass(statusIcon)
             .css('color', statusColor);
        $toggle.attr('approval_status', newStatus);
    }
    
    // Initialize Bootstrap dropdowns
    $(document).on('click', '.dropdown-toggle', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).next('.dropdown-menu').toggleClass('show');
    });
    
    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-menu').removeClass('show');
        }
    });
    
    // Cleanup on page unload
    $(window).on('beforeunload', function() {
        if (vendorsListener) vendorsListener();
        if (zonesListener) zonesListener();
        if (categoriesListener) categoriesListener();
        if (subscriptionPlansListener) subscriptionPlansListener();
    });
    
    console.log('✅ [RESTAURANT CONTROL] Page initialized successfully');
</script>
@endsection

@section('styles')
<style>
    .status-dropdown-menu {
        min-width: 180px;
        padding: 5px 0;
        margin: 2px 0 0;
        background-color: #fff;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 4px;
        box-shadow: 0 6px 12px rgba(0,0,0,.175);
        z-index: 1000;
    }
    
    .status-dropdown-menu li {
        list-style: none;
    }
    
    .status-dropdown-menu li a {
        display: block;
        padding: 8px 20px;
        clear: both;
        font-weight: normal;
        line-height: 1.42857143;
        color: #333;
        white-space: nowrap;
        text-decoration: none;
    }
    
    .status-dropdown-menu li a:hover {
        background-color: #f5f5f5;
        color: #2c9653;
    }
    
    .status-dropdown-menu li a .mdi {
        margin-right: 8px;
        font-size: 18px;
        vertical-align: middle;
    }
    
    .dropdown {
        position: relative;
        display: inline-block;
    }
    
    .dropdown-toggle {
        cursor: pointer;
    }
    
    .dropdown-menu.show {
        display: block;
    }
</style>
@endsection
