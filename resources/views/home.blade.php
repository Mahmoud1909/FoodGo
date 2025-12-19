@extends('layouts.app')
@section('content')
<div id="main-wrapper" class="page-wrapper" style="min-height: 207px;">
    <div class="container-fluid">
        <div class="card mb-3 business-analytics">  
            <div class="card-body">
                <div class="row flex-between align-items-center g-2 mb-3 order_stats_header">
                    <div class="col-sm-6">
                        <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                            {{trans('lang.dashboard_business_analytics')}}</h4>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-md-3">
                        <div class="card card-box-with-icon bg--8" onclick="location.href='{!! route('payments') !!}'">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="card-box-with-content">
                                    <h4 class="text-dark-2 mb-1 h4 earnings_count" id="earnings_count"></h4>
                                    <p class="mb-0 small text-dark-2">{{trans('lang.dashboard_total_earnings')}}</p>
                                </div>
                                <span class="box-icon ab"><img src="{{ asset('images/total_earning.png') }}"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-box-with-icon bg--1" onclick="location.href='{!! route('restaurants.control') !!}'">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="card-box-with-content">
                                    <h4 class="text-dark-2 mb-1 h4 vendor_count" id="vendor_count"></h4>
                                    <p class="mb-0 small text-dark-2">{{trans('lang.dashboard_total_restaurants')}}</p>
                                </div>
                                <span class="box-icon ab"><img src="{{ asset('images/restaurant_icon.png') }}"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-box-with-icon bg--5" onclick="location.href='{!! route('orders') !!}'">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="card-box-with-content">
                                    <h4 class="text-dark-2 mb-1 h4" id="order_count"></h4>
                                    <p class="mb-0 small text-dark-2">{{trans('lang.dashboard_total_orders')}}</p>
                                </div>
                                <span class="box-icon ab"><img src="{{ asset('images/active_restaurant.png') }}"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-box-with-icon bg--24" onclick="location.href='{!! route('foods') !!}'">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="card-box-with-content">
                                    <h4 class="text-dark-2 mb-1 h4" id="product_count"></h4>
                                    <p class="mb-0 small text-dark-2">{{trans('lang.dashboard_total_products')}}</p>
                                </div>
                                <span class="box-icon ab"><img src="{{ asset('images/inactive_restaurant.png') }}"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-box-with-icon bg--14" onclick="location.href='{!! route('payments') !!}'">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="card-box-with-content">
                                    <h4 class="text-dark-2 mb-1 h4" id="admincommission_count"></h4>
                                    <p class="mb-0 small text-dark-2">{{trans('lang.admin_commission')}}</p>
                                </div>
                                <span class="box-icon ab"><img src="{{ asset('images/price.png') }}"></span>
                            </div>
                        </div>
                    </div>    
                    <div class="col-md-3">
                        <div class="card card-box-with-icon bg--6" onclick="location.href='{!! route('users') !!}'">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="card-box-with-content">
                                    <h4 class="text-dark-2 mb-1 h4" id="users_count"></h4>
                                    <p class="mb-0 small text-dark-2">{{trans('lang.dashboard_total_clients')}}</p>
                                </div>
                                <span class="box-icon ab"><img src="{{ asset('images/new_restaurant.png') }}"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-box-with-icon bg--15" onclick="location.href='{!! route('drivers') !!}'">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="card-box-with-content">
                                    <h4 class="text-dark-2 mb-1 h4" id="driver_count"></h4>
                                    <p class="mb-0 small text-dark-2">{{trans('lang.dashboard_total_drivers')}}</p>
                                </div>
                                <span class="box-icon ab"><img src="{{ asset('images/total_order.png') }}"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row business-analytics_list">
                    <div class="col-sm-6 col-lg-3">
                        <a class="order-status pending" href="{{ route('orders','status=order-placed') }}">
                            <div class="data">
                                <i class="mdi mdi-lan-pending"></i>
                                <h6 class="status">{{trans('lang.dashboard_order_placed')}}</h6>
                            </div>
                            <span class="count" id="placed_count"></span> </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a class="order-status confirmed"  href="{!! route('orders','status=order-confirmed') !!}">
                            <div class="data">
                                <i class="mdi mdi-check-circle"></i>
                                <h6 class="status">{{trans('lang.dashboard_order_confirmed')}}</h6>
                            </div>
                            <span class="count" id="confirmed_count"></span> </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a class="order-status packaging"  href="{!! route('orders','status=order-shipped') !!}">
                            <div class="data">
                                <i class="mdi mdi-clipboard-outline"></i>
                                <h6 class="status">{{trans('lang.dashboard_order_shipped')}}</h6>
                            </div>
                            <span class="count" id="shipped_count"></span> </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a class="order-status delivered" href="{!! route('orders','status=order-completed') !!}">
                            <div class="data">
                                <i class="mdi mdi-check-circle-outline"></i>
                                <h6 class="status">{{trans('lang.dashboard_order_completed')}}</h6>
                            </div>
                            <span class="count" id="completed_count"></span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a class="order-status canceled" href="{!! route('orders','status=order-canceled') !!}">
                            <div class="data">
                                <i class="mdi mdi-window-close"></i>
                                <h6 class="status">{{trans('lang.dashboard_order_canceled')}}</h6>
                            </div>
                            <span class="count" id="canceled_count"></span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a class="order-status failed" href="{!! route('orders','status=order-failed') !!}">
                            <div class="data">
                                <i class="mdi mdi-alert-circle-outline"></i>
                                <h6 class="status">{{trans('lang.dashboard_order_failed')}}</h6>
                            </div>
                            <span class="count" id="failed_count"></span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a class="order-status failed" href="{!! route('orders','status=order-pending') !!}">
                            <div class="data">
                                <i class="mdi mdi-car-connected"></i>
                                <h6 class="status">{{trans('lang.dashboard_order_pending')}}</h6>
                            </div>
                            <span class="count" id="pending_count"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header no-border">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">{{trans('lang.total_sales')}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative">
                            <canvas id="sales-chart" height="200"></canvas>
                        </div>
                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2"> <i class="fa fa-square" style="color:#2EC7D9"></i> {{trans('lang.dashboard_this_year')}} </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header no-border">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">{{trans('lang.service_overview')}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="flex-row">
                            <canvas id="visitors" height="222"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header no-border">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">{{trans('lang.sales_overview')}}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="flex-row">
                            <canvas id="commissions" height="222"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row daes-sec-sec mb-3">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header no-border d-flex justify-content-between">
                        <h3 class="card-title">{{trans('lang.restaurant_plural')}}</h3>
                        <div class="card-tools">
                            <a href="{{route('restaurants.control')}}" class="btn btn-tool btn-sm"><i class="fa fa-bars"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                       <div class="table-responsive px-3"> 
                        <table class="table table-striped table-valign-middle" id="restaurantTable">
                            <thead>
                            <tr>
                                <th style="text-align:center">{{trans('lang.restaurant_image')}}</th>
                                <th>{{trans('lang.restaurant')}}</th>
                                <th>{{trans('lang.restaurant_review_review')}}</th>
                                <th>{{trans('lang.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody id="append_list">
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header no-border d-flex justify-content-between">
                        <h3 class="card-title">{{trans('lang.top_drivers')}}</h3>
                        <div class="card-tools">
                            <a href="{{route('drivers')}}" class="btn btn-tool btn-sm"><i class="fa fa-bars"></i> </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                      <div class="table-responsive px-3">  
                        <table class="table table-striped table-valign-middle" id="driverTable">
                            <thead>
                            <tr>
                                <th style="text-align:center">{{trans('lang.restaurant_image')}}</th>
                                <th>{{trans('lang.driver')}}</th>
                                <th>{{trans('lang.order_completed')}}</th>
                                <th>{{trans('lang.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody id="append_list_top_drivers">
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row daes-sec-sec">
        <div class="col-lg-6">
                <div class="card">
                    <div class="card-header no-border d-flex justify-content-between">
                        <h3 class="card-title">{{trans('lang.recent_orders')}}</h3>
                        <div class="card-tools">
                            <a href="{{route('orders')}}" class="btn btn-tool btn-sm"><i class="fa fa-bars"></i> </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                       <div class="table-responsive px-3"> 
                        <table class="table table-striped table-valign-middle" id="orderTable">
                            <thead>
                            <tr>
                                <th style="text-align:center">{{trans('lang.order_id')}}</th>
                                <th>{{trans('lang.restaurant')}}</th>
                                <th>{{trans('lang.total_amount')}}</th>
                                <th>{{trans('lang.quantity')}}</th>
                            </tr>
                            </thead>
                            <tbody id="append_list_recent_order">
                            </tbody>
                        </table>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header no-border d-flex justify-content-between">
                        <h3 class="card-title">{{trans('lang.recent_payouts')}}</h3>
                        <div class="card-tools">
                            <a href="{{route('payoutRequests.restaurants')}}" class="btn btn-tool btn-sm"><i class="fa fa-bars"></i> </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                      <div class="table-responsive px-3">  
                        <table class="table table-striped table-valign-middle" id="recentPayoutsTable">
                            <thead>
                            <tr>
                                <th>{{ trans('lang.restaurant')}}</th>
                                <th>{{trans('lang.paid_amount')}}</th>
                                <th>{{trans('lang.date')}}</th>
                                <th>{{trans('lang.restaurants_payout_note')}}</th>
                            </tr>
                            </thead>
                            <tbody id="append_list_recent_payouts">
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>
@endsection
@section('scripts')
<script src="{{asset('js/chart.js')}}"></script>
<script>
    // Global variables for dashboard
    var db = null;
    var currentCurrency = '';
    var currencyAtRight = false;
    var decimal_degits = 0;
    var placeholderImage = '';
    
    // Wait for Firestore to be initialized
    function initDashboard() {
        if (!database) {
            console.warn('⚠️ Firestore not ready yet, retrying...');
            setTimeout(initDashboard, 500);
            return;
        }
        
        jQuery("#data-table_processing").show();
        db = database; // Use the global database variable from app.blade.php
        
        // Load currency first (needed for other calculations)
        var refCurrency = database.collection('currencies').where('isActive', '==', true);
        refCurrency.get().then(async function (snapshots) {
            if (snapshots.docs.length > 0) {
                var currencyData = snapshots.docs[0].data();
                currentCurrency = '£'; // Force GBP
                currencyAtRight = currencyData.symbolAtRight || false;
                if (currencyData.decimal_degits) {
                    decimal_degits = currencyData.decimal_degits;
                }
            } else {
                // Default values if no currency found
                currentCurrency = '£'; // Force GBP
                currencyAtRight = false;
                decimal_degits = 2;
            }
            
            // After currency is loaded, load all dashboard data in parallel
            loadDashboardData();
        }).catch(function(error) {
            console.warn('Error loading currency settings:', error);
            // Default values on error
            currentCurrency = '£'; // Force GBP
            currencyAtRight = false;
            decimal_degits = 2;
            // Still load dashboard data even if currency fails
            loadDashboardData();
        });
    }
    
    // Load all dashboard data in parallel for better performance
    function loadDashboardData() {
        if (!db) {
            console.error('Database not available');
            return;
        }
        
        // Load all counts in parallel
        Promise.all([
            // Total Orders
            db.collection('restaurant_orders').get().then(
                (snapshot) => {
                    jQuery("#order_count").empty();
                    jQuery("#order_count").text(snapshot.docs.length);
                    console.log('✅ Orders loaded:', snapshot.docs.length);
                }).catch(function(error) {
                    console.error('❌ Error loading order count:', error);
                    if (error.code === 'permission-denied') {
                        console.error('❌ PERMISSION DENIED! Please update Firestore Rules');
                    }
                    jQuery("#order_count").text('0');
                }),
            // Total Products
            db.collection('vendor_products').get().then(
                (snapshot) => {
                    jQuery("#product_count").empty();
                    jQuery("#product_count").text(snapshot.docs.length);
                    console.log('✅ Products loaded:', snapshot.docs.length);
                }).catch(function(error) {
                    console.error('❌ Error loading product count:', error);
                    if (error.code === 'permission-denied') {
                        console.error('❌ PERMISSION DENIED! Please update Firestore Rules');
                    }
                    jQuery("#product_count").text('0');
                }),
            // Total Users
            db.collection('users').where("role", "==", "customer").get().then((snapshot) => {
                jQuery("#users_count").empty();
                jQuery("#users_count").text(snapshot.docs.length);
                console.log('✅ Users loaded:', snapshot.docs.length);
            }).catch(function(error) {
                console.error('❌ Error loading users count:', error);
                if (error.code === 'permission-denied') {
                    console.error('❌ PERMISSION DENIED! Please update Firestore Rules');
                } else if (error.code === 'failed-precondition') {
                    console.error('❌ INDEX REQUIRED! Please create index in Firebase Console');
                    console.error('❌ Collection: users, Fields: role (Ascending)');
                }
                jQuery("#users_count").text('0');
            }),
            // Total Drivers
            db.collection('users').where("role", "==", "driver").get().then((snapshot) => {
                jQuery("#driver_count").empty();
                jQuery("#driver_count").text(snapshot.docs.length);
                console.log('✅ Drivers loaded:', snapshot.docs.length);
            }).catch(function(error) {
                console.error('❌ Error loading drivers count:', error);
                if (error.code === 'permission-denied') {
                    console.error('❌ PERMISSION DENIED! Please update Firestore Rules');
                } else if (error.code === 'failed-precondition') {
                    console.error('❌ INDEX REQUIRED! Please create index in Firebase Console');
                    console.error('❌ Collection: users, Fields: role (Ascending)');
                }
                jQuery("#driver_count").text('0');
            }),
            // Total Restaurants
            db.collection('vendors').where('title','!=',"").get().then(
                (snapshot) => {
                    jQuery("#vendor_count").empty();
                    jQuery("#vendor_count").text(snapshot.docs.length);
                    console.log('✅ Vendors loaded:', snapshot.docs.length);
                    setVisitors();
                }).catch(function(error) {
                    console.error('❌ Error loading vendors count:', error);
                    if (error.code === 'permission-denied') {
                        console.error('❌ PERMISSION DENIED! Please update Firestore Rules');
                    } else if (error.code === 'failed-precondition') {
                        console.error('❌ INDEX REQUIRED! Please create index in Firebase Console');
                        console.error('❌ Collection: vendors, Fields: title (Ascending)');
                        // Fallback: try without where clause
                        db.collection('vendors').get().then((snapshot) => {
                            var count = 0;
                            snapshot.docs.forEach(function(doc) {
                                var data = doc.data();
                                if (data.title && data.title !== '') count++;
                            });
                            jQuery("#vendor_count").text(count);
                            console.log('✅ Vendors loaded (fallback):', count);
                        });
                    }
                    jQuery("#vendor_count").text('0');
                })
        ]).then(() => {
            // After counts are loaded, load order status counts
            loadOrderStatusCounts();
        });
        
        // Load placeholder image
        var placeholder = db.collection('settings').doc('placeHolderImage');
        placeholder.get().then(async function (snapshotsimage) {
            if (snapshotsimage.exists) {
                var placeholderImageData = snapshotsimage.data();
                if (placeholderImageData && placeholderImageData.image) {
                    placeholderImage = placeholderImageData.image;
                }
            }
        }).catch(function(error) {
            console.warn('Error loading placeholder image:', error);
        });
        
        // Load earnings (this takes longer, so load it separately)
        getTotalEarnings();
        
        // Load tables data
        loadRestaurantsTable();
        loadTopDriversTable();
        loadRecentOrdersTable();
        loadRecentPayoutsTable();
    }
    
    // Load order status counts in parallel
    function loadOrderStatusCounts() {
        if (!db) return;
        
        Promise.all([
            // Order Placed
            db.collection('restaurant_orders').where('status', 'in', ["Order Placed"]).get().then(
                (snapshot) => {
                    jQuery("#placed_count").empty();
                    jQuery("#placed_count").text(snapshot.docs.length);
                }).catch(function(error) {
                    console.warn('Error loading placed orders:', error);
                    jQuery("#placed_count").text('0');
                }),
            // Order Confirmed
            db.collection('restaurant_orders').where('status', 'in', ["Order Accepted", "Driver Accepted"]).get().then(
                (snapshot) => {
                    jQuery("#confirmed_count").empty();
                    jQuery("#confirmed_count").text(snapshot.docs.length);
                }).catch(function(error) {
                    console.warn('Error loading confirmed orders:', error);
                    jQuery("#confirmed_count").text('0');
                }),
            // Order Shipped
            db.collection('restaurant_orders').where('status', 'in', ["Order Shipped", "In Transit"]).get().then(
                (snapshot) => {
                    jQuery("#shipped_count").empty();
                    jQuery("#shipped_count").text(snapshot.docs.length);
                }).catch(function(error) {
                    console.warn('Error loading shipped orders:', error);
                    jQuery("#shipped_count").text('0');
                }),
            // Order Completed
            db.collection('restaurant_orders').where('status', 'in', ["Order Completed"]).get().then(
                (snapshot) => {
                    jQuery("#completed_count").empty();
                    jQuery("#completed_count").text(snapshot.docs.length);
                }).catch(function(error) {
                    console.warn('Error loading completed orders:', error);
                    jQuery("#completed_count").text('0');
                }),
            // Order Canceled
            db.collection('restaurant_orders').where('status', 'in', ["Order Rejected"]).get().then(
                (snapshot) => {
                    jQuery("#canceled_count").empty();
                    jQuery("#canceled_count").text(snapshot.docs.length);
                }).catch(function(error) {
                    console.warn('Error loading canceled orders:', error);
                    jQuery("#canceled_count").text('0');
                }),
            // Order Failed
            db.collection('restaurant_orders').where('status', 'in', ["Driver Rejected"]).get().then(
                (snapshot) => {
                    jQuery("#failed_count").empty();
                    jQuery("#failed_count").text(snapshot.docs.length);
                }).catch(function(error) {
                    console.warn('Error loading failed orders:', error);
                    jQuery("#failed_count").text('0');
                }),
            // Order Pending
            db.collection('restaurant_orders').where('status', 'in', ["Driver Pending"]).get().then(
                (snapshot) => {
                    jQuery("#pending_count").empty();
                    jQuery("#pending_count").text(snapshot.docs.length);
                }).catch(function(error) {
                    console.warn('Error loading pending orders:', error);
                    jQuery("#pending_count").text('0');
                })
        ]).then(() => {
            jQuery("#data-table_processing").hide();
        });
    }
    
    // Load restaurants table
    function loadRestaurantsTable() {
        if (!db) return;
        
        var offest = 1;
        var pagesize = 10;
        var inx = parseInt(offest) * parseInt(pagesize);
        var append_listvendors = document.getElementById('append_list');
        if (!append_listvendors) return;
        
        append_listvendors.innerHTML = '';
        let ref = db.collection('vendors');
        ref.orderBy('reviewsCount', 'desc').limit(inx).get().then(async (snapshots) => {
            var html = '';
            html = await buildHTML(snapshots);
            if (html != '') {
                append_listvendors.innerHTML = html;
            }
            // Check if DataTable already exists, destroy it first
            if ($.fn.DataTable.isDataTable('#restaurantTable')) {
                $('#restaurantTable').DataTable().destroy();
            }
            $('#restaurantTable').DataTable({
                order: [],
                columnDefs: [
                    {orderable: false, targets: [0, 2, 3]},
                ],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true,
                paging: false,
                info: false 
            });
        }).catch(function(error) {
            console.warn('Error loading restaurants (index may be needed):', error);
            // Fallback: try without orderBy
            ref.limit(inx).get().then(async (snapshots) => {
                var html = '';
                html = await buildHTML(snapshots);
                if (html != '') {
                    append_listvendors.innerHTML = html;
                }
                // Check if DataTable already exists, destroy it first
                if ($.fn.DataTable.isDataTable('#restaurantTable')) {
                    $('#restaurantTable').DataTable().destroy();
                }
                $('#restaurantTable').DataTable({
                    order: [],
                    columnDefs: [
                        {orderable: false, targets: [0, 2, 3]},
                    ],
                    "language": {
                        "zeroRecords": "{{trans("lang.no_record_found")}}",
                        "emptyTable": "{{trans("lang.no_record_found")}}"
                    },
                    responsive: true,
                    paging: false,
                    info: false 
                });
            }).catch(function(err) {
                console.error('Error loading restaurants (fallback):', err);
            });
        });
    }
    
    // Load top drivers table
    function loadTopDriversTable() {
        if (!db) return;
        
        var offest = 1;
        var pagesize = 10;
        var inx = parseInt(offest) * parseInt(pagesize);
        var append_listtop_drivers = document.getElementById('append_list_top_drivers');
        if (!append_listtop_drivers) return;
        
        append_listtop_drivers.innerHTML = '';
        ref = db.collection('users');
        
        // Get all drivers first, then sort in JavaScript (works without index)
        ref.where('role', '==', 'driver').get().then(async (snapshots) => {
            if (snapshots.empty) {
                // Check if DataTable already exists, destroy it first
                if ($.fn.DataTable.isDataTable('#driverTable')) {
                    $('#driverTable').DataTable().destroy();
                }
                $('#driverTable').DataTable({
                    order: [],
                    columnDefs: [
                        {orderable: false, targets: [0, 3]},
                    ],
                    "language": {
                        "zeroRecords": "{{trans("lang.no_record_found")}}",
                        "emptyTable": "{{trans("lang.no_record_found")}}"
                    },
                    responsive: true,
                    paging: false,
                    info: false
                });
                return;
            }
            
            // Sort drivers by orderCompleted in JavaScript
            var drivers = [];
            snapshots.docs.forEach((doc) => {
                var data = doc.data();
                data.id = doc.id;
                data.orderCompleted = data.orderCompleted || 0;
                drivers.push(data);
            });
            
            // Sort by orderCompleted descending
            drivers.sort((a, b) => {
                return (b.orderCompleted || 0) - (a.orderCompleted || 0);
            });
            
            // Take only top N drivers
            drivers = drivers.slice(0, inx);
            
            // Build HTML from sorted data
            var html = '';
            drivers.forEach((driver) => {
                var driverroute = '<?php echo route("drivers.edit", ":id");?>';
                driverroute = driverroute.replace(':id', driver.id);
                var driverviewroute = '<?php echo route("drivers.view", ":id");?>';
                driverviewroute = driverviewroute.replace(':id', driver.id);
                html = html + '<tr>';
                if (driver.profilePictureURL == '' || driver.profilePictureURL == null) {
                    html = html + '<td class="text-center"><img class="img-circle img-size-32 mr-2" style="width:60px;height:60px;" src="' + placeholderImage + '" alt="image"></td>';
                } else {
                    html = html + '<td class="text-center"><img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" class="img-circle img-size-32 mr-2" style="width:60px;height:60px;" src="' + driver.profilePictureURL + '" alt="image"></td>';
                }
                html = html + '<td data-url="' + driverviewroute + '" class="redirecttopage">' + (driver.firstName || '') + ' ' + (driver.lastName || '') + '</td>';
                html = html + '<td data-url="' + driverroute + '" class="redirecttopage">' + (driver.orderCompleted || 0) + '</td>';
                var currentStatus = driver.approvalStatus || 'waiting';
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
                html = html + '<td><div class="dropdown"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" driver_id="' + driver.id + '" approval_status="' + currentStatus + '" name="driver-status-dropdown-home" title="Change Status"><span class="mdi ' + statusIcon + '" style="color: ' + statusColor + '; font-size: 20px;"></span></a><ul class="dropdown-menu status-dropdown-menu" role="menu"><li><a href="javascript:void(0)" class="status-option-driver" data-status="waiting" data-driver-id="' + driver.id + '"><span class="mdi mdi-clock-outline" style="color: #ffc107;"></span> Waiting</a></li><li><a href="javascript:void(0)" class="status-option-driver" data-status="rejected" data-driver-id="' + driver.id + '"><span class="mdi mdi-close-circle" style="color: #dc3545;"></span> Rejected</a></li><li><a href="javascript:void(0)" class="status-option-driver" data-status="approved" data-driver-id="' + driver.id + '"><span class="mdi mdi-check-circle" style="color: #2c9653;"></span> Approved</a></li></ul></div></td>';
                html = html + '</tr>';
            });
            
            if (html != '') {
                append_listtop_drivers.innerHTML = html;
            }
            
            // Check if DataTable already exists, destroy it first
            if ($.fn.DataTable.isDataTable('#driverTable')) {
                $('#driverTable').DataTable().destroy();
            }
            $('#driverTable').DataTable({
                order: [],
                columnDefs: [
                    {orderable: false, targets: [0, 3]},
                ],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true,
                paging: false,
                info: false
            });
        }).catch(function(error) {
            console.error('Error loading top drivers:', error);
            append_listtop_drivers.innerHTML = '<tr><td colspan="4" class="text-center">Error loading drivers</td></tr>';
        });
    }
    
    // Load recent orders table
    function loadRecentOrdersTable() {
        if (!db) return;
        
        var offest = 1;
        var pagesize = 10;
        var inx = parseInt(offest) * parseInt(pagesize);
        var append_listrecent_order = document.getElementById('append_list_recent_order');
        if (!append_listrecent_order) return;
        
        append_listrecent_order.innerHTML = '';
        ref = db.collection('restaurant_orders');
        
        // Get all orders with matching status, then sort in JavaScript (works without index)
        var statuses = ["Order Placed", "Order Accepted", "Driver Pending", "Driver Accepted", "Order Shipped", "In Transit"];
        ref.where('status', 'in', statuses).get().then(async (snapshots) => {
            if (snapshots.empty) {
                // Check if DataTable already exists, destroy it first
                if ($.fn.DataTable.isDataTable('#orderTable')) {
                    $('#orderTable').DataTable().destroy();
                }
                $('#orderTable').DataTable({
                    order: [],
                    "language": {
                        "zeroRecords": "{{trans("lang.no_record_found")}}",
                        "emptyTable": "{{trans("lang.no_record_found")}}"
                    },
                    responsive: true,
                    paging: false,
                    info: false
                });
                return;
            }
            
            // Sort orders by createdAt in JavaScript
            var orders = [];
            snapshots.docs.forEach((doc) => {
                var data = doc.data();
                data.id = doc.id;
                // Handle timestamp conversion
                if (data.createdAt) {
                    try {
                        if (data.createdAt.toDate) {
                            data._sortDate = data.createdAt.toDate();
                        } else if (data.createdAt._seconds) {
                            data._sortDate = new Date(data.createdAt._seconds * 1000);
                        } else {
                            data._sortDate = new Date(0);
                        }
                    } catch (e) {
                        data._sortDate = new Date(0);
                    }
                } else {
                    data._sortDate = new Date(0);
                }
                orders.push(data);
            });
            
            // Sort by createdAt descending
            orders.sort((a, b) => {
                return b._sortDate - a._sortDate;
            });
            
            // Take only top N orders
            orders = orders.slice(0, inx);
            
            // Build HTML from sorted data
            var html = '';
            for (var i = 0; i < orders.length; i++) {
                var val = orders[i];
                var route = '<?php echo route("orders.edit", ":id"); ?>';
                route = route.replace(':id', val.id);
                var vendorroute = '<?php echo route("restaurants.view", ":id");?>';
                vendorroute = vendorroute.replace(':id', val.vendorID);
                html = html + '<tr>';
                html = html + '<td data-url="' + route + '" class="redirecttopage">' + val.id + '</td>';
                var price = 0; 
                var quan = 0;
                if (val.products && val.products.forEach) {
                    val.products.forEach((product)=> {
                        if(product.quantity != 0){
                            quan = quan + product.quantity;
                        }
                    });
                }
                var vendorTitle = (val.vendor && val.vendor.title) ? val.vendor.title : 'N/A';
                html = html + '<td data-url="' + vendorroute + '" class="redirecttopage">' + vendorTitle + '</td>';
                var price = buildHTMLProductstotal(val);
                html = html + '<td data-url="' + route + '" class="redirecttopage">' + price + '</td>';
                html = html + '<td data-url="' + route + '" class="redirecttopage"><i class="fa fa-shopping-cart"></i> ' + quan + '</td>';
                html = html + '</tr>';
            }
            
            if (html != '') {
                append_listrecent_order.innerHTML = html;
            }
            
            // Check if DataTable already exists, destroy it first
            if ($.fn.DataTable.isDataTable('#orderTable')) {
                $('#orderTable').DataTable().destroy();
            }
            $('#orderTable').DataTable({
                order: [],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true,
                paging: false,
                info: false
            });
        }).catch(function(error) {
            console.error('Error loading recent orders:', error);
            append_listrecent_order.innerHTML = '<tr><td colspan="4" class="text-center">Error loading orders</td></tr>';
        });
    }
    
    // Load recent payouts table
    function loadRecentPayoutsTable() {
        if (!db) return;
        
        var append_list_recent_payouts = document.getElementById('append_list_recent_payouts');
        if (!append_list_recent_payouts) return;
        
        append_list_recent_payouts.innerHTML = '';
        
        // Get all successful payouts, then sort in JavaScript (works without index)
        db.collection('payouts').where('paymentStatus', '==', 'Success').get().then(async (snapshots) => {
            if (snapshots.empty) {
                    setTimeout(function(){
                    // Check if DataTable already exists, destroy it first
                    if ($.fn.DataTable.isDataTable('#recentPayoutsTable')) {
                        $('#recentPayoutsTable').DataTable().destroy();
                    }
                    $('#recentPayoutsTable').DataTable({
                        columnDefs: [
                            {
                                targets: 2,
                                type: 'date',
                                render: function (data) {
                                    return data;
                                } 
                            },
                            {
                                targets: 1,
                                type: 'num-fmt',
                                render: function (data, type, row, meta) {
                                    if (type === 'display') {
                                        return data;
                                    }
                                    return parseFloat(data.replace(/[^0-9.-]+/g, ""));
                                }
                            },
                        ],
                        order: [['2', 'desc']],
                        "language": {
                            "zeroRecords": "{{trans("lang.no_record_found")}}",
                            "emptyTable": "{{trans("lang.no_record_found")}}"
                        },
                        responsive: true,
                        paging: false,
                        info: false
                    });
                }, 500);
                return;
            }
            
            // Sort payouts by paidDate in JavaScript
            var payouts = [];
            snapshots.docs.forEach((doc) => {
                var data = doc.data();
                data.id = doc.id;
                // Handle timestamp conversion
                if (data.paidDate) {
                    try {
                        if (data.paidDate.toDate) {
                            data._sortDate = data.paidDate.toDate();
                        } else if (data.paidDate._seconds) {
                            data._sortDate = new Date(data.paidDate._seconds * 1000);
                        } else {
                            data._sortDate = new Date(0);
                        }
                    } catch (e) {
                        data._sortDate = new Date(0);
                    }
                } else {
                    data._sortDate = new Date(0);
                }
                payouts.push(data);
            });
            
            // Sort by paidDate descending
            payouts.sort((a, b) => {
                return b._sortDate - a._sortDate;
            });
            
            // Take only top 10 payouts
            payouts = payouts.slice(0, 10);
            
            // Build HTML from sorted data
            var intRegex = /^\d+$/;
            var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
            var html = '';
            payouts.forEach((val) => {
                getRestaurantName(val.vendorID);
                var price = val.amount;
                if (intRegex.test(price) || floatRegex.test(price)) {
                    price = parseFloat(price).toFixed(2);
                } else {
                    price = 0;
                }
                var price_val;
                if (currencyAtRight) {
                    price_val = parseFloat(price).toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    price_val = currentCurrency + "" + parseFloat(price).toFixed(decimal_degits);
                }
                html = html + '<tr class="payout_'+val.id+'">';
                var route = '{{route("restaurants.view",":id")}}';
                route = route.replace(':id', val.vendorID);   
                html = html + '<td data-url="'+route+'" class="redirecttopage restname_'+val.vendorID+'" ></td>';
                html = html + '<td class="text-red">(' + price_val + ')</td>';
                var date = '';
                var time = '';
                if (val.paidDate) {
                    try {
                        if (val.paidDate.toDate) {
                            date = val.paidDate.toDate().toDateString();
                            time = val.paidDate.toDate().toLocaleTimeString('en-US');
                        } else if (val.paidDate._seconds) {
                            var dateObj = new Date(val.paidDate._seconds * 1000);
                            date = dateObj.toDateString();
                            time = dateObj.toLocaleTimeString('en-US');
                        }
                    } catch (e) {
                        date = 'N/A';
                        time = '';
                    }
                }
                html = html + '<td class="dt-time">' + date + ' ' + time + '</td>';
                if (val.note != undefined && val.note != '') {
                    html = html + '<td>' + val.note + '</td>';
                } else {
                    html = html + '<td></td>';
                }
                html = html + '</tr>';
            });
            
            if (html != '') {
                append_list_recent_payouts.innerHTML = html;
            }
            
            setTimeout(function(){
                // Check if DataTable already exists, destroy it first
                if ($.fn.DataTable.isDataTable('#recentPayoutsTable')) {
                    $('#recentPayoutsTable').DataTable().destroy();
                }
                $('#recentPayoutsTable').DataTable({
                    columnDefs: [
                        {
                            targets: 2,
                            type: 'date',
                            render: function (data) {
                                return data;
                            } 
                        },
                        {
                            targets: 1,
                            type: 'num-fmt',
                            render: function (data, type, row, meta) {
                                if (type === 'display') {
                                    return data;
                                }
                                return parseFloat(data.replace(/[^0-9.-]+/g, ""));
                            }
                        },
                    ],
                    order: [['2', 'desc']],
                    "language": {
                        "zeroRecords": "{{trans("lang.no_record_found")}}",
                        "emptyTable": "{{trans("lang.no_record_found")}}"
                    },
                    responsive: true,
                    paging: false,
                    info: false
                });
            }, 500);
        }).catch(function(error) {
            console.error('Error loading recent payouts:', error);
            append_list_recent_payouts.innerHTML = '<tr><td colspan="4" class="text-center">Error loading payouts</td></tr>';
        });
    }
    
    async function getTotalEarnings() {
        var intRegex = /^\d+$/;
        var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
        var v01 = 0;
        var v02 = 0;
        var v03 = 0;
        var v04 = 0;
        var v05 = 0;
        var v06 = 0;
        var v07 = 0;
        var v08 = 0;
        var v09 = 0;
        var v10 = 0;
        var v11 = 0;
        var v12 = 0;
        var currentYear = new Date().getFullYear();
        if (!db) {
            console.error('Database not available for getTotalEarnings');
            jQuery("#data-table_processing").hide();
            return;
        }
        
        await db.collection('restaurant_orders').where('status', 'in', ["Order Completed"]).get().then(async function (orderSnapshots) {
            var paymentData = orderSnapshots.docs;
            var totalEarning = 0;
            var adminCommission = 0;
            paymentData.forEach((order) => {
                var orderData = order.data();
                var price = 0;
                var minprice = 0;
                orderData.products.forEach((product) => {
                    if (product.price && product.quantity != 0) {
                        var extras_price = 0;
                        if (product.extras_price != undefined && product.extras_price != null) {
                            extras_price = parseFloat(product.extras_price) * parseInt(product.quantity);
                        }
                        if (!isNaN(extras_price)) {
                            var productTotal = (parseFloat(product.price) * parseInt(product.quantity)) + extras_price;
                        } else {
                            var productTotal = (parseFloat(product.price) * parseInt(product.quantity));
                        }
                        if (!isNaN(productTotal)) {
                            price = price + productTotal;
                            minprice = minprice + productTotal;
                        }
                    }
                })
                discount = orderData.discount;
                if ((intRegex.test(discount) || floatRegex.test(discount)) && !isNaN(discount)) {
                    discount = parseFloat(discount).toFixed(decimal_degits);
                    price = price - parseFloat(discount);
                    minprice = minprice - parseFloat(discount);
                }
                tax = 0;
                if (orderData.hasOwnProperty('taxSetting')) {
                    if (orderData.taxSetting.type && orderData.taxSetting.tax) {
                        if (orderData.taxSetting.type == "percent") {
                            tax = (parseFloat(orderData.taxSetting.tax) * minprice) / 100;
                        } else {
                            tax = parseFloat(orderData.taxSetting.tax);
                        }
                    }
                }
                if (!isNaN(tax)) {
                    price = price + tax;
                }
                if (orderData.deliveryCharge != undefined && orderData.deliveryCharge != "" && orderData.deliveryCharge > 0) {
                    price = price + parseFloat(orderData.deliveryCharge);
                }
                if (orderData.adminCommission != undefined && orderData.adminCommissionType != undefined && orderData.adminCommission > 0 && price > 0) {
                    var commission = 0;
                    if (orderData.adminCommissionType == "Percent") {
                        commission = (price * parseFloat(orderData.adminCommission)) / 100;
                    } else {
                        commission = parseFloat(orderData.adminCommission);
                    }
                    adminCommission = commission + adminCommission;
                } else if (orderData.adminCommission != undefined && orderData.adminCommission > 0 && price > 0) {
                    var commission = parseFloat(orderData.adminCommission);
                    adminCommission = commission + adminCommission;
                }
                totalEarning = parseFloat(totalEarning) + parseFloat(price);
                try {
                    if (orderData.createdAt) {
                        var orderMonth = orderData.createdAt.toDate().getMonth() + 1;
                        var orderYear = orderData.createdAt.toDate().getFullYear();
                        if (currentYear == orderYear) {
                            switch (parseInt(orderMonth)) {
                                case 1:
                                    v01 = parseInt(v01) + price;
                                    break;
                                case 2:
                                    v02 = parseInt(v02) + price;
                                    break;
                                case 3:
                                    v03 = parseInt(v03) + price;
                                    break;
                                case 4:
                                    v04 = parseInt(v04) + price;
                                    break;
                                case 5:
                                    v05 = parseInt(v05) + price;
                                    break;
                                case 6:
                                    v06 = parseInt(v06) + price;
                                    break;
                                case 7:
                                    v07 = parseInt(v07) + price;
                                    break;
                                case 8:
                                    v08 = parseInt(v08) + price;
                                    break;
                                case 9:
                                    v09 = parseInt(v09) + price;
                                    break;
                                case 10:
                                    v10 = parseInt(v10) + price;
                                    break;
                                case 11:
                                    v11 = parseInt(v11) + price;
                                    break;
                                default :
                                    v12 = parseInt(v12) + price;
                                    break;
                            }
                        }
                    }
                } catch (err) {
                    var datas = new Date(orderData.createdAt._seconds * 1000);
                    var dates = firebase.firestore.Timestamp.fromDate(datas);
                    db.collection('restaurant_orders').doc(orderData.id).update({'createdAt': dates}).then(() => {
                        console.log('Provided document has been updated in Firestore');
                    }, (error) => {
                        console.log('Error: ' + error);
                    });
                }
            })
            if (currencyAtRight) {
                totalEarning = parseFloat(totalEarning).toFixed(decimal_degits) + "" + currentCurrency;
                adminCommission = parseFloat(adminCommission).toFixed(decimal_degits) + "" + currentCurrency;
            } else {
                totalEarning = currentCurrency + "" + parseFloat(totalEarning).toFixed(decimal_degits);
                adminCommission = currentCurrency + "" + parseFloat(adminCommission).toFixed(decimal_degits);
            }
            $("#earnings_count").text(totalEarning);
            $("#earnings_count_graph").text(totalEarning);
            $("#admincommission_count_graph").text(adminCommission);
            $("#admincommission_count").text(adminCommission);
            $("#total_earnings_header").text(totalEarning);
            $(".earnings_over_time").text(totalEarning);
            var data = [v01, v02, v03, v04, v05, v06, v07, v08, v09, v10, v11, v12];
            var labels = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
            var $salesChart = $('#sales-chart');
            var salesChart = renderChart($salesChart, data, labels);
            setCommision();
        }).catch(function(error) {
            console.error('Error loading total earnings:', error);
            // Set default values on error
            jQuery("#earnings_count").text('0');
            jQuery("#admincommission_count").text('0');
            setCommision();
        });
        jQuery("#data-table_processing").hide();
    }
    
    // Start initialization when DOM and Firestore are ready
    $(document).ready(function() {
        // Wait for Firestore to be initialized
        var retryCount = 0;
        var maxRetries = 40; // 20 seconds max (increased for reliability)
        
        var checkFirestore = function() {
            // Try multiple ways to get database
            var db = null;
            if (typeof database !== 'undefined' && database !== null) {
                db = database;
            } else if (typeof window.database !== 'undefined' && window.database !== null) {
                db = window.database;
            } else if (typeof window.firestoreDatabase !== 'undefined' && window.firestoreDatabase !== null) {
                db = window.firestoreDatabase;
            } else if (typeof window.getFirestoreDatabase === 'function') {
                db = window.getFirestoreDatabase();
            } else if (typeof firebase !== 'undefined' && firebase.firestore) {
                try {
                    db = firebase.firestore();
                } catch (e) {
                    console.warn('Could not get Firestore:', e);
                }
            }
            
            if (db) {
                // Set database globally for this page
                database = db;
                window.database = db;
                console.log('✅ Database found, initializing dashboard...');
                initDashboard();
            } else if (retryCount < maxRetries) {
                retryCount++;
                if (retryCount % 10 === 0) {
                    console.log('⏳ Waiting for Firestore... (' + retryCount + '/' + maxRetries + ')');
                }
                setTimeout(checkFirestore, 500);
            } else {
                console.error('❌ Firestore not initialized after 20 seconds');
                console.error('❌ Please check:');
                console.error('   1. Firebase configuration in .env');
                console.error('   2. Firestore Rules in Firebase Console');
                console.error('   3. Browser Console for errors');
                jQuery("#data-table_processing").hide();
                
                // Show user-friendly error
                if (typeof jQuery !== 'undefined') {
                    jQuery("#data-table_processing").html('<div style="text-align:center;padding:20px;"><h4>❌ Unable to connect to Firestore</h4><p>Please check the browser console (F12) for details</p></div>');
                }
            }
        };
        
        // Also listen for firestoreReady event
        if (typeof window.addEventListener !== 'undefined') {
            window.addEventListener('firestoreReady', function() {
                console.log('✅ Received firestoreReady event');
                if (typeof database !== 'undefined' && database !== null) {
                    initDashboard();
                } else {
                    checkFirestore();
                }
            });
        }
        
        checkFirestore();
    });
    function buildHTML(snapshots) {
        var html = '';
        var count = 1;
        var rating = 0;
        snapshots.docs.forEach((listval) => {
            val = listval.data();
            val.id = listval.id;
            var route = '<?php echo route("restaurants.edit", ":id");?>';
            route = route.replace(':id', val.id);
            var routeview = '<?php echo route("restaurants.view", ":id");?>';
            routeview = routeview.replace(':id', val.id);
            html = html + '<tr>';
            if (val.photo == '' && val.photo == null) {
                html = html + '<td class="text-center"><img class="img-circle img-size-32 mr-2" style="width:60px;height:60px;" src="' + placeholderImage + '" alt="image"></td>';
            } else {
                html = html + '<td class="text-center"><img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" class="img-circle img-size-32 mr-2" style="width:60px;height:60px;" src="' + val.photo + '" alt="image"></td>';
            }
            html = html + '<td data-url="' + routeview + '" class="redirecttopage">' + val.title + '</td>';
            if (val.hasOwnProperty('reviewsCount') && val.reviewsCount != 0) {
                rating = Math.round(parseFloat(val.reviewsSum) / parseInt(val.reviewsCount));
            } else {
                rating = 0;
            }
            html = html + '<td><ul class="rating" data-rating="' + rating + '">';
            html = html + '<li class="rating__item"></li>';
            html = html + '<li class="rating__item"></li>';
            html = html + '<li class="rating__item"></li>';
            html = html + '<li class="rating__item"></li>';
            html = html + '<li class="rating__item"></li>';
            html = html + '</ul></td>';
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
            html = html + '<td><div class="dropdown"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" vendor_id="' + val.id + '" approval_status="' + currentStatus + '" name="vendor-status-dropdown-home" title="Change Status"><span class="mdi ' + statusIcon + '" style="color: ' + statusColor + '; font-size: 20px;"></span></a><ul class="dropdown-menu status-dropdown-menu" role="menu"><li><a href="javascript:void(0)" class="status-option" data-status="waiting" data-vendor-id="' + val.id + '"><span class="mdi mdi-clock-outline" style="color: #ffc107;"></span> Waiting</a></li><li><a href="javascript:void(0)" class="status-option" data-status="rejected" data-vendor-id="' + val.id + '"><span class="mdi mdi-close-circle" style="color: #dc3545;"></span> Rejected</a></li><li><a href="javascript:void(0)" class="status-option" data-status="approved" data-vendor-id="' + val.id + '"><span class="mdi mdi-check-circle" style="color: #2c9653;"></span> Approved</a></li></ul></div></td>';
            html = html + '</tr>';
            rating = 0;
            count++;
        });
        return html;
    }
    function buildDriverHTML(snapshots) {
        var html = '';
        var count = 1;
        snapshots.docs.forEach((listval) => {
            val = listval.data();
            val.id = listval.id;
            var driverroute = '<?php echo route("drivers.edit", ":id");?>';
            driverroute = driverroute.replace(':id', val.id);
            var driverviewroute = '<?php echo route("drivers.view", ":id");?>';
            driverviewroute = driverviewroute.replace(':id', val.id);
            html = html + '<tr>';
            if (val.profilePictureURL == '' && val.profilePictureURL == null) {
                html = html + '<td class="text-center"><img class="img-circle img-size-32 mr-2" style="width:60px;height:60px;" src="' + placeholderImage + '" alt="image"></td>';
            } else {
                html = html + '<td class="text-center"><img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" class="img-circle img-size-32 mr-2" style="width:60px;height:60px;" src="' + val.profilePictureURL + '" alt="image"></td>';
            }
            html = html + '<td data-url="' + driverviewroute + '" class="redirecttopage">' + val.firstName + ' ' + val.lastName + '</td>';
            html = html + '<td data-url="' + driverroute + '" class="redirecttopage">' + val.orderCompleted + '</td>';
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
            html = html + '<td><div class="dropdown"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" driver_id="' + val.id + '" approval_status="' + currentStatus + '" name="driver-status-dropdown-home" title="Change Status"><span class="mdi ' + statusIcon + '" style="color: ' + statusColor + '; font-size: 20px;"></span></a><ul class="dropdown-menu status-dropdown-menu" role="menu"><li><a href="javascript:void(0)" class="status-option-driver" data-status="waiting" data-driver-id="' + val.id + '"><span class="mdi mdi-clock-outline" style="color: #ffc107;"></span> Waiting</a></li><li><a href="javascript:void(0)" class="status-option-driver" data-status="rejected" data-driver-id="' + val.id + '"><span class="mdi mdi-close-circle" style="color: #dc3545;"></span> Rejected</a></li><li><a href="javascript:void(0)" class="status-option-driver" data-status="approved" data-driver-id="' + val.id + '"><span class="mdi mdi-check-circle" style="color: #2c9653;"></span> Approved</a></li></ul></div></td>';
            html = html + '</tr>';
            count++;
        });
        return html;
    }
    async function buildRecentPayoutsHTML(snapshots) {
        var intRegex = /^\d+$/;
        var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
        var html = '';
        var count = 1;
        snapshots.docs.forEach((listval) => {
            val = listval.data();
            val.id = listval.id;
            getRestaurantName(val.vendorID);
            var price = val.amount;
            if (intRegex.test(price) || floatRegex.test(price)) {
                price = parseFloat(price).toFixed(2);
            } else {
                price = 0;
            }
            if (currencyAtRight) {
                price_val = parseFloat(price).toFixed(decimal_degits) + "" + currentCurrency;
            } else {
                price_val = currentCurrency + "" + parseFloat(price).toFixed(decimal_degits);
            }
            html = html + '<tr class="payout_'+val.id+'">';
            var route = '{{route("restaurants.view",":id")}}';
            route = route.replace(':id', val.vendorID);   
            html = html + '<td data-url="'+route+'" class="redirecttopage restname_'+val.vendorID+'" ></td>';
            html = html + '<td class="text-red">(' + price_val + ')</td>';
            var date = val.paidDate.toDate().toDateString();
            var time = val.paidDate.toDate().toLocaleTimeString('en-US');
            html = html + '<td class="dt-time">' + date + ' ' + time + '</td>';
            if (val.note != undefined && val.note != '') {
                html = html + '<td>' + val.note + '</td>';
            } else {
                html = html + '<td></td>';
            }
            html = html + '</tr>';
        });
        return html;
    }
    function getRestaurantName(vendorId) {
        if (!db) {
            console.warn('Database not ready for getRestaurantName');
            return;
        }
        db.collection('vendors').doc(vendorId).get().then(async function (snapshots) {
            if(snapshots.exists){
                var data = snapshots.data();
                $(".restname_"+vendorId).text(data.title);
            }
        });
    }
    function buildOrderHTML(snapshots) {
        var html = '';
        var count = 1;
        snapshots.docs.forEach((listval) => {
            val = listval.data();
            val.id = listval.id;
            var route = '<?php echo route("orders.edit", ":id"); ?>';
            route = route.replace(':id', val.id);
            var vendorroute = '<?php echo route("restaurants.view", ":id");?>';
            vendorroute = vendorroute.replace(':id', val.vendorID);
            html = html + '<tr>';
            html = html + '<td data-url="' + route + '" class="redirecttopage">' + val.id + '</td>';
            var price = 0; 
                var quan = 0;
            val.products.forEach((product)=> {
                if(product.quantity != 0){
                    quan = quan + product.quantity;
                }
            })
            html = html + '<td data-url="' + vendorroute + '" class="redirecttopage">' + val.vendor.title + '</td>';
            var price =  buildHTMLProductstotal(val);
            html = html + '<td data-url="' + route + '" class="redirecttopage">' + price + '</td>';
            html = html + '<td data-url="' + route + '" class="redirecttopage"><i class="fa fa-shopping-cart"></i> ' + quan + '</td>';
            html = html + '</a></tr>';
            count++;
        });
        return html;
    }
    function renderChart(chartNode, data, labels) {
        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        };
        var mode = 'index';
        var intersect = true;
        return new Chart(chartNode, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        backgroundColor: '#2EC7D9',
                        borderColor: '#2EC7D9',
                        data: data
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    mode: mode,
                    intersect: intersect
                },
                hover: {
                    mode: mode,
                    intersect: intersect
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: true,
                            lineWidth: '4px',
                            color: 'rgba(0, 0, 0, .2)',
                            zeroLineColor: 'transparent'
                        },
                        ticks: $.extend({
                            beginAtZero: true,
                            callback: function (value, index, values) {
                                return currentCurrency + value.toFixed(decimal_degits);
                            }
                        }, ticksStyle)
                    }],
                    xAxes: [{
                        display: true,
                        gridLines: {
                            display: false
                        },
                        ticks: ticksStyle
                    }]
                }
            }
        })
    }
    $(document).ready(function () {
        // Initialize Bootstrap dropdowns
        $('.dropdown-toggle').on('click', function(e) {
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
        
        $(document.body).on('click', '.redirecttopage', function () {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });
        
        // Status Change Handler for Restaurants (Home Page) - Dropdown
        $(document).off("click", ".status-option[data-vendor-id]").on("click", ".status-option[data-vendor-id]", async function(e) {
            e.preventDefault();
            e.stopPropagation();
            var vendorId = $(this).attr('data-vendor-id');
            var newStatus = $(this).attr('data-status');
            var $dropdown = $(this).closest('.dropdown');
            var $toggle = $dropdown.find('.dropdown-toggle');
            var currentStatus = $toggle.attr('approval_status') || 'waiting';
            
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
                    updateVendorStatusIcon($dropdown, newStatus);
                    
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
                    setTimeout(function() {
                        loadRestaurantsTable();
                    }, 500);
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
        
        // Function to update vendor status icon immediately
        function updateVendorStatusIcon($dropdown, newStatus) {
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
            
            var $toggle = $dropdown.find('.dropdown-toggle');
            var $icon = $toggle.find('.mdi');
            $icon.removeClass('mdi-check-circle mdi-close-circle mdi-clock-outline')
                 .addClass(statusIcon)
                 .css('color', statusColor);
            $toggle.attr('approval_status', newStatus);
        }
        
        // Status Change Handler for Drivers (Home Page) - Dropdown
        $(document).off("click", ".status-option-driver[data-driver-id]").on("click", ".status-option-driver[data-driver-id]", async function(e) {
            e.preventDefault();
            e.stopPropagation();
            var driverId = $(this).attr('data-driver-id');
            var newStatus = $(this).attr('data-status');
            var $dropdown = $(this).closest('.dropdown');
            var $toggle = $dropdown.find('.dropdown-toggle');
            var currentStatus = $toggle.attr('approval_status') || 'waiting';
            
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
                        await database.collection('users').doc(driverId).set({
                            'approvalStatus': newStatus
                        }, { merge: true });
                    } catch (setError) {
                        // If set fails, try update
                        await database.collection('users').doc(driverId).update({
                            'approvalStatus': newStatus
                        });
                    }
                    
                    // Update UI immediately without reload
                    updateDriverStatusIcon($dropdown, newStatus);
                    
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
                    setTimeout(function() {
                        loadTopDriversTable();
                    }, 500);
                } else {
                    throw new Error('Database not available');
                }
            } catch (error) {
                console.error('❌ Error changing driver status:', error);
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
        
        // Function to update driver status icon immediately
        function updateDriverStatusIcon($dropdown, newStatus) {
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
            
            var $toggle = $dropdown.find('.dropdown-toggle');
            var $icon = $toggle.find('.mdi');
            $icon.removeClass('mdi-check-circle mdi-close-circle mdi-clock-outline')
                 .addClass(statusIcon)
                 .css('color', statusColor);
            $toggle.attr('approval_status', newStatus);
        }
    });
     function buildHTMLProductstotal(snapshotsProducts) {
        var adminCommission = snapshotsProducts.adminCommission;
        var discount = snapshotsProducts.discount;
        var couponCode = snapshotsProducts.couponCode;
        var extras = snapshotsProducts.extras;
        var extras_price = snapshotsProducts.extras_price;
        var rejectedByDrivers = snapshotsProducts.rejectedByDrivers;
        var takeAway = snapshotsProducts.takeAway;
        var tip_amount = snapshotsProducts.tip_amount;
        var status = snapshotsProducts.status;
        var products = snapshotsProducts.products;
        var deliveryCharge = snapshotsProducts.deliveryCharge;
        var totalProductPrice = 0;
        var total_price = 0;
        var specialDiscount = snapshotsProducts.specialDiscount;
        var intRegex = /^\d+$/;
        var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
        if (products) {
            products.forEach((product) => {
                var val = product;
                if (val.price) {
                    price_item = parseFloat(val.price).toFixed(2);
                    extras_price_item = 0;
                    if (val.extras_price && !isNaN(extras_price_item) && !isNaN(val.quantity)) {
                        extras_price_item = (parseFloat(val.extras_price) * parseInt(val.quantity)).toFixed(2);
                    }
                    if (!isNaN(price_item) && !isNaN(val.quantity)) {
                        totalProductPrice = parseFloat(price_item) * parseInt(val.quantity);
                    }
                    var extras_price = 0;
                    if (parseFloat(extras_price_item) != NaN && val.extras_price != undefined) {
                        extras_price = extras_price_item;
                    }
                    totalProductPrice = parseFloat(extras_price) + parseFloat(totalProductPrice);
                    totalProductPrice = parseFloat(totalProductPrice).toFixed(2);
                    if (!isNaN(totalProductPrice)) {
                        total_price += parseFloat(totalProductPrice);
                    }
                }
            });
        }
        if (intRegex.test(discount) || floatRegex.test(discount)) {
            discount = parseFloat(discount).toFixed(decimal_degits);
            total_price -= parseFloat(discount);
            if (currencyAtRight) {
                discount_val = discount + "" + currentCurrency;
            } else {
                discount_val = currentCurrency + "" + discount;
            }
        }
        var special_discount = 0;
        if (specialDiscount != undefined) {
            special_discount = parseFloat(specialDiscount.special_discount).toFixed(2);
            total_price = total_price - special_discount;
        }
        var total_item_price = total_price;
        var tax = 0;
        taxlabel = '';
        taxlabeltype = '';
        if (snapshotsProducts.hasOwnProperty('taxSetting')) {
            var total_tax_amount = 0;
            for (var i = 0; i < snapshotsProducts.taxSetting.length; i++) {
                var data = snapshotsProducts.taxSetting[i];
                if (data.type && data.tax) {
                    if (data.type == "percentage") {
                        tax = (data.tax * total_price) / 100;
                        taxlabeltype = "%";
                    } else {
                        tax = data.tax;
                        taxlabeltype = "fix";
                    }
                    taxlabel = data.title;
                }
                total_tax_amount += parseFloat(tax);
            }
            total_price = parseFloat(total_price) + parseFloat(total_tax_amount);
        }
        if ((intRegex.test(deliveryCharge) || floatRegex.test(deliveryCharge)) && !isNaN(deliveryCharge)) {
            deliveryCharge = parseFloat(deliveryCharge).toFixed(decimal_degits);
            total_price += parseFloat(deliveryCharge);
            if (currencyAtRight) {
                deliveryCharge_val = deliveryCharge + "" + currentCurrency;
            } else {
                deliveryCharge_val = currentCurrency + "" + deliveryCharge;
            }  
        }
        if (intRegex.test(tip_amount) || floatRegex.test(tip_amount) && !isNaN(tip_amount)) {
            tip_amount = parseFloat(tip_amount).toFixed(decimal_degits);
            total_price += parseFloat(tip_amount);
            total_price = parseFloat(total_price).toFixed(decimal_degits);
        }
        if (currencyAtRight) {
            var total_price_val = parseFloat(total_price).toFixed(decimal_degits) + "" + currentCurrency;
        } else {
            var total_price_val = currentCurrency + "" + parseFloat(total_price).toFixed(decimal_degits);
        }
        return total_price_val;
    }
    function setVisitors() {
        const data = {
            labels: [
                "{{trans('lang.dashboard_total_restaurants')}}",
                "{{trans('lang.dashboard_total_orders')}}",
                "{{trans('lang.dashboard_total_products')}}",
                "{{trans('lang.dashboard_total_clients')}}",
                "{{trans('lang.dashboard_total_drivers')}}",
            ],
            datasets: [{
                data: [jQuery("#vendor_count").text(), jQuery("#order_count").text(), jQuery("#product_count").text(), jQuery("#users_count").text(), jQuery("#driver_count").text()],
                backgroundColor: [
                    '#218be1',
                    '#B1DB6F',
                    '#7360ed',
                    '#FFAB2E',
                    '#2c9653',
                ],
                hoverOffset: 4
            }]
        };
        return new Chart('visitors', {
            type: 'doughnut',
            data: data,
            options: {
                maintainAspectRatio: false,
            }
        })
    }
    function setCommision() {
        const data = {
            labels: [
                "{{trans('lang.dashboard_total_earnings')}}",
                "{{trans('lang.admin_commission')}}"
            ],
            datasets: [{
                data: [jQuery("#earnings_count").text().replace(currentCurrency, ""), jQuery("#admincommission_count").text().replace(currentCurrency, "")],
                backgroundColor: [
                    '#feb84d',
                    '#9b77f8',
                    '#fe95d3'
                ],
                hoverOffset: 4
            }]
        };
        return new Chart('commissions', {
            type: 'doughnut',
            data: data,
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItems, data) {
                            return data.labels[tooltipItems.index] + ': ' + currentCurrency + data.datasets[0].data[tooltipItems.index];
                        }
                    }
                }
            }
        })
    }
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
