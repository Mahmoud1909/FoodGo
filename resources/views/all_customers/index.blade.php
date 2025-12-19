@extends('layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">All Customers</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">All Customers List</li>
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
                        <span class="icon mr-3"><img src="{{ asset('images/users.png') }}"></span>
                        <h3 class="mb-0">All Customers</h3>
                        <span class="counter ml-3 total_count"></span>
                    </div>
                    <div class="d-flex top-title-right align-self-center">
                        <div class="select-box pl-3">
                            <select class="form-control status_selector filteredRecords">
                                <option value="">{{trans("lang.status")}}</option>
                                <option value="active"  >{{trans("lang.active")}}</option>
                                <option value="inactive"  >{{trans("lang.in_active")}}</option>
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
                    <h3 class="text-dark-2 mb-2 h4">All Customers List</h3>
                    <p class="mb-0 text-dark-2">View and manage all customers</p>
                   </div>
                 </div>
                 <div class="card-body">
                         <div class="table-responsive m-t-10">
                            <table id="allCustomersTable"
                                   class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>{{trans('lang.user_info')}}</th>
                                    <th>{{trans('lang.email')}}</th>
                                    <th>{{trans('lang.date')}}</th>
                                    <th>{{trans('lang.active')}}</th>
                                    <th>{{trans('lang.actions')}}</th>
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
    var database = null;
    var ref = null;
    var placeholderImage = '';
    var allCustomersPageInitialized = false;
    
    // Wait for Firestore to be ready
    window.waitForFirestore(function(db) {
        if (!db) {
            console.error('❌ Firestore not available');
            return;
        }
        
        database = db;
        ref = database.collection('users').where("type", "in", ["Normal", "customer", "employee"]);
        
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
        if (!allCustomersPageInitialized) {
            allCustomersPageInitialized = true;
            initAllCustomersPage();
        }
    });
    
    function initAllCustomersPage() {
        if (!database) {
            console.error('Database not available');
            return;
        }
        
        $('.status_selector').select2({
            placeholder: '{{trans("lang.status")}}',  
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
        $('#daterange span').html('{{trans("lang.select_range")}}');
        $('#daterange').daterangepicker({
            autoUpdateInput: false, 
        }, function (start, end) {
            $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('.filteredRecords').trigger('change'); 
        });
        $('#daterange').on('apply.daterangepicker', function (ev, picker) {
            $('#daterange span').html(picker.startDate.format('MMMM D, YYYY') + ' - ' + picker.endDate.format('MMMM D, YYYY'));
            $('.filteredRecords').trigger('change');
        });
        $('#daterange').on('cancel.daterangepicker', function (ev, picker) {
            $('#daterange span').html('{{trans("lang.select_range")}}');
            $('.filteredRecords').trigger('change'); 
        });
    }
    setDate(); 
        $('.filteredRecords').change(async function() {
            if (!database) {
                console.error('Database not available');
                return;
            }
            var status = $('.status_selector').val();
            var daterangepicker = $('#daterange').data('daterangepicker');
            ref = database.collection('users').where("type", "in", ["Normal", "customer", "employee"]);
        if ($('#daterange span').html() != '{{trans("lang.select_range")}}' && daterangepicker) {
            var from = moment(daterangepicker.startDate).toDate();
            var to = moment(daterangepicker.endDate).toDate();
            if (from && to) { 
                var fromDate = firebase.firestore.Timestamp.fromDate(new Date(from));
                ref = ref.where('createdAt', '>=', fromDate);
                var toDate = firebase.firestore.Timestamp.fromDate(new Date(to));
                ref = ref.where('createdAt', '<=', toDate);
            }
        }
        if (status) {
            ref = (status == "active") ? ref.where('active', '==', true) : ref.where('active', '==', false);
        }
        if ($.fn.DataTable.isDataTable('#allCustomersTable')) {
            $('#allCustomersTable').DataTable().ajax.reload();
        }
    });
    $(document).ready(function () {
        $(document.body).on('click', '.redirecttopage', function () {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });
        jQuery("#data-table_processing").show();
        var placeholder = database.collection('settings').doc('placeHolderImage');
        placeholder.get().then(async function (snapshotsimage) {
            var placeholderImageData = snapshotsimage.data();
            placeholderImage = placeholderImageData.image;
        });
        $(document).on('click', '.dt-button-collection .dt-button', function () {
            $('.dt-button-collection').hide();
            $('.dt-button-background').hide();
        });
        $(document).on('click', function (event) {
            if (!$(event.target).closest('.dt-button-collection, .dt-buttons').length) {
                $('.dt-button-collection').hide();
                $('.dt-button-background').hide();
            }
        });
        var fieldConfig = {
            columns: [
                { key: 'fullName', header: "{{trans('lang.user_info')}}" },
                { key: 'email', header: "{{trans('lang.email')}}" },
                { key: 'active', header: "{{trans('lang.active')}}" },
                { key: 'createdAt', header: "{{trans('lang.created_at')}}" },
            ],
            fileName: "All Customers",
        };
        
        // Destroy existing DataTable if it exists
        if ($.fn.DataTable.isDataTable('#allCustomersTable')) {
            $('#allCustomersTable').DataTable().destroy();
        }
        
        const table = $('#allCustomersTable').DataTable({
            pageLength: 10,
            processing: false,
            serverSide: true,
            responsive: true,
            ajax: function (data, callback, settings) {
                const start = data.start;
                const length = data.length;
                const searchValue = data.search.value.toLowerCase();
                const orderColumnIndex = data.order[0].column;
                const orderDirection = data.order[0].dir;
                const orderableColumns = ['fullName', 'email', 'createdAt','',''];
                const orderByField = orderableColumns[orderColumnIndex];
                if (searchValue.length >= 3 || searchValue.length === 0) {
                    $('#data-table_processing').show();
                }
                // Get all data first, then sort in JavaScript to avoid index requirement
                ref.get().then(async function (querySnapshot) {
                    if (querySnapshot.empty) {
                        $('.total_count').text(0); 
                        console.error("No data found in Firestore.");
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
                    let records = [];
                    let filteredRecords = []; 
                    querySnapshot.forEach(function (doc) {                        
                        let childData = doc.data();
                        childData.id = doc.id;
                        childData.fullName = (childData.firstName || '') + ' ' + (childData.lastName || '') || " ";
                        var date = '';
                        var time = '';
                        childData.email = shortEmail(childData.email);
                        if (childData.hasOwnProperty("createdAt")) {
                            try {
                                date = childData.createdAt.toDate().toDateString();
                                time = childData.createdAt.toDate().toLocaleTimeString('en-US');
                            } catch (err) {
                            }
                        }
                        var createdAt = date + ' ' + time;
                        if (searchValue) {                           
                            if (
                                (childData.fullName && childData.fullName.toString().toLowerCase().includes(searchValue)) ||
                                (createdAt && createdAt.toString().toLowerCase().indexOf(searchValue) > -1) || (childData.email && childData.email.toString().includes(searchValue))
                            ) {
                                filteredRecords.push(childData);
                            }
                        } else {
                            filteredRecords.push(childData);
                        }
                    });
                    // Sort by createdAt first (descending by default)
                    filteredRecords.sort((a, b) => {
                        let aDate = 0;
                        let bDate = 0;
                        if (a.createdAt && a.createdAt.toDate) {
                            try {
                                aDate = new Date(a.createdAt.toDate()).getTime();
                            } catch (e) {
                                aDate = 0;
                            }
                        }
                        if (b.createdAt && b.createdAt.toDate) {
                            try {
                                bDate = new Date(b.createdAt.toDate()).getTime();
                            } catch (e) {
                                bDate = 0;
                            }
                        }
                        return bDate - aDate; // Descending order
                    });
                    
                    // Then apply additional sorting if needed
                    if (orderByField && orderByField !== 'createdAt') {
                        filteredRecords.sort((a, b) => {
                            let aValue = a[orderByField] ? a[orderByField].toString().toLowerCase() : '';
                            let bValue = b[orderByField] ? b[orderByField].toString().toLowerCase() : '';
                            if (orderDirection === 'asc') {
                                return (aValue > bValue) ? 1 : -1;
                            } else {
                                return (aValue < bValue) ? 1 : -1;
                            }
                        });
                    } else if (orderByField === 'createdAt' && orderDirection === 'asc') {
                        filteredRecords.reverse();
                    }
                    const totalRecords = filteredRecords.length;
                    $('.total_count').text(totalRecords); 
                    const paginatedRecords = filteredRecords.slice(start, start + length);
                    paginatedRecords.forEach(function (childData) {
                        var id = childData.id;
                        var route1 = '{{route("all.customers.edit",":id")}}';
                        route1 = route1.replace(':id', id);
                        var date = '';
                        var time = '';
                        if (childData.hasOwnProperty("createdAt")) {
                            try {
                                date = childData.createdAt.toDate().toDateString();
                                time = childData.createdAt.toDate().toLocaleTimeString('en-US');
                            } catch (err) {
                            }
                        }
                        var customerImage = childData.profilePictureURL == '' || childData.profilePictureURL == null ? '<img alt="" width="100%" style="width:70px;height:70px;" src="' + placeholderImage + '" alt="image">' : '<img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="" width="100%" style="width:70px;height:70px;" src="' + childData.profilePictureURL + '" alt="image">';
                        records.push([
                            customerImage + '<a href="' + route1 + '" class="redirecttopage">' + childData.fullName + '</a>',
                            childData.email ? childData.email : ' ',
                            date + ' ' + time,
                            childData.active ? '<label class="switch"><input type="checkbox" checked id="' + childData.id + '" name="isActive"><span class="slider round"></span></label>' : '<label class="switch"><input type="checkbox" id="' + childData.id + '" name="isActive"><span class="slider round"></span></label>',
                            '<span class="action-btn"><a href="' + route1 + '"><i class="mdi mdi-lead-pencil" title="Edit"></i></a></span>'
                        ]);
                    });
                    $('#data-table_processing').hide(); 
                    callback({
                        draw: data.draw,
                        recordsTotal: totalRecords, 
                        recordsFiltered: totalRecords, 
                        filteredData: filteredRecords,
                        data: records 
                    });
                }).catch(function (error) {
                    console.error("Error fetching data from Firestore:", error);
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
            order: [2, 'desc'],
            columnDefs: [
                {
                    targets: 2,
                    type: 'date',
                    render: function (data) {
                        return data;
                    }
                },
                { orderable: false, targets: [3, 4] },
            ],
            "language": {
                "zeroRecords": "{{trans("lang.no_record_found")}}",
                "emptyTable": "{{trans("lang.no_record_found")}}",
                "processing": "" 
            },
            dom: 'lfrtipB',
            buttons: [
                {
                    extend: 'collection',
                    text: '<i class="mdi mdi-cloud-download"></i> Export as',
                    className: 'btn btn-info',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: 'Export Excel',
                            action: function (e, dt, button, config) {
                                exportData(dt, 'excel',fieldConfig);
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'Export PDF',
                            action: function (e, dt, button, config) {
                                exportData(dt, 'pdf',fieldConfig);
                            }
                        },   
                        {
                            extend: 'csvHtml5',
                            text: 'Export CSV',
                            action: function (e, dt, button, config) {
                                exportData(dt, 'csv',fieldConfig);
                            }
                        }
                    ]
                }
            ],
            initComplete: function() {
                $(".dataTables_filter").append($(".dt-buttons").detach());
                $('.dataTables_filter input').attr('placeholder', 'Search here...').attr('autocomplete','new-password').val('');
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
        $('#search-input').on('input', debounce(function () {
            const searchValue = $(this).val();
            if (searchValue.length >= 3) {
                $('#data-table_processing').show();
                table.search(searchValue).draw();
            } else if (searchValue.length === 0) {
                $('#data-table_processing').show();
                table.search('').draw();
            }
        }, 300));
        
        // Event handlers
        $(document).on("click", "input[name='isActive']", function (e) {
            var ischeck = $(this).is(':checked');
            var id = this.id;
            if (ischeck) {
                database.collection('users').doc(id).update({'active': true}).then(function (result) {
                });
            } else {
                database.collection('users').doc(id).update({'active': false}).then(function (result) {
                });
            }
        });
        }); // End of $(document).ready
    } // End of initAllCustomersPage function
</script>
@endsection

