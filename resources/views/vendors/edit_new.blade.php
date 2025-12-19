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
                                <span class="icon mr-3"><img src="{{ asset('images/vendor.png') }}"></span>
                                <div class="top-title-breadcrumb">
                                    <h3 class="mb-0 vendorTitle">{{ trans('lang.vendor_plural2') }}</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ trans('lang.dashboard') }}</a></li>
                                        <li class="breadcrumb-item"><a href="{!! route('vendors') !!}">{{ trans('lang.vendor_plural2') }}</a></li>
                                        <li class="breadcrumb-item active">Edit Vendor</li>
                                    </ol>
                                </div>
                            </div>
                            <div class="d-flex top-title-right align-self-center">
                                <div class="card-header-right">
                                    <button type="button" class="save-vendor-btn premium-save-btn">
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
            
            <!-- Vendor Details Section -->
            <div class="vendor_info-section">
                <div class="card border">
                    <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-3">
                        <div class="card-header-title">
                            <h3 class="text-dark-2 mb-0 h4">{{ trans('lang.vendor_details') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="vendor_info_left">
                                    <div class="d-flex mb-4">
                                        <div class="sis-img vendor_image position-relative" id="vendor_image_edit">
                                            <div class="image-upload-overlay" onclick="document.getElementById('profile_picture_upload').click()">
                                                <i class="mdi mdi-camera"></i>
                                                <span>Change Photo</span>
                                            </div>
                                            <input type="file" id="profile_picture_upload" accept="image/*" style="display: none;">
                                        </div>
                                        <div class="sis-content pl-4">
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.first_name') }}</label>
                                                <input type="text" class="form-control vendor_first_name_edit" id="vendor_first_name_edit" placeholder="{{ trans('lang.first_name') }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.last_name') }}</label>
                                                <input type="text" class="form-control vendor_last_name_edit" id="vendor_last_name_edit" placeholder="{{ trans('lang.last_name') }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.email') }}</label>
                                                <input type="email" class="form-control vendor_email_edit" id="vendor_email_edit" placeholder="{{ trans('lang.email') }}" readonly>
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
                                                    <input type="text" class="form-control vendor_phone_edit" id="vendor_phone_edit" style="display: inline-block; width: calc(100% - 130px);" placeholder="{{ trans('lang.phone') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.wallet_Balance') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">£</span>
                                                    </div>
                                                    <input type="number" class="form-control wallet_amount_edit" id="wallet_amount_edit" step="0.01" min="0" placeholder="0.00">
                                                </div>
                                                <small class="form-text text-muted">Current balance: <span class="wallet_edit"></span></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.status') }}</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input vendor_active_edit" type="checkbox" id="vendor_active_edit">
                                                    <label class="form-check-label" for="vendor_active_edit">
                                                        <span id="vendor_status_text">Active</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.document_verified') }}</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input vendor_document_verify_edit" type="checkbox" id="vendor_document_verify_edit">
                                                    <label class="form-check-label" for="vendor_document_verify_edit">
                                                        <span id="vendor_document_status_text">Verified</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="map-box">
                                    <div class="card border">
                                        <div class="card-header border-bottom pb-3">
                                            <h3 class="text-dark-2 mb-0 h4">{{ trans('lang.restaurant_info') }}</h3>
                                        </div>
                                        <div class="card-body">
                                            <div id="restaurant_info_edit">
                                                <p class="text-muted">No restaurant associated</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Subscription Plan Section -->
            <div class="vendor_info-section">
                <div class="card border">
                    <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-3">
                        <div class="card-header-title">
                            <h3 class="text-dark-2 mb-0 h4">{{ trans('lang.subscription_plan') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.plan_name') }}</label>
                                    <p class="subscription_plan_name_edit"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.plan_expire_at') }}</label>
                                    <p class="subscription_expiry_date_edit"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.order_limit') }}</label>
                                    <p class="subscription_order_limit_edit"></p>
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
    var currentCurrency = '£';
    var currencyAtRight = false;
    var decimal_degits = 2;
    var vendorData = null;
    var restaurantData = null;
    var vendorPhoto = '';
    
    console.log('🔍 Loading vendor edit with ID:', id);
    
    // Wait for Firestore to be ready
    window.waitForFirestore(function(db) {
        if (!db) {
            console.error('❌ Firestore not available');
            return;
        }
        
        database = db;
        console.log('✅ Firestore initialized in edit vendor page');
        
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
        
        // Load currency - Force GBP
        currentCurrency = '£';
        currencyAtRight = false;
        decimal_degits = 2;
        
        // Load vendor data
        loadVendorData();
    }
    
    async function loadVendorData() {
        if (!database) {
            console.error('❌ Database not available');
            return;
        }
        
        jQuery("#data-table_processing").show();
        
        try {
            // Load vendor data from users collection
            var vendorRef = database.collection('users').doc(id);
            var vendorSnapshot = await vendorRef.get();
            
            if (vendorSnapshot.exists) {
                vendorData = vendorSnapshot.data();
                vendorData.id = vendorSnapshot.id;
                
                console.log('✅ Vendor data loaded:', vendorData);
                
                // Populate form fields
                $('#vendor_first_name_edit').val(vendorData.firstName || '');
                $('#vendor_last_name_edit').val(vendorData.lastName || '');
                $('#vendor_email_edit').val(vendorData.email || '');
                
                // Phone number
                if (vendorData.phoneNumber) {
                    var phone = vendorData.phoneNumber;
                    if (phone.startsWith('+')) {
                        var countryCode = phone.substring(1, 3);
                        $('#country_selector_edit').val(countryCode);
                        $('#vendor_phone_edit').val(phone.substring(3));
                    } else {
                        $('#vendor_phone_edit').val(phone);
                    }
                }
                
                // Active status
                if (vendorData.active !== undefined) {
                    $('#vendor_active_edit').prop('checked', vendorData.active);
                    updateStatusText();
                }
                
                // Document verification
                if (vendorData.isDocumentVerify !== undefined) {
                    $('#vendor_document_verify_edit').prop('checked', vendorData.isDocumentVerify);
                    updateDocumentStatusText();
                }
                
                // Profile Picture
                vendorPhoto = vendorData.profilePictureURL || placeholderImage;
                var imageHtml = '';
                if (vendorPhoto) {
                    imageHtml = '<img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" width="200px" height="200px" src="' + vendorPhoto + '" style="border-radius: 8px; object-fit: cover;">';
                } else {
                    imageHtml = '<img width="200px" height="200px" src="' + placeholderImage + '" style="border-radius: 8px; object-fit: cover;">';
                }
                $('#vendor_image_edit').html(imageHtml);
                
                // Wallet Balance
                var walletBalance = vendorData.wallet_amount || 0;
                $('#wallet_amount_edit').val(parseFloat(walletBalance).toFixed(decimal_degits));
                $('.wallet_edit').text(currentCurrency + parseFloat(walletBalance).toFixed(decimal_degits));
                
                // Subscription Plan
                if (vendorData.subscription_plan) {
                    var plan = vendorData.subscription_plan;
                    $('.subscription_plan_name_edit').text(plan.name || 'N/A');
                    
                    if (vendorData.subscriptionExpiryDate) {
                        try {
                            var expiryDate = vendorData.subscriptionExpiryDate.toDate();
                            $('.subscription_expiry_date_edit').text(expiryDate.toLocaleDateString());
                        } catch (e) {
                            $('.subscription_expiry_date_edit').text('N/A');
                        }
                    } else {
                        $('.subscription_expiry_date_edit').text('N/A');
                    }
                    
                    $('.subscription_order_limit_edit').text(plan.orderLimit || 'N/A');
                } else {
                    $('.subscription_plan_name_edit').text('No Plan');
                    $('.subscription_expiry_date_edit').text('N/A');
                    $('.subscription_order_limit_edit').text('N/A');
                }
                
                // Load associated restaurant if vendorID exists
                if (vendorData.vendorID) {
                    loadRestaurantData(vendorData.vendorID);
                } else {
                    $('#restaurant_info_edit').html('<p class="text-muted">No restaurant associated</p>');
                }
                
                // Vendor Title
                $('.vendorTitle').text('{{ trans('lang.vendor_plural2') }} - ' + (vendorData.firstName || '') + ' ' + (vendorData.lastName || ''));
                
                jQuery("#data-table_processing").hide();
            } else {
                console.error('❌ Vendor not found with ID:', id);
                jQuery("#data-table_processing").hide();
                alert('Vendor not found!');
            }
        } catch (error) {
            console.error('❌ Error loading vendor:', error);
            jQuery("#data-table_processing").hide();
            alert('Error loading vendor data: ' + error.message);
        }
    }
    
    async function loadRestaurantData(restaurantId) {
        if (!database || !restaurantId) {
            return;
        }
        
        try {
            var restaurantRef = database.collection('vendors').doc(restaurantId);
            var restaurantSnapshot = await restaurantRef.get();
            
            if (restaurantSnapshot.exists) {
                restaurantData = restaurantSnapshot.data();
                restaurantData.id = restaurantSnapshot.id;
                
                var html = '<div class="restaurant-info-item mb-3">';
                html += '<label class="mb-1 font-wi font-semibold text-dark-2">' + '{{ trans('lang.restaurant_name') }}' + '</label>';
                html += '<p>' + (restaurantData.title || 'N/A') + '</p>';
                html += '</div>';
                
                html += '<div class="restaurant-info-item mb-3">';
                html += '<label class="mb-1 font-wi font-semibold text-dark-2">' + '{{ trans('lang.restaurant_address') }}' + '</label>';
                html += '<p>' + (restaurantData.location || 'N/A') + '</p>';
                html += '</div>';
                
                html += '<div class="restaurant-info-item mb-3">';
                html += '<label class="mb-1 font-wi font-semibold text-dark-2">' + '{{ trans('lang.restaurant_phone') }}' + '</label>';
                html += '<p>' + (restaurantData.phonenumber || 'N/A') + '</p>';
                html += '</div>';
                
                if (restaurantData.photo) {
                    html += '<div class="restaurant-info-item mb-3">';
                    html += '<img src="' + restaurantData.photo + '" style="max-width: 200px; border-radius: 8px;">';
                    html += '</div>';
                }
                
                $('#restaurant_info_edit').html(html);
            } else {
                $('#restaurant_info_edit').html('<p class="text-muted">Restaurant not found</p>');
            }
        } catch (error) {
            console.error('Error loading restaurant:', error);
            $('#restaurant_info_edit').html('<p class="text-danger">Error loading restaurant</p>');
        }
    }
    
    function updateStatusText() {
        var isActive = $('#vendor_active_edit').is(':checked');
        $('#vendor_status_text').text(isActive ? 'Active' : 'Inactive');
    }
    
    function updateDocumentStatusText() {
        var isVerified = $('#vendor_document_verify_edit').is(':checked');
        $('#vendor_document_status_text').text(isVerified ? 'Verified' : 'Not Verified');
    }
    
    $('#vendor_active_edit').change(function() {
        updateStatusText();
    });
    
    $('#vendor_document_verify_edit').change(function() {
        updateDocumentStatusText();
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
            $('#vendor_image_edit').find('img').remove();
            $('#vendor_image_edit').prepend(imageHtml);
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
                    vendorPhoto = downloadURL;
                    var imageHtml = '<img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" width="200px" height="200px" src="' + downloadURL + '" style="border-radius: 8px; object-fit: cover;">';
                    $('#vendor_image_edit').html(imageHtml);
                    $('#vendor_image_edit').append('<div class="image-upload-overlay" onclick="document.getElementById(\'profile_picture_upload\').click()"><i class="mdi mdi-camera"></i><span>Change Photo</span></div>');
                    jQuery("#data-table_processing").hide();
                    console.log('✅ Profile picture uploaded:', downloadURL);
                });
            }
        );
    });
    
    // Save Vendor Data
    $('.save-vendor-btn').click(async function() {
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
        
        var firstName = $('#vendor_first_name_edit').val().trim();
        var lastName = $('#vendor_last_name_edit').val().trim();
        var countryCode = '+' + $('#country_selector_edit').val();
        var phoneNumber = $('#vendor_phone_edit').val().trim();
        var fullPhone = countryCode + phoneNumber;
        var isActive = $('#vendor_active_edit').is(':checked');
        var isDocumentVerify = $('#vendor_document_verify_edit').is(':checked');
        var walletAmount = parseFloat($('#wallet_amount_edit').val()) || 0;
        
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
            'active': isActive,
            'isDocumentVerify': isDocumentVerify,
            'wallet_amount': walletAmount
        };
        
        // Add profile picture if changed
        if (vendorPhoto && vendorPhoto !== placeholderImage) {
            updateData.profilePictureURL = vendorPhoto;
        }
        
        try {
            // Update vendor in users collection
            await database.collection('users').doc(id).update(updateData);
            console.log('✅ Vendor data updated successfully');
            
            // If restaurant exists, update restaurant status based on vendor active status
            if (restaurantData && restaurantData.id) {
                var restaurantUpdate = {
                    'reststatus': isActive ? 'open' : 'closed'
                };
                await database.collection('vendors').doc(restaurantData.id).update(restaurantUpdate);
                console.log('✅ Restaurant status updated');
            }
            
            // Show success message
            toastr.success('Vendor updated successfully!', 'Success', {
                timeOut: 2000,
                onHidden: function() {
                    window.location.href = '{{ route('vendors') }}';
                }
            });
            
        } catch (error) {
            console.error('❌ Error updating vendor:', error);
            toastr.error('Error updating vendor: ' + error.message, 'Error');
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
    .vendor_image {
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
    
    .vendor_image:hover .image-upload-overlay {
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
    .vendor_info-section {
        margin-bottom: 2rem;
    }
    
    .restaurant-info-item p {
        margin-bottom: 0;
        color: #666;
    }
    
    .form-control:focus {
        border-color: #2c9653;
        box-shadow: 0 0 0 0.2rem rgba(44, 150, 83, 0.25);
    }
    
    .form-check-input:checked {
        background-color: #2c9653;
        border-color: #2c9653;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #ced4da;
        color: #495057;
    }
</style>
@endsection

