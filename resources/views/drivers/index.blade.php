@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">
                    @if (request()->is('drivers/approved'))
                        @php $type = 'approved'; @endphp
                        {{ trans('lang.approved_drivers') }}
                    @elseif(request()->is('drivers/pending'))
                        @php $type = 'pending'; @endphp
                        {{ trans('lang.approval_pending_drivers') }}
                    @else
                        @php $type = 'all'; @endphp
                        {{ trans('lang.all_drivers') }}
                    @endif
                </h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ trans('lang.dashboard') }}</a></li>
                    <li class="breadcrumb-item active">{{ trans('lang.driver_table') }}</li>
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
                                <span class="icon mr-3"><img src="{{ asset('images/driver.png') }}"></span>
                                <h3 class="mb-0">{{ trans('lang.driver_table') }}</h3>
                                <span class="counter ml-3 driver_count"></span>
                            </div>
                            <div class="d-flex top-title-right align-self-center">
                                <div class="select-box pl-3">
                                    <select class="form-control status_selector filteredRecords">
                                        <option value="" selected>{{ trans('lang.status') }}</option>
                                        <option value="active">{{ trans('lang.active') }}</option>
                                        <option value="inactive">{{ trans('lang.in_active') }}</option>
                                    </select>
                                </div>
                                <div class="select-box pl-3">
                                    <div id="daterange"><i class="fa fa-calendar"></i>&nbsp;
                                        <span></span>&nbsp; <i class="fa fa-caret-down"></i>
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
                                    <h3 class="text-dark-2 mb-2 h4">{{ trans('lang.driver_table') }}</h3>
                                    <p class="mb-0 text-dark-2">{{ trans('lang.drivers_table_text') }}</p>
                                </div>
                                <div class="card-header-right d-flex align-items-center">
                                    <div class="card-header-btn mr-3">
                                        <a class="btn-primary btn rounded-full" href="{!! route('drivers.create') !!}"><i class="mdi mdi-plus mr-2"></i>{{ trans('lang.drivers_create') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive m-t-10">
                                    <table id="driverTable" class="display nowrap table table-hover table-striped table-bordered table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <?php if (($type == "approved" && in_array('approve.driver.delete', json_decode(@session('user_permissions'), true))) || ($type == "pending" && in_array('pending.driver.delete', json_decode(@session('user_permissions'), true))) || ($type == "all" && in_array('driver.delete', json_decode(@session('user_permissions'), true)))) { ?>
                                                <th class="delete-all">
                                                    <input type="checkbox" id="is_active">
                                                    <label class="col-3 control-label" for="is_active">
                                                        <a id="deleteAll" class="do_not_delete" href="javascript:void(0)"><i class="mdi mdi-delete"></i> {{ trans('lang.all') }}</a>
                                                    </label>
                                                </th>
                                                <?php } ?>
                                                <th>{{ trans('lang.user_name') }}</th>
                                                <th>{{ trans('lang.email') }}</th>
                                                <th>{{ trans('lang.date') }}</th>
                                                <th>{{ trans('lang.document_plural') }}</th>
                                                <th>{{ trans('lang.driver_active') }}</th>
                                                <th>{{ trans('lang.driver_online') }}</th>
                                                <th>{{ trans('lang.wallet_history') }}</th>
                                                <th>{{ trans('lang.dashboard_total_orders') }}</th>
                                                <th>{{ trans('lang.actions') }}</th>
                                            </tr>
                                        </thead>
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
        // Debug helper logs added to surface client-side errors and network/XHR failures
        console.log('[DRIVERS] Script start. Type:', "{{ $type }}");
        window.addEventListener('error', function(e) {
            console.error('[Global Error]', e.message || e, e.filename, e.lineno, e.colno, e.error && e.error.stack ? e.error.stack : null);
        });
        window.addEventListener('unhandledrejection', function(e) {
            console.error('[Unhandled Rejection]', e.reason);
        });
        var database = null;
        var type = "{{ $type }}";
        var ref = null;
        var alldriver = null;
        var append_list = '';
        var placeholderImage = '';
        var user_permissions = '<?php echo @session('user_permissions'); ?>';
        try {
            user_permissions = Object.values(JSON.parse(user_permissions));
        } catch (err) {
            console.error('[DRIVERS] Failed to parse user_permissions:', user_permissions, err);
            user_permissions = [];
        }
        var checkDeletePermission = false;
        if (
            (type == 'pending' && $.inArray('pending.driver.delete', user_permissions) >= 0) ||
            (type == 'approved' && $.inArray('approve.driver.delete', user_permissions) >= 0) ||
            (type == 'all' && $.inArray('driver.delete', user_permissions) >= 0)
        ) {
            checkDeletePermission = true;
        }
        
        // Wait for Firestore to be ready
        window.waitForFirestore(function(db) {
            if (!db) {
                console.error('❌ Firestore not available');
                return;
            }
            
            database = db;
            ref = database.collection('users').where("role", "==", "driver");
            if (type == 'pending') {
                ref = database.collection('users').where("role", "==", "driver").where("isDocumentVerify", "==", false);
            } else if (type == 'approved') {
                ref = database.collection('users').where("role", "==", "driver").where("isDocumentVerify", "==", true);
            }
            alldriver = database.collection('users').where("role", "==", "driver");
            
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
                console.warn('Error loading placeholder image:', error);
            });
            
            // Initialize page
            initDriversPage();
        });
        
        function initDriversPage() {
            if (!database) {
                console.error('Database not available');
                return;
            }
            var initialRef = ref;
            
            $('.status_selector').select2({
            placeholder: "{{ trans('lang.select_status') }}",
            minimumResultsForSearch: Infinity,
            allowClear: true
        });
        $('select').on("select2:unselecting", function(e) {
            var self = $(this);
            setTimeout(function() {
                self.select2('close');
            }, 0);
        });

        function setDate() {
            $('#daterange span').html('{{ trans('lang.select_range') }}');
            $('#daterange').daterangepicker({
                autoUpdateInput: false,
            }, function(start, end) {
                $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('.filteredRecords').trigger('change');
            });
            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                $('#daterange span').html(picker.startDate.format('MMMM D, YYYY') + ' - ' + picker.endDate.format('MMMM D, YYYY'));
                $('.filteredRecords').trigger('change');
            });
            $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
                $('#daterange span').html('{{ trans('lang.select_range') }}');
                $('.filteredRecords').trigger('change');
            });
        }
        setDate();
        $('.filteredRecords').change(async function() {
            var status = $('.status_selector').val();
            var daterangepicker = $('#daterange').data('daterangepicker');
            var refData = initialRef;
            if (status) {
                refData = (status === "active") ?
                    refData.where('active', '==', true) :
                    refData.where('active', '==', false);
            }
            if ($('#daterange span').html() != '{{ trans('lang.select_range') }}' && daterangepicker) {
                var from = moment(daterangepicker.startDate).toDate();
                var to = moment(daterangepicker.endDate).toDate();
                if (from && to) {
                    var fromDate = firebase.firestore.Timestamp.fromDate(new Date(from));
                    refData = refData.where('createdAt', '>=', fromDate);
                    var toDate = firebase.firestore.Timestamp.fromDate(new Date(to));
                    refData = refData.where('createdAt', '<=', toDate);
                }
            }
            ref = refData;
            $('#driverTable').DataTable().ajax.reload();
        });
        $(document).ready(function() {
            console.log('[DRIVERS] document ready. type:', type);
            // Global AJAX error logging (jQuery)
            $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
                try {
                    var responseText = jqxhr && jqxhr.responseText ? jqxhr.responseText.substring(0, 3000) : '';
                } catch (e) {
                    var responseText = '';
                }
                console.error('[AJAX ERROR]', settings && settings.url, 'status:', jqxhr && jqxhr.status, 'error:', thrownError, 'responseTextPreview:', responseText);
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
                        key: 'fullName',
                        header: "{{ trans('lang.user_name') }}"
                    },
                    {
                        key: 'email',
                        header: "{{ trans('lang.email') }}"
                    },
                    {
                        key: 'active',
                        header: "{{ trans('lang.driver_active') }}"
                    },
                    {
                        key: 'createdAt',
                        header: "{{ trans('lang.created_at') }}"
                    },
                ],
                fileName: "{{ trans('lang.driver_table') }}",
            };
            const table = $('#driverTable').DataTable({
                pageLength: 10, // Number of rows per page
                processing: false, // Show processing indicator
                serverSide: true, // Enable server-side processing
                responsive: true,
                ajax: function(data, callback, settings) {
                    const start = data.start;
                    const length = data.length;
                    const searchValue = data.search.value.toLowerCase();
                    const orderColumnIndex = data.order[0].column;
                    const orderDirection = data.order[0].dir;
                    const orderableColumns = (checkDeletePermission) ? ['', 'fullName', 'email', 'createdAt', '', '', '', '', '', ''] : ['fullName', 'email', 'createdAt', '', '', '', '', '', ''];
                    const orderByField = orderableColumns[orderColumnIndex]; // Adjust the index to match your table
                    if (searchValue.length >= 3 || searchValue.length === 0) {
                        $('#data-table_processing').show();
                    }
                    // Try with orderBy, fallback to without if index doesn't exist
                    var queryPromise = ref.orderBy('createdAt', 'desc').get().catch(function(error) {
                        if (error.code === 'failed-precondition') {
                            console.warn('⚠️ Index required. Using query without orderBy. Create index:', error.message);
                            // Fallback: get without orderBy and sort in memory
                            return ref.get();
                        }
                        throw error;
                    });
                    
                    queryPromise.then(async function(querySnapshot) {
                        if (querySnapshot.empty) {
                            $('.driver_count').text(0);
                            console.error("No data found in Firestore.");
                            $('#data-table_processing').hide(); // Hide loader
                            callback({
                                draw: data.draw,
                                recordsTotal: 0,
                                recordsFiltered: 0,
                                filteredData: [],
                                data: [] // No data
                            });
                            return;
                        }
                        let records = [];
                        let filteredRecords = [];
                        querySnapshot.forEach(function(doc) {
                            let childData = doc.data();
                            if (!childData.hasOwnProperty('vendorID') || (childData.hasOwnProperty('vendorID') && (childData.vendorID=='' || childData.vendorID==null))) {
                                childData.id = doc.id; // Ensure the document ID is included in the data
                                childData.fullName = childData.firstName + ' ' + childData.lastName || " "
                                childData.email = shortEmail(childData.email);
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
                                        (childData.fullName && childData.fullName.toString().toLowerCase().includes(searchValue)) ||
                                        (createdAt && createdAt.toString().toLowerCase().indexOf(searchValue) > -1) || (childData.email && childData.email.toString().includes(searchValue))
                                    ) {
                                        filteredRecords.push(childData);
                                    }
                                } else {
                                    filteredRecords.push(childData);
                                }
                            }
                        });
                        filteredRecords.sort((a, b) => {
                            let aValue = a[orderByField] ? a[orderByField].toString().toLowerCase() : '';
                            let bValue = b[orderByField] ? b[orderByField].toString().toLowerCase() : '';
                            if (orderByField === 'createdAt') {
                                aValue = a[orderByField] ? new Date(a[orderByField].toDate()).getTime() : 0;
                                bValue = b[orderByField] ? new Date(b[orderByField].toDate()).getTime() : 0;
                            }
                            if (orderDirection === 'asc') {
                                return (aValue > bValue) ? 1 : -1;
                            } else {
                                return (aValue < bValue) ? 1 : -1;
                            }
                        });
                        const totalRecords = filteredRecords.length;
                        $('.driver_count').text(totalRecords);
                        const paginatedRecords = filteredRecords.slice(start, start + length);
                        await Promise.all(paginatedRecords.map(async (childData) => {
                            if (childData.id) {
                                const totalOrderSnapShot = await database.collection('restaurant_orders').where('driverID', '==', childData.id).get();
                                const orders = totalOrderSnapShot.size;
                                childData.orders = orders;
                            } else {
                                childData.orders = 0;
                            }
                        }));
                        paginatedRecords.forEach(function(childData) {
                            var id = childData.id;
                            var route1 = '{{ route('drivers.edit', ':id') }}';
                            route1 = route1.replace(':id', id);
                            var driverView = '{{ route('drivers.view', ':id') }}';
                            driverView = driverView.replace(':id', id);
                            document_list_view = "{{ route('drivers.document', ':id') }}";
                            document_list_view = document_list_view.replace(':id', childData.id);
                            var trroute2 = '{{ route('orders', ':id') }}';
                            trroute2 = trroute2.replace(':id', 'driverId=' + id);
                            var walletTransactions = '{{ route('users.walletstransaction', ':id') }}';
                            walletTransactions = walletTransactions.replace(':id', id);
                            var date = '';
                            var time = '';
                            if (childData.hasOwnProperty("createdAt")) {
                                try {
                                    date = childData.createdAt.toDate().toDateString();
                                    time = childData.createdAt.toDate().toLocaleTimeString('en-US');
                                } catch (err) {}
                            }
                            var driverImage = childData.profilePictureURL == '' || childData.profilePictureURL == null ? '<img alt="" width="100%" style="width:70px;height:70px;" src="' + placeholderImage + '" alt="image">' : '<img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="" width="100%" style="width:70px;height:70px;" src="' + childData.profilePictureURL + '" alt="image">';
                            var chatViewRoute = "{{ route('drivers.chat', ':id') }}".replace(':id', childData.id);
                            var unreadHtml = '';
                            records.push([
                                checkDeletePermission ? '<td class="delete-all"><input type="checkbox" id="is_open_' + childData.id + '" class="is_open" dataId="' + childData.id + '"><label class="col-3 control-label"\n' + 'for="is_open_' + childData.id + '" ></label></td>' : '',
                                driverImage + '<a href="' + driverView + '" class="redirecttopage">' + childData.fullName + '</a>',
                                childData.email ? childData.email : ' ',
                                date + ' ' + time,
                                '<a href="' + document_list_view + '"><i class="fa fa-file"></i></a>',
                                childData.active ? '<label class="switch"><input type="checkbox" checked id="' + childData.id + '" name="isActive"><span class="slider round"></span></label>' : '<label class="switch"><input type="checkbox" id="' + childData.id + '" name="isActive"><span class="slider round"></span></label>',
                                childData.isActive ? '<label class="switch"><input type="checkbox" checked id="' + childData.id + '" name="isOnline"><span class="slider round"></span></label>' : '<label class="switch"><input type="checkbox" id="' + childData.id + '" name="isOnline"><span class="slider round"></span></label>',
                                '<a href="' + walletTransactions + '">{{ trans('lang.wallet_history') }}</a>',
                                '<a href="' + trroute2 + '">' + childData.orders + '</a>',
                                (function() {
                                    var currentStatus = childData.approvalStatus || 'waiting';
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
                                    var actionHtml = '<span class="action-btn">';
                                    actionHtml += '<a href="' + driverView + '"><i class="mdi mdi-eye"></i></a>';
                                    actionHtml += '<div class="dropdown" style="display: inline-block;">' +
                                        '<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" driver_id="' + childData.id + '" approval_status="' + currentStatus + '" name="driver-status-dropdown" title="Change Status">' +
                                        '<i class="mdi ' + statusIcon + '" style="color: ' + statusColor + '; font-size: 18px;"></i></a>' +
                                        '<ul class="dropdown-menu status-dropdown-menu" role="menu">' +
                                        '<li><a href="javascript:void(0)" class="status-option-driver-list" data-status="waiting" data-driver-id="' + childData.id + '"><i class="mdi mdi-clock-outline" style="color: #ffc107;"></i> Waiting</a></li>' +
                                        '<li><a href="javascript:void(0)" class="status-option-driver-list" data-status="rejected" data-driver-id="' + childData.id + '"><i class="mdi mdi-close-circle" style="color: #dc3545;"></i> Rejected</a></li>' +
                                        '<li><a href="javascript:void(0)" class="status-option-driver-list" data-status="approved" data-driver-id="' + childData.id + '"><i class="mdi mdi-check-circle" style="color: #2c9653;"></i> Approved</a></li>' +
                                        '</ul></div>';
                                    if (user_permissions && user_permissions.includes('driver.delete')) {
                                        actionHtml += '<a id="' + childData.id + '" name="driver-delete" class="delete-btn" href="javascript:void(0)"><i class="mdi mdi-delete"></i></a>';
                                    }
                                    if (user_permissions && user_permissions.includes('drivers.chat')) {
                                        actionHtml += '<a href="' + chatViewRoute + '" class="chat-message" style="position: relative; display: inline-block;">' +
                                            '<i class="mdi mdi-wechat mdi-24px"></i>' + unreadHtml + '</a>';
                                    }
                                    actionHtml += '</span>';
                                    return actionHtml;
                                })()
                            ]);
                        });
                        $('#data-table_processing').hide(); // Hide loader
                        callback({
                            draw: data.draw,
                            recordsTotal: totalRecords, // Total number of records in Firestore
                            recordsFiltered: totalRecords, // Number of records after filtering (if any)
                            filteredData: filteredRecords,
                            data: records // The actual data to display in the table
                        });
                    }).catch(function(error) {
                        console.error('❌ [DRIVERS] ========================================');
                        console.error('❌ [DRIVERS] Error fetching data from Firestore');
                        console.error('❌ [DRIVERS] ========================================');
                        console.error('❌ [DRIVERS] Error Code:', error && error.code);
                        console.error('❌ [DRIVERS] Error Message:', error && error.message);
                        console.error('❌ [DRIVERS] Full error object:', error);
                        if (error && error.stack) {
                            console.error('❌ [DRIVERS] Stack trace:', error.stack);
                        }
                        
                        if (error.code === 'permission-denied') {
                            console.error('🚫 [DRIVERS] ========================================');
                            console.error('🚫 [DRIVERS] PERMISSION DENIED ERROR!');
                            console.error('🚫 [DRIVERS] ========================================');
                            console.error('🚫 [DRIVERS] Firestore Rules are blocking access!');
                            console.error('🚫 [DRIVERS] Collection: /users');
                            console.error('🚫 [DRIVERS] Query: role == "driver"');
                            console.error('🚫 [DRIVERS] Solution:');
                            console.error('   1. Go to Firebase Console → Firestore → Rules');
                            console.error('   2. Ensure rules allow read: match /users/{document=**} { allow read: if true; }');
                            console.error('   3. Deploy rules: firebase deploy --only firestore:rules');
                        } else if (error.code === 'failed-precondition') {
                            console.error('🚫 [DRIVERS] ========================================');
                            console.error('🚫 [DRIVERS] INDEX REQUIRED!');
                            console.error('🚫 [DRIVERS] ========================================');
                            console.error('🚫 [DRIVERS] Required Index: users/role + createdAt');
                            console.error('🚫 [DRIVERS] Solution:');
                            console.error('   1. Go to Firebase Console → Firestore → Indexes');
                            console.error('   2. Create index: users collection, role (Ascending), createdAt (Descending)');
                            console.error('   3. Or deploy: firebase deploy --only firestore:indexes');
                        }
                        
                        $('#data-table_processing').hide(); // Hide loader
                        callback({
                            draw: data.draw,
                            recordsTotal: 0,
                            recordsFiltered: 0,
                            filteredData: [],
                            data: [] // No data due to error
                        });
                    });
                },
                order: (checkDeletePermission) ? [3, 'desc'] : [2, 'desc'],
                columnDefs: [{
                        targets: (checkDeletePermission) ? 3 : 2,
                        type: 'date',
                        render: function(data) {
                            return data;
                        }
                    },
                    {
                        orderable: false,
                        targets: (checkDeletePermission) ? [0, 4, 5, 6, 7, 8, 9] : [3, 4, 5, 6, 7, 8]
                    },
                ],
                "language": {
                    "zeroRecords": "{{ trans('lang.no_record_found') }}",
                    "emptyTable": "{{ trans('lang.no_record_found') }}",
                    "processing": "" // Remove default loader
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
                    $(".dataTables_filter").append($(".dt-buttons").detach());
                    $('.dataTables_filter input').attr('placeholder', 'Search here...').attr('autocomplete', 'new-password').val('');
                    $('.dataTables_filter label').contents().filter(function() {
                        return this.nodeType === 3;
                    }).remove();
                }
            });
            table.columns.adjust().draw();

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
            alldriver.get().then(async function(snapshotsdriver) {
                snapshotsdriver.docs.forEach((listval) => {
                    database.collection('restaurant_orders').where('driverID', '==', listval.id).where("status", "in", ["Order Completed"]).get().then(async function(orderSnapshots) {
                        var count_order_complete = orderSnapshots.docs.length;
                        database.collection('users').doc(listval.id).update({
                            'orderCompleted': count_order_complete
                        }).then(function(result) {});
                    });
                });
            });
        });
        async function orderDetails(driver) {
            var count_order_complete = 0;
            await database.collection('restaurant_orders').where('driverID', '==', driver).get().then(async function(orderSnapshots) {
                count_order_complete = orderSnapshots.docs.length;
            });
            return count_order_complete;
        }
        $(document).on("click", "input[name='isOnline']", async function(e) {
            var ischeck = $(this).is(':checked');
            var id = this.id;
            var switchElement = $(this);
            if (ischeck) {
                await database.collection('users').where('id', '==', id).get().then(async function(snapshot) {
                    var data = snapshot.docs[0].data();
                    if (data.isDocumentVerify == false) {
                        switchElement.prop('checked', false);
                        alert('{{ trans('lang.document_verification_is_pending') }}');
                        return false;
                    } else {
                        database.collection('users').doc(id).update({
                            'isActive': true
                        }).then(function(result) {});
                    }
                })
            } else {
                database.collection('users').doc(id).update({
                    'isActive': false
                }).then(function(result) {});
            }
        });
        $(document).on("click", "input[name='isActive']", function(e) {
            jQuery("#data-table_processing").show();
            var ischeck = $(this).is(':checked');
            var id = this.id;
            if (ischeck) {
                database.collection('users').doc(id).update({
                    'active': true
                }).then(function(result) {
                    jQuery("#data-table_processing").hide();
                });
            } else {
                database.collection('users').doc(id).update({
                    'active': false
                }).then(function(result) {
                    jQuery("#data-table_processing").hide();
                });
            }
        });
        $("#is_active").click(function() {
            $("#driverTable .is_open").prop('checked', $(this).prop('checked'));
        });
        $("#deleteAll").click(function() {
            if ($('#driverTable .is_open:checked').length) {
                if (confirm("{{ trans('lang.selected_delete_alert') }}")) {
                    jQuery("#data-table_processing").show();
                    $('#driverTable .is_open:checked').each(async function() {
                        var dataId = $(this).attr('dataId');
                        await deleteDocumentWithImage('users', dataId, 'profilePictureURL');
                        const getStoreName = deleteDriverData(dataId);
                        setTimeout(function() {
                            window.location.reload();
                        }, 7000);
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
        $(document).on("click", "a[name='driver-delete']", async function(e) {
            var id = this.id;
            await deleteDocumentWithImage('users', id, 'profilePictureURL');
            deleteDriverData(id).then(function() {
                setTimeout(function() {
                    window.location.reload();
                }, 9000);
            });
        });
        async function deleteDriverData(driverId) {
            //delete user from authentication  
            var dataObject = {
                "data": {
                    "uid": driverId
                }
            };
            var projectId = '<?php echo env('FIREBASE_PROJECT_ID'); ?>';
            jQuery.ajax({
                url: 'https://us-central1-' + projectId + '.cloudfunctions.net/deleteUser',
                method: 'POST',
                contentType: "application/json; charset=utf-8",
                data: JSON.stringify(dataObject),
                success: function(data) {
                    console.log('Delete user success:', data.result);
                },
                error: function(xhr, status, error) {
                    var responseText = JSON.parse(xhr.responseText);
                    console.log('Delete user error:', responseText.error);
                }
            });
            await database.collection('wallet').where('user_id', '==', driverId).get().then(async function(snapshotsItem) {
                if (snapshotsItem.docs.length > 0) {
                    snapshotsItem.docs.forEach((temData) => {
                        var item_data = temData.data();
                        database.collection('wallet').doc(item_data.id).delete().then(function() {});
                    });
                }
            });
            await database.collection('driver_payouts').where('driverID', '==', driverId).get().then(async function(snapshotsItem) {
                if (snapshotsItem.docs.length > 0) {
                    snapshotsItem.docs.forEach((temData) => {
                        var item_data = temData.data();
                        database.collection('driver_payouts').doc(item_data.id).delete().then(function() {});
                    });
                }
            });
        }

        function searchclear() {
            jQuery("#search").val('');
            searchtext();
        }
        
        // Status Change Handler for Drivers
        $(document).on("click", "a[name='driver-status-change']", async function(e) {
            e.preventDefault();
            var driverId = $(this).attr('driver_id');
            var currentStatus = $(this).attr('approval_status') || 'waiting';
            
            var statusOptions = ['waiting', 'rejected', 'approved'];
            var statusLabels = {
                'waiting': 'Waiting',
                'rejected': 'Rejected',
                'approved': 'Approved'
            };
            
            var currentIndex = statusOptions.indexOf(currentStatus);
            var nextIndex = (currentIndex + 1) % statusOptions.length;
            var nextStatus = statusOptions[nextIndex];
            
            if (!confirm('Change status from ' + statusLabels[currentStatus] + ' to ' + statusLabels[nextStatus] + '?')) {
                return;
            }
            
            jQuery("#data-table_processing").show();
            
            try {
                if (database) {
                    await database.collection('users').doc(driverId).update({
                        'approvalStatus': nextStatus
                    });
                    alert('Status changed to ' + statusLabels[nextStatus]);
                    if ($.fn.DataTable.isDataTable('#driverTable')) {
                        $('#driverTable').DataTable().ajax.reload(null, false);
                    }
                }
            } catch (error) {
                console.error('❌ Error changing driver status:', error);
                alert('Error changing status: ' + error.message);
            } finally {
                jQuery("#data-table_processing").hide();
            }
        });
        
        } // End of initDriversPage
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
