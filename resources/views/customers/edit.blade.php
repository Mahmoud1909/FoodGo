@extends('layouts.app')
@section('content')
    <?php
    $countries = file_get_contents(public_path('countriesdata.json'));
    $countries = json_decode($countries);
    $countries = (array) $countries;
    $newcountries = [];
    $newcountriesjs = [];
    foreach ($countries as $keycountry => $valuecountry) {
        $newcountries[$valuecountry->phoneCode] = $valuecountry;
        $newcountriesjs[$valuecountry->phoneCode] = $valuecountry->code;
    }
    ?>
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="admin-top-section pt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex top-title-section pb-4 justify-content-between">
                            <div class="d-flex top-title-left align-self-center">
                                <span class="icon mr-3"><img src="{{ asset('images/users.png') }}"></span>
                                <div class="top-title-breadcrumb">
                                    <h3 class="mb-0 customerTitle">Customers</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ trans('lang.dashboard') }}</a></li>
                                        <li class="breadcrumb-item"><a href="{!! route('customers') !!}">Customers</a></li>
                                        <li class="breadcrumb-item active">Edit Customer</li>
                                    </ol>
                                </div>
                            </div>
                            <div class="d-flex top-title-right align-self-center">
                                <div class="card-header-right">
                                    <button type="button" class="save-customer-btn premium-save-btn">
                                        <span class="btn-content">
                                            <i class="mdi mdi-content-save mr-2"></i>
                                            <span class="btn-text">Save Changes</span>
                                        </span>
                                        <span class="btn-loader" style="display: none;">
                                            <i class="mdi mdi-loading mdi-spin mr-2"></i>
                                            <span>Saving...</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Customer Details Section -->
            <div class="customer_info-section">
                <div class="card border">
                    <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-3">
                        <div class="card-header-title">
                            <h3 class="text-dark-2 mb-0 h4">Customer Details</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="customer_info_left">
                                    <div class="d-flex mb-4">
                                        <div class="sis-img customer_image position-relative" id="customer_image_edit">
                                            <div class="image-upload-overlay" onclick="document.getElementById('profile_picture_upload').click()">
                                                <i class="mdi mdi-camera"></i>
                                                <span>Change Photo</span>
                                            </div>
                                            <input type="file" id="profile_picture_upload" accept="image/*" style="display: none;">
                                        </div>
                                        <div class="sis-content pl-4">
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.first_name') }}</label>
                                                <input type="text" class="form-control customer_first_name_edit" id="customer_first_name_edit" placeholder="{{ trans('lang.first_name') }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.last_name') }}</label>
                                                <input type="text" class="form-control customer_last_name_edit" id="customer_last_name_edit" placeholder="{{ trans('lang.last_name') }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.email') }}</label>
                                                <input type="email" class="form-control customer_email_edit" id="customer_email_edit" placeholder="{{ trans('lang.email') }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.phone') }}</label>
                                                <div class="phone-box position-relative">
                                                    <select name="country" id="country_selector_edit" class="form-control" style="width: 120px; display: inline-block;">
                                                        <?php foreach ($newcountries as $keycy => $valuecy) { ?>
                                                        <option code="<?php echo $valuecy->code; ?>" value="<?php echo $keycy; ?>">
                                                            +<?php echo $valuecy->phoneCode; ?> {{ $valuecy->countryName }}</option>
                                                        <?php } ?>
                                                    </select>
                                                    <input type="text" class="form-control customer_phone_edit" id="customer_phone_edit" style="display: inline-block; width: calc(100% - 130px);" placeholder="{{ trans('lang.phone') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.type') }}</label>
                                                <select class="form-control customer_type_edit" id="customer_type_edit">
                                                    <option value="Normal">Normal</option>
                                                    <option value="customer">Customer</option>
                                                    <option value="employee">Employee</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.status') }}</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input customer_active_edit" type="checkbox" id="customer_active_edit">
                                                    <label class="form-check-label" for="customer_active_edit">
                                                        <span id="customer_status_text">Active</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
<script>
    var id = "<?php echo $id; ?>";
    var database = null;
    var placeholderImage = '';
    var customerData = null;
    var customerPhoto = '';
    
    console.log('🔍 Loading customer edit with ID:', id);
    
    // Wait for Firestore to be ready
    window.waitForFirestore(function(db) {
        if (!db) {
            console.error('❌ Firestore not available');
            return;
        }
        
        database = db;
        console.log('✅ Firestore initialized in edit customer page');
        
        // Load settings and initialize
        initializeSettings();
    });
    
    function initializeSettings() {
        if (!database) {
            console.error('❌ Database not available');
            return;
        }
        
        // Load placeholder image
        var placeholder = database.collection('settings').doc('placeHolderImage');
        placeholder.get().then(async function(snapshotsimage) {
            if (snapshotsimage.exists) {
                var placeholderImageData = snapshotsimage.data();
                placeholderImage = placeholderImageData.image;
            }
        }).catch(function(error) {
            console.warn('Error loading placeholder image:', error);
        });
        
        // Load customer data
        loadCustomerData();
    }
    
    async function loadCustomerData() {
        if (!database) {
            console.error('❌ Database not available');
            return;
        }
        
        jQuery("#data-table_processing").show();
        
        try {
            // Load customer data from users collection
            var customerRef = database.collection('users').doc(id);
            var customerSnapshot = await customerRef.get();
            
            if (customerSnapshot.exists) {
                customerData = customerSnapshot.data();
                customerData.id = customerSnapshot.id;
                
                console.log('✅ Customer data loaded:', customerData);
                
                // Populate form fields
                $('#customer_first_name_edit').val(customerData.firstName || '');
                $('#customer_last_name_edit').val(customerData.lastName || '');
                $('#customer_email_edit').val(customerData.email || '');
                
                // Phone number
                if (customerData.phoneNumber) {
                    var phone = customerData.phoneNumber;
                    if (phone.startsWith('+')) {
                        var countryCode = phone.substring(1, 3);
                        $('#country_selector_edit').val(countryCode);
                        $('#customer_phone_edit').val(phone.substring(3));
                    } else {
                        $('#customer_phone_edit').val(phone);
                    }
                }
                
                // Type
                if (customerData.type) {
                    $('#customer_type_edit').val(customerData.type);
                }
                
                // Active status
                if (customerData.active !== undefined) {
                    $('#customer_active_edit').prop('checked', customerData.active);
                    updateStatusText();
                }
                
                // Profile Picture
                customerPhoto = customerData.profilePictureURL || placeholderImage;
                var imageHtml = '';
                if (customerPhoto) {
                    imageHtml = '<img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" width="200px" height="200px" src="' + customerPhoto + '" style="border-radius: 8px; object-fit: cover;">';
                } else {
                    imageHtml = '<img width="200px" height="200px" src="' + placeholderImage + '" style="border-radius: 8px; object-fit: cover;">';
                }
                $('#customer_image_edit').html(imageHtml);
                $('#customer_image_edit').append('<div class="image-upload-overlay" onclick="document.getElementById(\'profile_picture_upload\').click()"><i class="mdi mdi-camera"></i><span>Change Photo</span></div>');
                
                // Customer Title
                $('.customerTitle').text('Customers - ' + (customerData.firstName || '') + ' ' + (customerData.lastName || ''));
                
                jQuery("#data-table_processing").hide();
            } else {
                console.error('❌ Customer not found with ID:', id);
                jQuery("#data-table_processing").hide();
                alert('Customer not found!');
            }
        } catch (error) {
            console.error('❌ Error loading customer:', error);
            jQuery("#data-table_processing").hide();
            alert('Error loading customer data: ' + error.message);
        }
    }
    
    function updateStatusText() {
        var isActive = $('#customer_active_edit').is(':checked');
        $('#customer_status_text').text(isActive ? 'Active' : 'Inactive');
    }
    
    $('#customer_active_edit').change(function() {
        updateStatusText();
    });
    
    // Handle profile picture upload
    $('#profile_picture_upload').change(function(e) {
        var file = e.target.files[0];
        if (!file) return;
        
        if (!file.type.match('image.*')) {
            alert('Please select an image file');
            return;
        }
        
        var reader = new FileReader();
        reader.onload = function(e) {
            var imageHtml = '<img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" width="200px" height="200px" src="' + e.target.result + '" style="border-radius: 8px; object-fit: cover;">';
            $('#customer_image_edit').find('img').remove();
            $('#customer_image_edit').prepend(imageHtml);
        };
        reader.readAsDataURL(file);
        
        // Upload to Firebase Storage
        var storageRef = firebase.storage().ref('images');
        var timestamp = Number(new Date());
        var filename = timestamp + '_' + file.name;
        var uploadTask = storageRef.child(filename).put(file);
        
        jQuery("#data-table_processing").show();
        
        uploadTask.on('state_changed',
            function(snapshot) {
                var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                console.log('Upload is ' + progress + '% done');
            },
            function(error) {
                console.error('Upload error:', error);
                alert('Error uploading image: ' + error.message);
                jQuery("#data-table_processing").hide();
            },
            function() {
                uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
                    customerPhoto = downloadURL;
                    var imageHtml = '<img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" width="200px" height="200px" src="' + downloadURL + '" style="border-radius: 8px; object-fit: cover;">';
                    $('#customer_image_edit').html(imageHtml);
                    $('#customer_image_edit').append('<div class="image-upload-overlay" onclick="document.getElementById(\'profile_picture_upload\').click()"><i class="mdi mdi-camera"></i><span>Change Photo</span></div>');
                    jQuery("#data-table_processing").hide();
                    console.log('✅ Profile picture uploaded:', downloadURL);
                });
            }
        );
    });
    
    // Save Customer Data
    $('.save-customer-btn').click(async function() {
        if (!database) {
            toastr.error('Database not available');
            return;
        }
        
        var $btn = $(this);
        var $btnContent = $btn.find('.btn-content');
        var $btnLoader = $btn.find('.btn-loader');
        
        // Disable button and show loader
        $btn.prop('disabled', true);
        $btnContent.hide();
        $btnLoader.show();
        
        var firstName = $('#customer_first_name_edit').val().trim();
        var lastName = $('#customer_last_name_edit').val().trim();
        var countryCode = '+' + $('#country_selector_edit').val();
        var phoneNumber = $('#customer_phone_edit').val().trim();
        var fullPhone = countryCode + phoneNumber;
        var customerType = $('#customer_type_edit').val();
        var isActive = $('#customer_active_edit').is(':checked');
        
        if (!firstName || !lastName) {
            toastr.error('Please fill in first name and last name');
            $btn.prop('disabled', false);
            $btnContent.show();
            $btnLoader.hide();
            return;
        }
        
        if (!phoneNumber) {
            toastr.error('Please fill in phone number');
            $btn.prop('disabled', false);
            $btnContent.show();
            $btnLoader.hide();
            return;
        }
        
        var updateData = {
            'firstName': firstName,
            'lastName': lastName,
            'phoneNumber': fullPhone,
            'type': customerType,
            'active': isActive
        };
        
        // Add profile picture if changed
        if (customerPhoto && customerPhoto !== placeholderImage) {
            updateData.profilePictureURL = customerPhoto;
        }
        
        try {
            // Update customer in users collection
            await database.collection('users').doc(id).update(updateData);
            console.log('✅ Customer data updated successfully');
            
            // Show success message
            toastr.success('Customer updated successfully!', 'Success', {
                timeOut: 2000,
                onHidden: function() {
                    window.location.href = '{{ route('customers') }}';
                }
            });
            
        } catch (error) {
            console.error('❌ Error updating customer:', error);
            toastr.error('Error updating customer: ' + error.message, 'Error');
            $btn.prop('disabled', false);
            $btnContent.show();
            $btnLoader.hide();
        }
    });
</script>
@endsection

@section('styles')
<style>
    /* Premium Save Button Design */
    .premium-save-btn {
        position: relative;
        background: linear-gradient(135deg, #2c9653 0%, #34b865 100%);
        border: none;
        border-radius: 50px;
        padding: 12px 30px;
        color: white;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(44, 150, 83, 0.3);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 180px;
    }
    
    .premium-save-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .premium-save-btn:hover::before {
        left: 100%;
    }
    
    .premium-save-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(44, 150, 83, 0.4);
        background: linear-gradient(135deg, #34b865 0%, #2c9653 100%);
    }
    
    .premium-save-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 10px rgba(44, 150, 83, 0.3);
    }
    
    .premium-save-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }
    
    .premium-save-btn .btn-content,
    .premium-save-btn .btn-loader {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .premium-save-btn i {
        font-size: 18px;
    }
    
    /* Image Upload Overlay */
    .customer_image {
        position: relative;
        display: inline-block;
    }
    
    .image-upload-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 8px;
        text-align: center;
        cursor: pointer;
        border-radius: 0 0 8px 8px;
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }
    
    .customer_image:hover .image-upload-overlay {
        opacity: 1;
    }
    
    .image-upload-overlay i {
        font-size: 18px;
    }
    
    .image-upload-overlay span {
        font-size: 12px;
        font-weight: 500;
    }
    
    /* Form Styles */
    .customer_info-section {
        margin-bottom: 2rem;
    }
    
    .form-control:focus {
        border-color: #2c9653;
        box-shadow: 0 0 0 0.2rem rgba(44, 150, 83, 0.25);
    }
    
    .form-check-input:checked {
        background-color: #2c9653;
        border-color: #2c9653;
    }
</style>
@endsection

