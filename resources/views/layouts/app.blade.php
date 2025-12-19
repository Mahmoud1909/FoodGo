<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      <?php if (str_replace('_', '-', app()->getLocale()) == 'ar' || @$_COOKIE['is_rtl'] == 'true') { ?> dir="rtl" <?php } ?>>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Content Security Policy - Allow unsafe-eval for JavaScript libraries -->
    <!-- Note: frame-ancestors is ignored in meta tags, it only works in HTTP headers -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.datatables.net https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://*.cdnjs.cloudflare.com https://code.jquery.com https://unpkg.com https://*.googleapis.com https://*.gstatic.com https://*.firebase.com https://*.firebaseio.com https://*.google.com https://www.gstatic.com; style-src 'self' 'unsafe-inline' https://cdn.datatables.net https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://*.cdnjs.cloudflare.com https://fonts.googleapis.com https://unpkg.com https://code.jquery.com https://*.gstatic.com; font-src 'self' https://fonts.gstatic.com https://fonts.googleapis.com data:; img-src 'self' data: https: http: blob:; connect-src 'self' https://*.googleapis.com https://*.firebase.com https://*.firebaseio.com https://*.google.com https://www.googleapis.com https://firestore.googleapis.com https://firebaselogging.googleapis.com https://unpkg.com https://cdnjs.cloudflare.com https://*.cdnjs.cloudflare.com https://ajax.googleapis.com https://cdnjs.cloudflare.com/ajax/libs/moment.js https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js.map wss://*.firebaseio.com ws://*.firebaseio.com https://*.firebaseio.com; frame-src 'self' https://*.google.com https://*.googleapis.com https://*.gstatic.com; object-src 'none'; base-uri 'self'; form-action 'self';">
<!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
    <title id="app_name"><?php echo @$_COOKIE['meta_title']; ?></title>
    <link rel="icon" id="favicon" type="image/x-icon"
          href="<?php echo str_replace('images/', 'images%2F', @$_COOKIE['favicon']); ?>">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <?php if (str_replace('_', '-', app()->getLocale()) == 'ar' || @$_COOKIE['is_rtl'] == 'true') { ?>
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap-rtl.min.css')}}" rel="stylesheet">
    <?php } ?>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <?php if (str_replace('_', '-', app()->getLocale()) == 'ar' || @$_COOKIE['is_rtl'] == 'true') { ?>
    <link href="{{asset('css/style_rtl.css')}}" rel="stylesheet">
    <?php } ?>
    <link href="{{ asset('css/icons/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/toast-master/css/jquery.toast.css')}}" rel="stylesheet">
    <link href="{{ asset('css/colors/blue.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css')}}" rel="stylesheet">
    
    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

    <?php if (isset($_COOKIE['admin_panel_color'])) { ?>

    <style type="text/css">
       
        .sidebar-nav ul li a {
            border-bottom: <?php echo $_COOKIE['admin_panel_color']; ?>;
        }
        .sidebar-nav ul li a:hover i {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }
        .vendor_payout_create-inner fieldset legend {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }
        .restaurant_payout_create-inner fieldset legend {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }
        a {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }
        a:hover, a:focus {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }
        a.link:hover, a.link:focus {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        html body blockquote {
            border-left: 5px solid<?php    echo $_COOKIE['admin_panel_color']; ?>;
        }
        .text-warning {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>  !important;
        }
        .text-info {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>  !important;
        }
        .sidebar-nav ul li a:hover {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }
        .btn-primary {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            border: 1px solid<?php    echo $_COOKIE['admin_panel_color']; ?>;
        }
        .sidebar-nav > ul > li.active > a,.sidebar-nav ul li ul li.active a,.sidebar-nav ul li ul li a:hover {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            border-right: 3px solid<?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .sidebar-nav > ul > li.active > a i {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .bg-info {
            background-color: <?php    echo $_COOKIE['admin_panel_color']; ?>  !important;
        }

        .bellow-text ul li > span {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>


        }

        .table tr td.redirecttopage {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>


        }

        ul.rating {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .nav-tabs.card-header-tabs .nav-link.active, .nav-tabs.card-header-tabs .nav-link:hover {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?> <?php    echo $_COOKIE['admin_panel_color']; ?> #fff;
        }

        .btn-warning, .btn-warning.disabled {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            border: 1px solid<?php    echo $_COOKIE['admin_panel_color']; ?>;
            box-shadow: none;
        }

        .payment-top-tab .nav-tabs.card-header-tabs .nav-link.active, .payment-top-tab .nav-tabs.card-header-tabs .nav-link:hover {
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .nav-tabs.card-header-tabs .nav-link span.badge-success {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .nav-tabs.card-header-tabs .nav-link.active span.badge-success, .nav-tabs.card-header-tabs .nav-link:hover span.badge-success, .sidebar-nav ul li a.active, .sidebar-nav ul li a.active:hover, .sidebar-nav ul li.active a.has-arrow:hover, .topbar ul.dropdown-user li a:hover {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .sidebar-nav ul li a.has-arrow:hover::after, .sidebar-nav .active > .has-arrow::after, .sidebar-nav li > .has-arrow.active::after, .sidebar-nav .has-arrow[aria-expanded="true"]::after, .sidebar-nav ul li a:hover {
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        [type="checkbox"]:checked + label::before {
            border-right: 2px solid <?php    echo $_COOKIE['admin_panel_color']; ?>;
            border-bottom: 2px solid <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }
        .edit-form-group .form-check [type="checkbox"]:checked + label::after{border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;background: <?php    echo $_COOKIE['admin_panel_color']; ?>}

        .btn-primary:hover, .btn-primary.disabled:hover {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            border: 1px solid<?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .btn-primary.active, .btn-primary:active, .btn-primary:focus, .btn-primary.disabled.active, .btn-primary.disabled:active, .btn-primary.disabled:focus, .btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary.focus:active, .btn-primary:active:focus, .btn-primary:active:hover, .open > .dropdown-toggle.btn-primary.focus, .open > .dropdown-toggle.btn-primary:focus, .open > .dropdown-toggle.btn-primary:hover, .btn-primary.focus, .btn-primary:focus, .btn-primary:not(:disabled):not(.disabled).active:focus, .btn-primary:not(:disabled):not(.disabled):active:focus, .show > .btn-primary.dropdown-toggle:focus, .btn-warning:hover, .btn-warning:hover, .btn-warning.disabled:hover, .btn-warning.active.focus, .btn-warning.active:focus, .btn-warning.active:hover, .btn-warning.focus:active, .btn-warning:active:focus, .btn-warning:active:hover, .open > .dropdown-toggle.btn-warning.focus, .open > .dropdown-toggle.btn-warning:focus, .open > .dropdown-toggle.btn-warning:hover, .btn-warning.focus, .btn-warning:focus {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            box-shadow: 0 0 0 0.2rem<?php    echo $_COOKIE['admin_panel_color']; ?>;
            color: #fff;
        }
         
        .pagination > li > a.page-link:hover {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .mini-sidebar .sidebar-nav #sidebarnav > li:hover a i, .mini-sidebar .sidebar-nav ul li a, .sidebar-nav ul li a.active i, .sidebar-nav ul li a.active:hover i, .sidebar-nav ul li.active a:hover i {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .cat-slider .cat-item a.cat-link:hover, .cat-slider .cat-item.section-selected a.cat-link {
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .cat-slider .cat-item a.cat-link {
            border-bottom-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .cat-slider .cat-item.section-selected a.cat-link:after {
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .cat-slider {
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .business-analytics .card-box i {
            background: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .order-status .data i, .order-status span.count {
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        .print-btn button {
            border-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
            color: <?php    echo $_COOKIE['admin_panel_color']; ?>;
        }

        [type="radio"]:checked + label::after, [type="radio"].with-gap:checked + label::after {background-color: <?php    echo $_COOKIE['admin_panel_color']; ?>;}
        [type="radio"]:checked + label::after, [type="radio"].with-gap:checked + label::before, [type="radio"].with-gap:checked + label::after {border: 2px solid <?php    echo $_COOKIE['admin_panel_color']; ?>;}
         
        .card-header-tab ul.nav-tab li.active a,.card-header-tab ul.nav-tab li a:hover{background: <?php echo $_COOKIE['admin_panel_color']; ?>;} 
        .edit-form-group .form-check [type="radio"]:checked + label::before,.edit-form-group .form-check [type="checkbox"]:checked + label::after {background: <?php echo $_COOKIE['admin_panel_color']; ?>; border-color: <?php echo $_COOKIE['admin_panel_color']; ?>;} 
        .pricing-card-btm .btn:hover{background: <?php echo $_COOKIE['admin_panel_color']; ?>;border-color: <?php echo $_COOKIE['admin_panel_color']; ?>;}

        .table tr td .action-btn .chat-count-message .unread-count{background: <?php echo $_COOKIE['admin_panel_color']; ?>}

        .text-primary,.ai-text-animation {color: <?php echo $_COOKIE['admin_panel_color']; ?> !important;}
        .btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .show > .btn-primary.dropdown-toggle{
            background-color: <?php echo $_COOKIE['admin_panel_color']; ?> !important;
        }

        @media screen and ( max-width: 767px ) {

            .mini-sidebar .sidebar-nav ul li a:hover, .sidebar-nav > ul > li.active > a {
                color: #2c9653 !important;
            }

            .mini-sidebar .sidebar-nav #sidebarnav > li:hover a i, .mini-sidebar .sidebar-nav ul li a, .sidebar-nav ul li a.active i, .sidebar-nav ul li a.active:hover i, .sidebar-nav ul li.active a:hover i {
                color: #2c9653 !important;
            }

            .sidebar-nav > ul > li.active > a, .sidebar-nav > ul > li.active > a i, .sidebar-nav > ul > li > a:hover i {
                color: #2c9653 !important;
            }
            
            .mini-sidebar .sidebar-nav #sidebarnav > li:hover > a .hide-menu {
                color: #2c9653 !important;
            }
        }
    </style>
    <?php } ?>

</head>
<body>

<div id="app" class="fix-header fix-sidebar card-no-border">
    <div id="main-wrapper">
        <div id="data-table_processing" class="page-overlay" style="display:none;">
            <div class="overlay-text">
                <img src="{{asset('images/spinner.gif')}}">
            </div>
        </div>
        <header class="topbar">

            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                @include('layouts.header')
            </nav>

        </header>
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                @include('layouts.menu')
            </div>
            <!-- End Sidebar scroll-->
        </aside>
    </div>
    <main class="py-4">
        @yield('content')
    </main>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-editable/0.7.3/leaflet.editable.min.js"></script>
<script src="https://unpkg.com/leaflet-draw@0.4.14/dist/leaflet.draw-src.js"></script>
<script src="https://unpkg.com/leaflet-geojson-layer/src/leaflet.geojson.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
<script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('js/waves.js') }}"></script>
<script src="{{ asset('js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<script src="{{ asset('js/custom.min.js') }}"></script>
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.js')}}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>

<script src="{{ asset('js/jquery.resizeImg.js') }}"></script>
<script src="{{ asset('js/mobileBUGFix.mini.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<script type="text/javascript">
    jQuery(window).scroll(function () {
        var scroll = jQuery(window).scrollTop();
        if (scroll <= 60) {
            jQuery("body").removeClass("sticky");
        } else {
            jQuery("body").addClass("sticky");
        }
    });
</script>

<script src="{{ asset('assets/plugins/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/crypto-js.js') }}"></script>
<script src="{{ asset('js/jquery.cookie.js') }}"></script>
<script src="{{ asset('js/jquery.validate.js') }}"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js" onload="window.firebaseAppLoaded = true;"></script>
<script src="{{ asset('js/firestore-helper.js') }}"></script>
<script src="{{ asset('js/firestore-global-fix.js') }}"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js" onload="window.firebaseFirestoreLoaded = true;"></script>
<script src="{{ asset('js/firestore-auto-fix.js') }}"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-storage-compat.js" onload="window.firebaseStorageLoaded = true;"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js" onload="window.firebaseAuthLoaded = true;"></script>
<script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-database-compat.js" onload="window.firebaseDatabaseLoaded = true;"></script>
<script src="{{ asset('js/geofirestore.js') }}"></script>
<script src="https://cdn.firebase.com/libs/geofire/5.0.1/geofire.min.js"></script>
<script src="{{ asset('js/chosen.jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="{{ asset('js/jquery.masking.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
    // Firebase configuration - Load from .env file
    var firebaseConfig = {
        apiKey: "{{ env('FIREBASE_APIKEY', 'AIzaSyCkywqfrDAEwt_WpeaTQlb6WD72zT1agzk') }}",
        authDomain: "{{ env('FIREBASE_AUTH_DOMAIN', 'foodgo-e1252.firebaseapp.com') }}",
        projectId: "{{ env('FIREBASE_PROJECT_ID', 'foodgo-e1252') }}",
        storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET', 'foodgo-e1252.firebasestorage.app') }}",
        messagingSenderId: "{{ env('FIREBASE_MESSAAGING_SENDER_ID', '173178681240') }}",
        appId: "{{ env('FIREBASE_APP_ID', '1:173178681240:web:b869928633af6714a19ded') }}",
        measurementId: "{{ env('FIREBASE_MEASUREMENT_ID', 'G-1TBDGMF2YM') }}"
    };
    
    // Validate Firebase configuration
    if (!firebaseConfig.apiKey || !firebaseConfig.projectId) {
        console.error('❌ Firebase configuration is missing! Please check your .env file.');
    }
    
    // Initialize Firebase when SDK is loaded
    function initializeFirebase() {
        if (typeof firebase === 'undefined') {
            console.warn('⚠️ Firebase SDK not loaded yet');
            return false;
        }
        
        try {
            // Check if Firebase is already initialized
            if (firebase.apps && firebase.apps.length > 0) {
                console.log('ℹ️ Firebase already initialized');
                return true;
            }
            
            // Initialize Firebase
            try {
                firebase.initializeApp(firebaseConfig);
                console.log('✅ Firebase initialized successfully');
                return true;
            } catch (initError) {
                // If Firebase is already initialized, that's okay
                if (initError.code === 'app/duplicate-app') {
                    console.log('ℹ️ Firebase already initialized (duplicate app)');
                    return true;
                }
                throw initError;
            }
        } catch (error) {
            console.error('❌ Firebase initialization error:', error);
            return false;
        }
    }
    
    // Wait for Firebase SDK to load, then initialize
    function waitForFirebaseAndInit() {
        if (typeof firebase !== 'undefined' && typeof firebase.initializeApp === 'function') {
            if (initializeFirebase()) {
                // Firebase initialized successfully, now initialize Firestore
                setTimeout(function() {
                    if (typeof initializeFirestore === 'function') {
                        var retryCount = 0;
                        var maxRetries = 20; // Increased retries for better reliability
                        var tryInitFirestore = function() {
                            if (initializeFirestore()) {
                                console.log('✅ Firestore initialized and ready!');
                                // Trigger custom event for other scripts
                                if (typeof window.dispatchEvent !== 'undefined') {
                                    window.dispatchEvent(new CustomEvent('firestoreReady'));
                                }
                                return; // Success
                            }
                            retryCount++;
                            if (retryCount < maxRetries) {
                                setTimeout(tryInitFirestore, 200);
                            } else {
                                console.error('❌ Firestore not initialized after ' + maxRetries + ' retries');
                                // Show user-friendly error
                                if (typeof jQuery !== 'undefined') {
                                    jQuery("#data-table_processing").hide();
                                }
                            }
                        };
                        tryInitFirestore();
                    }
                }, 200);
            }
        } else {
            // Retry after 100ms (max 50 retries = 5 seconds)
            if (window.firebaseInitRetries === undefined) {
                window.firebaseInitRetries = 0;
            }
            if (window.firebaseInitRetries < 50) {
                window.firebaseInitRetries++;
                setTimeout(waitForFirebaseAndInit, 100);
            } else {
                console.error('❌ Firebase SDK failed to load after 5 seconds');
                console.error('Please check your internet connection and Firebase configuration');
                // Show user-friendly error
                if (typeof jQuery !== 'undefined') {
                    jQuery("#data-table_processing").hide();
                }
            }
        }
    }
    
    // Start waiting for Firebase when DOM is ready
    $(document).ready(function() {
        waitForFirebaseAndInit();
    });

    // Initialize Firestore after Firebase is ready
    var database = null;
    var geoFirestore = null;
    var createdAt = null;
    var firestoreInitialized = false;
    
    // Function to initialize Firestore
    function initializeFirestore() {
        if (firestoreInitialized) {
            return true;
        }
        
        try {
            if (typeof firebase === 'undefined') {
                console.warn('⚠️ Firebase not loaded yet');
                return false;
            }
            
            if (!firebase.apps || firebase.apps.length === 0) {
                console.warn('⚠️ Firebase not initialized yet');
                return false;
            }
            
            if (typeof firebase.firestore !== 'function') {
                console.warn('⚠️ Firestore SDK not loaded yet');
                return false;
            }
            
            database = firebase.firestore();
            if (!database) {
                console.warn('⚠️ Firestore database not available');
                return false;
            }
            
            // Disable offline persistence to avoid multi-tab conflicts
            // If you need offline persistence, enable multi-tab synchronization:
            // database.enablePersistence({ synchronizeTabs: true }).catch(...)
            // For now, we disable it to prevent "failed-precondition" errors
            try {
                // Option 1: Disable persistence completely (recommended for multi-tab usage)
                // No persistence enabled - this prevents the error
                
                // Option 2: Enable with multi-tab sync (uncomment if you need offline support)
                /*
                database.enablePersistence({ 
                    synchronizeTabs: true 
                }).catch(function(err) {
                    if (err.code == 'failed-precondition') {
                        console.warn('⚠️ Firestore persistence failed: Multiple tabs open. Disabling persistence.');
                    } else if (err.code == 'unimplemented') {
                        console.warn('⚠️ Firestore persistence not supported in this browser');
                    } else {
                        console.warn('⚠️ Firestore persistence error:', err);
                    }
                });
                */
            } catch (e) {
                // Ignore persistence errors - offline mode disabled
                console.log('ℹ️ Offline persistence disabled to prevent multi-tab conflicts');
            }
            
            // Initialize GeoFirestore if available
            if (typeof GeoFirestore !== 'undefined') {
                try {
                    geoFirestore = new GeoFirestore(database);
                } catch (e) {
                    console.warn('GeoFirestore initialization failed:', e);
                }
            }
            
            // Create createdAt timestamp safely - wait a bit to ensure Firestore SDK is fully loaded
            setTimeout(function() {
                try {
                    if (typeof firebase !== 'undefined' && firebase.firestore && typeof firebase.firestore.Timestamp !== 'undefined' && firebase.firestore.Timestamp.fromDate) {
                        var createdAtman = firebase.firestore.Timestamp.fromDate(new Date());
                        createdAt = {_nanoseconds: createdAtman.nanoseconds, _seconds: createdAtman.seconds};
                    } else {
                        // Fallback: create timestamp manually
                        var now = new Date();
                        createdAt = {
                            _nanoseconds: (now.getTime() % 1000) * 1000000,
                            _seconds: Math.floor(now.getTime() / 1000)
                        };
                        console.warn('⚠️ Firestore Timestamp not available, using fallback');
                    }
                } catch (e) {
                    // Fallback: create timestamp manually
                    var now = new Date();
                    createdAt = {
                        _nanoseconds: (now.getTime() % 1000) * 1000000,
                        _seconds: Math.floor(now.getTime() / 1000)
                    };
                    console.warn('⚠️ Error creating timestamp, using fallback:', e);
                }
            }, 100);
            
            // Set a default timestamp immediately
            var now = new Date();
            createdAt = {
                _nanoseconds: (now.getTime() % 1000) * 1000000,
                _seconds: Math.floor(now.getTime() / 1000)
            };
            
            firestoreInitialized = true;
            console.log('✅ Firestore initialized successfully');
            console.log('✅ Database instance ready:', database ? 'Yes' : 'No');
            
            // Make database available globally
            window.firestoreDatabase = database;
            window.database = database; // Also set for backward compatibility
            
            // Test connection with a simple query
            try {
                database.collection('settings').limit(1).get().then(function() {
                    console.log('✅ Firestore connection test successful');
                    console.log('✅ Ready to interact with Firestore database');
                }).catch(function(err) {
                    console.error('❌ Firestore connection test failed:', err);
                    if (err.code === 'permission-denied') {
                        console.error('❌ PERMISSION DENIED!');
                        console.error('❌ Please update Firestore Rules in Firebase Console');
                        console.error('❌ Go to: Firebase Console → Firestore Database → Rules');
                        console.error('❌ Use these rules for development:');
                        console.error(`
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    match /{document=**} {
      allow read, write: if true;
    }
  }
}
                        `);
                    } else {
                        console.error('❌ Error code:', err.code);
                        console.error('❌ Error message:', err.message);
                    }
                });
            } catch (e) {
                console.error('❌ Could not test Firestore connection:', e);
            }
            
            // Load settings from Firestore (non-blocking)
            loadFirestoreSettings();
            
            // Load map type after database is ready
            loadMapType();
            
            return true;
        } catch (error) {
            console.error('❌ Firestore initialization error:', error);
            return false;
        }
    }
    
    // Helper function to get Firestore database (for use in other pages)
    window.getFirestoreDatabase = function() {
        if (database) {
            return database;
        }
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
    
    // Helper function to wait for Firestore and execute callback
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
    
    // Firestore initialization is triggered automatically after Firebase is initialized
    
    // Load settings from Firestore (non-blocking, won't block page load)
    function loadFirestoreSettings() {
        if (!database) return;
        
        // Load global settings
        database.collection('settings').doc("globalSettings").get().then(function (snapshots) {
            try {
                var globalSettings = snapshots.data();
                if (globalSettings && globalSettings.appLogo) {
                    $("#logo_web").attr('src', globalSettings.appLogo);
                }
                if (globalSettings && globalSettings.meta_title) {
                    if (getCookie('meta_title') == undefined || getCookie('meta_title') == null || getCookie('meta_title') == "") {
                        document.title = globalSettings.meta_title;
                        setCookie('meta_title', globalSettings.meta_title, 365);
                    }
                }
            } catch (error) {
                console.error('Error loading global settings:', error);
            }
        }).catch(function(error) {
            console.error('Error fetching global settings:', error);
        });

        // Load distance settings
        database.collection('settings').doc("RestaurantNearBy").get().then(function (snapshots) {
            try {
                var data = snapshots.data();
                if (data && data.distanceType) {
                    var distanceType = data.distanceType.charAt(0).toUpperCase() + data.distanceType.slice(1);
                    $('#distanceType').val(distanceType);
                    $('.global_distance_type').html(distanceType);
                }
            } catch (error) {
                console.error('Error loading distance settings:', error);
            }
        }).catch(function(error) {
            console.error('Error fetching distance settings:', error);
        });

        // Load languages
        var langcount = 0;
        database.collection('settings').doc('languages').get().then(function (snapshotslang) {
            try {
                var langData = snapshotslang.data();
                if (langData != undefined && langData.list) {
                    window.languages_list_main = langData.list;
                    langData.list.forEach((data) => {
                        if (data.isActive == true) {
                            langcount++;
                            $('#language_dropdown').append($("<option></option>").attr("value", data.slug).text(data.title));
                        }
                    });
                    if (langcount > 1) {
                        $("#language_dropdown_box").css('visibility', 'visible');
                    }
                    <?php if (session()->get('locale')) { ?>
                    $("#language_dropdown").val("<?php    echo session()->get('locale'); ?>");
                    <?php } ?>
                }
            } catch (error) {
                console.error('Error loading languages:', error);
            }
        }).catch(function(error) {
            console.error('Error fetching languages:', error);
        });

        // Load version
        database.collection('settings').doc("Version").get().then(function (snapshots) {
            try {
                var version_data = snapshots.data();
                if (version_data == undefined) {
                    database.collection('settings').doc('Version').set({}).catch(function(e) {
                        console.error('Error creating version doc:', e);
                    });
                } else if (version_data.web_version) {
                    $('.web_version').html("V:" + version_data.web_version);
                }
            } catch (error) {
                console.error('Error loading version:', error);
            }
        }).catch(function(error) {
            console.error('Error fetching version:', error);
        });
        
        // Load notification settings
        database.collection('settings').doc("notification_setting").get().then(function (snapshots) {
            try {
                var data = snapshots.data();
                if(data != undefined){
                    var serviceJson = data.serviceJson;
                    if(serviceJson != '' && serviceJson != null){
                        $.ajax({
                            type: 'POST',
                            data: {
                                serviceJson: btoa(serviceJson),
                            },
                            url: "{{ route('store-firebase-service') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) {
                                // Success
                            },
                            error: function(error) {
                                console.error('Error storing Firebase service:', error);
                            }
                        });
                    }
                }
            } catch (error) {
                console.error('Error loading notification settings:', error);
            }
        }).catch(function(error) {
            console.error('Error fetching notification settings:', error);
        });
    }
    
    // Firestore initialization will be triggered by initFirestoreAfterFirebase
    // which is called after Firebase is initialized

    var url = "{{ route('changeLang') }}";

    $(".changeLang").change(function () {
        if (typeof window.languages_list_main !== 'undefined' && window.languages_list_main) {
            var slug = $(this).val();
            window.languages_list_main.forEach((data) => {
                if (slug == data.slug) {
                    if (data.is_rtl == undefined) {
                        setCookie('is_rtl', 'false', 365);
                    } else {
                        setCookie('is_rtl', data.is_rtl.toString(), 365);
                    }
                    window.location.href = url + "?lang=" + slug;
                }
            });
        }
    });

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    async function sendEmail(url, subject, message, recipients) {

        var checkFlag = false;

        await $.ajax({

            type: 'POST',
            data: {
                subject: subject,
                message: message,
                recipients: recipients
            },
            url: url,
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                checkFlag = true;
            },
            error: function (xhr, status, error) {
                checkFlag = true;
            }
        });

        return checkFlag;

    }
    function exportData(dt, format, config) {
        const {
            columns,              
            fileName = 'Export',    
        } = config;

        const filteredRecords = dt.ajax.json().filteredData;

        const fieldTypes = {};
        const dataMapper = (record) => {
            return columns.map((col) => {
                const value = record[col.key];
                if (!fieldTypes[col.key]) {
                    if (value === true || value === false) {
                        fieldTypes[col.key] = 'boolean';
                    } else if (value && typeof value === 'object' && value.seconds) {
                        fieldTypes[col.key] = 'date'; 
                    } else if (typeof value === 'number') {
                        fieldTypes[col.key] = 'number';
                    } else if (typeof value === 'string') {
                        fieldTypes[col.key] = 'string';
                    } else {
                        fieldTypes[col.key] = 'string'; 
                    }
                }

                switch (fieldTypes[col.key]) {
                    case 'boolean':
                        return value ? 'Yes' : 'No'; 
                    case 'date':
                        return value ? new Date(value.seconds * 1000).toLocaleString() : '-';
                    case 'number':
                        return typeof value === 'number' ? value : 0;
                    case 'string':
                    default:
                        return value || '-';
                }
            });
        };

        const tableData = filteredRecords.map(dataMapper);
        const data = [columns.map(col => col.header), ...tableData];
        const columnWidths = columns.map((_, colIndex) =>
            Math.max(...data.map(row => row[colIndex]?.toString().length || 0))
        );

        if (format === 'csv') {
            const csv = data.map(row => row.map(cell => {
                if (typeof cell === 'string' && (cell.includes(',') || cell.includes('\n') || cell.includes('"'))) {
                    return `"${cell.replace(/"/g, '""')}"`;
                }
                return cell;
            }).join(',')).join('\n');

            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            saveAs(blob, `${fileName}.csv`);
        } else if (format === 'excel') {
            const ws = XLSX.utils.aoa_to_sheet(data, { cellDates: true });

            ws['!cols'] = columnWidths.map(width => ({ wch: Math.min(width + 5, 30) })); 

            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Data');
            XLSX.writeFile(wb, `${fileName}.xlsx`);
        } else if (format === 'pdf') {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const totalLength = columnWidths.reduce((sum, length) => sum + length, 0);
            const columnStyles = {};
            columnWidths.forEach((length, index) => {
                columnStyles[index] = {
                    cellWidth: (length / totalLength) * 180, 
                };
            });

            doc.setFontSize(16);
            doc.text(fileName, 14, 16);

            doc.autoTable({
                head: [columns.map(col => col.header)],
                body: tableData,
                startY: 20,
                theme: 'striped',
                styles: {
                    cellPadding: 2,
                    fontSize: 10,
                },
                columnStyles,
                margin: { top: 30, bottom: 30 },
                didDrawPage: function (data) {
                    doc.setFontSize(10);
                    doc.text(fileName, data.settings.margin.left, 10);
                }
            });
            doc.save(`${fileName}.pdf`);
        } else {
            console.error('Unsupported format');
        }
    }


    var mapType = 'ONLINE';
    
    // Function to load map type from Firestore (non-blocking)
    function loadMapType() {
        if (!database) {
            return; // Use default ONLINE
        }
        database.collection('settings').doc('DriverNearBy').get().then(function (snapshots) {
            try {
                var data = snapshots.data();
                if (data && data.selectedMapType && data.selectedMapType == "osm") {
                    mapType = "OFFLINE";
                }
            } catch (error) {
                console.error('Error loading map type:', error);
            }
        }).catch(function(error) {
            console.error('Error fetching map type:', error);
        });
    }
    
    // Global callback function for Google Maps initialization
    window.initGoogleMaps = function() {
        console.log('✅ Google Maps API initialized successfully');
        // Only request geolocation if user has interacted with page
        if (document.hasFocus()) {
            navigator.geolocation.getCurrentPosition(GeolocationSuccessCallback,GeolocationErrorCallback);
        }
        if(typeof window['InitializeGodsEyeMap'] === 'function') { 
            InitializeGodsEyeMap();
        }
    };
    
    // Global error handler for Google Maps API errors
    window.gm_authFailure = function() {
        console.error('❌ Google Maps API authentication failed. Please check your API key.');
        alert('Google Maps API authentication failed. Please check your API key in .env file (GEO_API_KEY) and ensure:\n1. The API key is correct\n2. Maps JavaScript API is enabled in Google Cloud Console\n3. The API key has proper restrictions configured.');
    };

    async function loadGoogleMapsScript() {
        // First, try to get API key from .env file (GEO_API_KEY or GOOGLE_MAPS_API_KEY)
        // Default value: AIzaSyB46gP1VJUFN5BZQRf7d8QcgLi0mnNGaeQ
        var googleMapKey = '{{ env("GEO_API_KEY", env("GOOGLE_MAPS_API_KEY", "AIzaSyB46gP1VJUFN5BZQRf7d8QcgLi0mnNGaeQ")) }}';
        
        // If not found in .env or empty, try to get from Firestore
        if (!googleMapKey || googleMapKey === '' || googleMapKey === 'null') {
            if (database) {
                try {
                    var googleMapKeySnapshotsHeader = await database.collection('settings').doc("googleMapKey").get();
                    if (googleMapKeySnapshotsHeader && googleMapKeySnapshotsHeader.exists) {
                        var placeholderImageHeaderData = googleMapKeySnapshotsHeader.data();
                        if (placeholderImageHeaderData && placeholderImageHeaderData.key && placeholderImageHeaderData.key !== 'google_maps_api_key') {
                            googleMapKey = placeholderImageHeaderData.key;
                        }
                    }
                } catch (error) {
                    console.warn('Error loading Google Maps key from Firestore:', error);
                }
            }
        }
        
        const script = document.createElement('script');
        script.async = true;
        script.defer = true;

        if (mapType == "OFFLINE" ){
            script.src = "https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"; 
            script.onload = function() {
                // Load additional leaflet scripts sequentially
                var scripts = [
                    "https://unpkg.com/leaflet-draw/dist/leaflet.draw.js",
                    "https://cdnjs.cloudflare.com/ajax/libs/leaflet-editable/0.7.3/leaflet.editable.min.js",
                    "https://unpkg.com/leaflet-draw@0.4.14/dist/leaflet.draw-src.js",
                    "https://unpkg.com/leaflet-ajax/dist/leaflet.ajax.min.js",
                    "https://unpkg.com/leaflet-geojson-layer/src/leaflet.geojson.js",
                    "https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"
                ];
                var loadScript = function(index) {
                    if (index >= scripts.length) {
                        // Only request geolocation if user has interacted
                        if (document.hasFocus()) {
                            navigator.geolocation.getCurrentPosition(GeolocationSuccessCallback,GeolocationErrorCallback);
                        }
                        if(typeof window['InitializeGodsEyeMap'] === 'function') { 
                            InitializeGodsEyeMap();
                        }
                        return;
                    }
                    var s = document.createElement('script');
                    s.src = scripts[index];
                    s.async = true;
                    s.onload = function() { loadScript(index + 1); };
                    document.head.appendChild(s);
                };
                loadScript(0);
            };
        } else {
            if (googleMapKey && googleMapKey !== '' && googleMapKey !== 'null') {
                // Use API key with callback for error handling
                script.src = "https://maps.googleapis.com/maps/api/js?key=" + googleMapKey + "&libraries=places,drawing&loading=async&callback=initGoogleMaps";
                console.log('✅ Loading Google Maps with API key from .env');
            } else {
                console.warn('⚠️ Google Maps API key not found. Using default key.');
                // Use default API key
                var defaultKey = "AIzaSyB46gP1VJUFN5BZQRf7d8QcgLi0mnNGaeQ";
                script.src = "https://maps.googleapis.com/maps/api/js?key=" + defaultKey + "&libraries=places,drawing&loading=async&callback=initGoogleMaps";
            }
            
            // Add error handler
            script.onerror = function() {
                console.error('❌ Failed to load Google Maps API script');
                alert('Failed to load Google Maps. Please check your API key and ensure Maps JavaScript API is enabled in Google Cloud Console.');
            };
            
            // Note: onload may not fire if callback is used, so we rely on callback function
            script.onload = function () {
                console.log('✅ Google Maps script loaded successfully');
            };
        }
        document.head.appendChild(script);
    }

    const GeolocationSuccessCallback = (position) => {
        if(position.coords != undefined){
            default_latitude = position.coords.latitude
            default_longitude = position.coords.longitude
            setCookie('default_latitude', default_latitude, 365);
            setCookie('default_longitude', default_longitude, 365);
        }
    };

    const GeolocationErrorCallback = (error) => {
        console.log('Error: You denied for your default Geolocation',error.message);
        setCookie('default_latitude', '23.022505', 365);
        setCookie('default_longitude','72.571365', 365);
    };

    // Load Google Maps script (non-blocking, won't wait for Firebase)
    $(document).ready(function() {
        // Load map type first (if database is ready)
        // This will be called automatically when Firestore is initialized
        
        // Try to load Google Maps with key from Firestore, but don't block if it fails
        var loadMapsWithRetry = function(retryCount) {
            retryCount = retryCount || 0;
            
            // Wait for Firestore to be ready (max 3 seconds)
            if (database && retryCount < 6) {
                // Try to get Google Maps key from Firestore
                loadGoogleMapsScript().catch(function(error) {
                    console.warn('Failed to load Google Maps key from Firestore:', error);
                    // Fallback: load without key (will show warning but won't break)
                    loadMapsWithoutKey();
                });
            } else {
                // Load without key as fallback (won't block page)
                console.log('Loading Google Maps without key (Firestore not ready or failed)');
                loadMapsWithoutKey();
            }
        };
        
        // Helper function to load maps without key
        function loadMapsWithoutKey() {
            const script = document.createElement('script');
            script.src = "https://maps.googleapis.com/maps/api/js?libraries=places,drawing&loading=async";
            script.async = true;
            script.defer = true;
            script.onload = function () {
                // Only request geolocation if user has interacted with page
                if (document.hasFocus()) {
                    navigator.geolocation.getCurrentPosition(GeolocationSuccessCallback, GeolocationErrorCallback);
                }
                if(typeof window['InitializeGodsEyeMap'] === 'function') { 
                    InitializeGodsEyeMap();
                }
            };
            script.onerror = function() {
                console.warn('Google Maps script failed to load');
            };
            document.head.appendChild(script);
        }
        
        // Start loading maps (won't block page)
        setTimeout(function() {
            loadMapsWithRetry();
        }, 1000);
    });

    async function sendNotification(fcmToken = '', title, body, payload = null) {
        var checkFlag = false;
        var sendNotificationUrl = "{{ route('send-notification') }}";
        console.log(JSON.stringify(payload));
        if (fcmToken !== '') {
            await $.ajax({
                type: 'POST',
                url: sendNotificationUrl,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    'fcm': fcmToken,
                    'title': title,
                    'message': body,
                    'payload': JSON.stringify(payload)
                },
                success: function (data) {
                    checkFlag = true;
                },
                error: function (error) {
                    checkFlag = true;
                }
            });
        } else {
            checkFlag = true;
        }

        return checkFlag;
    }

    //On delete item delete image also from bucket general code
    const deleteDocumentWithImage = async (collection, id, singleImageField, arrayImageField) => {
        if (!database) {
            console.error('Firestore database not available');
            return;
        }
        // Reference to the Firestore document
        const docRef = database.collection(collection).doc(id);
        try {
            const doc = await docRef.get();
            if (!doc.exists) {
                console.log("No document found for deletion");
                return;
            }

            const data = doc.data();

            // Deleting single image field
            if (singleImageField) {
                if (Array.isArray(singleImageField)) {
                    for (const field of singleImageField) {
                        const imageUrl = data[field];
                        if (imageUrl) await deleteImageFromBucket(imageUrl);
                    }
                } else {
                    const imageUrl = data[singleImageField];
                    if (imageUrl) await deleteImageFromBucket(imageUrl);
                }
            }
            // Deleting array image field
            if (arrayImageField) {
                if (Array.isArray(arrayImageField)) {
                    for (const field of arrayImageField) {
                        const arrayImages = data[field];
                        if (arrayImages && Array.isArray(arrayImages)) {
                            for (const imageUrl of arrayImages) {
                                if (imageUrl) await deleteImageFromBucket(imageUrl);
                            }
                        }
                    }
                } else {
                    const arrayImages = data[arrayImageField];
                    if (arrayImages && Array.isArray(arrayImages)) {
                        for (const imageUrl of arrayImages) {
                            if (imageUrl) await deleteImageFromBucket(imageUrl);
                        }
                    }
                }
            }

                // Deleting images in variants array within item_attribute
            const item_attribute = data.item_attribute || {};  // Access item_attribute
            const variants = item_attribute.variants || [];    // Access variants array inside item_attribute
            if (variants.length > 0) {
                for (const variant of variants) {
                    const variantImageUrl = variant.variant_image;
                    if (variantImageUrl) {
                        await deleteImageFromBucket(variantImageUrl);
                    }
                }
            }

            // Optionally delete the Firestore document after image deletion
            await docRef.delete();
            console.log("Document and images deleted successfully.");
        } catch (error) {
            console.error("Error deleting document and images:", error);
        }
    };

    const deleteImageFromBucket = async (imageUrl) => {
        if (typeof firebase === 'undefined' || !firebase.storage) {
            console.error('Firebase storage not available');
            return;
        }
        try {
            const storageRef = firebase.storage().ref();

            // Check if the imageUrl is a full URL or just a child path
            let oldImageUrlRef;
            if (imageUrl.includes('https://')) {
                // Full URL
                oldImageUrlRef = storageRef.storage.refFromURL(imageUrl);
            } else {
                // Child path, use ref instead of refFromURL
                oldImageUrlRef = storageRef.storage.ref(imageUrl);
            }
            var envBucket = "<?php echo env('FIREBASE_STORAGE_BUCKET'); ?>";
            var imageBucket = oldImageUrlRef.bucket;
            // Check if the bucket name matches
            if (imageBucket === envBucket) {
                // Delete the image
                await oldImageUrlRef.delete();
                console.log("Image deleted successfully.");
            }
        } catch (error) {

        }
    };

</script>

@yield('scripts')

</body>
</html>

    };

</script>

@yield('scripts')

</body>
</html>
