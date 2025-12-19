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
                                <span class="icon mr-3"><img src="{{ asset('images/building-four.png') }}"></span>
                                <div class="top-title-breadcrumb">
                                    <h3 class="mb-0 restaurantTitle">{{ trans('lang.restaurant_plural') }}</h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ trans('lang.dashboard') }}</a></li>
                                        <li class="breadcrumb-item"><a href="{!! route('restaurants.control') !!}">Restaurant Control</a></li>
                                        <li class="breadcrumb-item active">Edit Restaurant</li>
                                    </ol>
                                </div>
                            </div>
                            <div class="d-flex top-title-right align-self-center">
                                <div class="card-header-right">
                                    <button type="button" class="btn-primary btn rounded-full save-restaurant-btn" style="background-color: #2c9653; border-color: #2c9653;"><i class="mdi mdi-content-save mr-2"></i>Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="resttab-sec mb-4">
                <div class="menu-tab">
                    <ul>
                        <li>
                            <a href="{{ route('restaurants.view', $id) }}">{{ trans('lang.tab_basic') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('restaurants.foods', $id) }}">{{ trans('lang.tab_foods') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('restaurants.orders', $id) }}">{{ trans('lang.tab_orders') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('restaurants.coupons', $id) }}">{{ trans('lang.tab_promos') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('restaurants.payout', $id) }}">{{ trans('lang.tab_payouts') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('payoutRequests.restaurants.view', $id) }}">{{ trans('lang.tab_payout_request') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('restaurants.booktable', $id) }}">{{ trans('lang.dine_in_future') }}</a>
                        </li>
                        <li id="restaurant_wallet"></li>
                        <li id="subscription_plan"></li>
                        <li>
                            <a href="{{ route('restaurants.advertisements', $id) }}">{{ trans('lang.advertisement_plural') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('restaurants.deliveryman', $id) }}">{{ trans('lang.deliveryman') }}</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('restaurants.edit.new', $id) }}" style="color: #2c9653; border-bottom-color: #2c9653;">Edit Restaurant</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Restaurant Details Section -->
            <div class="restaurant_info-section">
                <div class="card border">
                    <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-3">
                        <div class="card-header-title">
                            <h3 class="text-dark-2 mb-0 h4">{{ trans('lang.restaurant_details') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="restaurant_info_left">
                                    <div class="d-flex mb-4">
                                        <div class="sis-img restaurant_image" id="restaurant_image_edit">
                                        </div>
                                        <div class="sis-content pl-4">
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.restaurant_name') }}</label>
                                                <input type="text" class="form-control restaurant_name_edit" id="restaurant_name_edit" placeholder="{{ trans('lang.restaurant_name') }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.restaurant_phone') }}</label>
                                                <div class="phone-box position-relative">
                                                    <select name="country" id="country_selector_edit" class="form-control" style="width: 120px; display: inline-block;">
                                                        <?php foreach ($newcountries as $keycy => $valuecy) { ?>
                                                        <option code="<?php echo $valuecy->code; ?>" value="<?php echo $keycy; ?>">
                                                            +<?php echo $valuecy->phoneCode; ?> {{ $valuecy->countryName }}</option>
                                                        <?php } ?>
                                                    </select>
                                                    <input type="text" class="form-control restaurant_phone_edit" id="restaurant_phone_edit" style="display: inline-block; width: calc(100% - 130px);" placeholder="{{ trans('lang.restaurant_phone') }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.restaurant_address') }}</label>
                                                <input type="text" class="form-control restaurant_address_edit" id="restaurant_address_edit" placeholder="{{ trans('lang.restaurant_address') }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.restaurant_cuisines') }}</label>
                                                <select id="restaurant_cuisines_edit" name="restaurant_cuisines_edit" class="form-control" multiple>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.restaurant_description') }}</label>
                                                <textarea class="form-control restaurant_description_edit" id="restaurant_description_edit" rows="4" placeholder="{{ trans('lang.restaurant_description') }}"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.zone') }}</label>
                                                <select id="zone_edit" name="zone_edit" class="form-control">
                                                    <option value="">{{ trans('lang.select_zone') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.wallet_Balance') }}</label>
                                                <p class="wallet_edit"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">Latitude</label>
                                                <input type="text" class="form-control restaurant_latitude_edit" id="restaurant_latitude_edit" placeholder="Latitude">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-2 font-wi font-semibold text-dark-2">Longitude</label>
                                                <input type="text" class="form-control restaurant_longitude_edit" id="restaurant_longitude_edit" placeholder="Longitude">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="map-box">
                                    <div class="mapouter">
                                        <div class="gmap_canvas">
                                            <iframe class="gmap_iframe_edit" id="gmap_iframe_edit" width="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-sm" style="background-color: #2c9653; color: white;" onclick="updateMapLocation()">Update Map Location</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Vendor Details Section -->
            <div class="restaurant_info-section">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-3">
                                <div class="card-header-title">
                                    <h3 class="text-dark-2 mb-0 h4">{{ trans('lang.vendor_details') }}</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.name') }}</label>
                                            <p><span class="vendor_name_edit"></span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.restaurant_phone') }}</label>
                                            <p><span class="vendor_phoneNumber_edit"></span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.email') }}</label>
                                            <p><span class="vendor_email_edit"></span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.dine_in_future') }}</label>
                                            <p><span class="dine_in_future_edit"></span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.restaurant_status') }}</label>
                                            <p><span class="vendor_avtive_edit"></span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-wi font-semibold text-dark-2">{{ trans('lang.admin_commission') }}</label>
                                            <p><span class="admin_commission_edit"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-3">
                                <div class="card-header-title">
                                    <h3 class="text-dark-2 mb-0 h4">{{ trans('lang.gallery') }}</h3>
                                </div>
                                <div>
                                    <input type="file" id="gallery_upload" multiple accept="image/*" style="display: none;">
                                    <button type="button" class="btn btn-sm" style="background-color: #2c9653; color: white;" onclick="document.getElementById('gallery_upload').click()">Add Images</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="restaurant_gallery" id="photos_edit">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Working Hours & Services Section -->
            <div class="restaurant_info-section">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-3">
                                <div class="card-header-title">
                                    <h3 class="text-dark-2 mb-0 h4">{{ trans('lang.working_hours') }}</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row" id="working_hours_edit">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-3">
                                <div class="card-header-title">
                                    <h3 class="text-dark-2 mb-0 h4">{{ trans('lang.services') }}</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="restaurant_service" id="filtershtml_edit">
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
    var restaurantData = null;
    var vendorAuthor = '';
    var photo = '';
    var galleryImages = [];
    
    console.log('🔍 Loading restaurant edit with ID:', id);
    
    // Wait for Firestore to be ready
    window.waitForFirestore(function(db) {
        if (!db) {
            console.error('❌ Firestore not available');
            return;
        }
        
        database = db;
        console.log('✅ Firestore initialized in edit tab page');
        
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
        
        // Load restaurant data
        loadRestaurantData();
    }
    
    async function loadRestaurantData() {
        if (!database) {
            console.error('❌ Database not available');
            return;
        }
        
        jQuery("#data-table_processing").show();
        
        try {
            var ref = database.collection('vendors').doc(id);
            var snapshot = await ref.get();
            
            if (snapshot.exists) {
                restaurantData = snapshot.data();
                vendorAuthor = restaurantData.author;
                
                // Populate form fields
                $('#restaurant_name_edit').val(restaurantData.title || '');
                $('#restaurant_address_edit').val(restaurantData.location || '');
                $('#restaurant_description_edit').val(restaurantData.description || '');
                $('#restaurant_latitude_edit').val(restaurantData.latitude || '');
                $('#restaurant_longitude_edit').val(restaurantData.longitude || '');
                
                // Phone number
                if (restaurantData.phonenumber) {
                    var phone = restaurantData.phonenumber;
                    if (phone.startsWith('+')) {
                        var countryCode = phone.substring(1, 3);
                        $('#country_selector_edit').val(countryCode);
                        $('#restaurant_phone_edit').val(phone.substring(3));
                    } else {
                        $('#restaurant_phone_edit').val(phone);
                    }
                }
                
                // Zone
                if (restaurantData.zoneId) {
                    database.collection('zone').where('publish', '==', true).get().then(function(snapshots) {
                        snapshots.docs.forEach(function(doc) {
                            var zoneData = doc.data();
                            var selected = (zoneData.id == restaurantData.zoneId) ? 'selected' : '';
                            $('#zone_edit').append($("<option></option>")
                                .attr("value", zoneData.id)
                                .attr("selected", selected)
                                .text(zoneData.name));
                        });
                    });
                }
                
                // Cuisines
                database.collection('vendor_categories').where('publish', '==', true).get().then(function(snapshots) {
                    snapshots.docs.forEach(function(doc) {
                        var categoryData = doc.data();
                        var selected = (restaurantData.categoryID && restaurantData.categoryID.includes(categoryData.id)) ? 'selected' : '';
                        $('#restaurant_cuisines_edit').append($("<option></option>")
                            .attr("value", categoryData.id)
                            .attr("selected", selected)
                            .text(categoryData.title));
                    });
                });
                
                // Restaurant Image
                photo = restaurantData.photo || placeholderImage;
                var imageHtml = '';
                if (photo) {
                    imageHtml = '<img onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" width="200px" height="200px" src="' + photo + '" style="border-radius: 8px; object-fit: cover;">';
                } else {
                    imageHtml = '<img width="200px" height="200px" src="' + placeholderImage + '" style="border-radius: 8px; object-fit: cover;">';
                }
                $('#restaurant_image_edit').html(imageHtml);
                
                // Gallery
                galleryImages = restaurantData.photos || [];
                displayGallery();
                
                // Map
                if (restaurantData.latitude && restaurantData.longitude) {
                    var mapSrc = `https://maps.google.com/maps?width=600&height=225&hl=en&q=${restaurantData.latitude},${restaurantData.longitude}&t=&z=14&ie=UTF8&iwloc=B&output=embed`;
                    $('#gmap_iframe_edit').attr("src", mapSrc);
                }
                
                // Wallet Balance
                if (vendorAuthor) {
                    database.collection('users').doc(vendorAuthor).get().then(function(userSnapshot) {
                        if (userSnapshot.exists) {
                            var userData = userSnapshot.data();
                            var walletBalance = userData.wallet_amount || 0;
                            $('.wallet_edit').text(currentCurrency + parseFloat(walletBalance).toFixed(decimal_degits));
                        }
                    });
                }
                
                // Vendor Details
                if (vendorAuthor) {
                    database.collection('users').doc(vendorAuthor).get().then(function(userSnapshot) {
                        if (userSnapshot.exists) {
                            var userData = userSnapshot.data();
                            $('.vendor_name_edit').text((userData.firstName || '') + ' ' + (userData.lastName || ''));
                            $('.vendor_email_edit').text(userData.email || '');
                            $('.vendor_phoneNumber_edit').text(userData.phoneNumber || '');
                        }
                    });
                }
                
                // Working Hours
                if (restaurantData.workingHours) {
                    displayWorkingHours(restaurantData.workingHours);
                }
                
                // Services/Filters
                if (restaurantData.filters) {
                    displayFilters(restaurantData.filters);
                }
                
                // Admin Commission
                if (restaurantData.adminCommission) {
                    var commission = '';
                    if (restaurantData.adminCommission.commissionType == 'Percent') {
                        commission = restaurantData.adminCommission.fix_commission + '%';
                    } else {
                        commission = currentCurrency + restaurantData.adminCommission.fix_commission;
                    }
                    $('.admin_commission_edit').text(commission);
                }
                
                // Dine In Future
                if (restaurantData.enabledDiveInFuture) {
                    $('.dine_in_future_edit').html('ON').removeClass('red').addClass('green');
                } else {
                    $('.dine_in_future_edit').html('OFF').removeClass('green').addClass('red');
                }
                
                // Restaurant Status
                if (vendorAuthor) {
                    database.collection('users').doc(vendorAuthor).get().then(function(userSnapshot) {
                        if (userSnapshot.exists) {
                            var userData = userSnapshot.data();
                            if (userData.active) {
                                $('.vendor_avtive_edit').text('Open').removeClass('red').addClass('green');
                            } else {
                                $('.vendor_avtive_edit').text('Closed').removeClass('green').addClass('red');
                            }
                        }
                    });
                }
                
                // Restaurant Title
                $('.restaurantTitle').text('{{ trans('lang.restaurant_plural') }} - ' + (restaurantData.title || ''));
                
                jQuery("#data-table_processing").hide();
            } else {
                console.error('❌ Restaurant not found with ID:', id);
                jQuery("#data-table_processing").hide();
            }
        } catch (error) {
            console.error('❌ Error loading restaurant:', error);
            jQuery("#data-table_processing").hide();
        }
    }
    
    function displayGallery() {
        var html = '<ul class="p-0 d-flex flex-wrap">';
        galleryImages.forEach(function(img, index) {
            html += '<li class="mr-2 mb-2 position-relative" style="list-style: none;">';
            html += '<img width="100px" height="100px" src="' + img + '" style="border-radius: 4px; object-fit: cover;">';
            html += '<button type="button" class="btn btn-sm btn-danger position-absolute" style="top: 5px; right: 5px; padding: 2px 6px;" onclick="removeGalleryImage(' + index + ')">×</button>';
            html += '</li>';
        });
        html += '</ul>';
        $('#photos_edit').html(html);
    }
    
    function removeGalleryImage(index) {
        galleryImages.splice(index, 1);
        displayGallery();
    }
    
    function displayWorkingHours(workingHours) {
        var days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        var html = '';
        days.forEach(function(day) {
            var dayHours = workingHours.find(function(wh) { return wh.day === day; });
            html += '<div class="col-md-12 mb-3">';
            html += '<label class="mb-1 font-wi font-semibold text-dark-2">' + day + '</label>';
            if (dayHours && dayHours.timeslot && dayHours.timeslot.length > 0) {
                dayHours.timeslot.forEach(function(slot) {
                    html += '<p class="mb-1">' + slot.from + ' - ' + slot.to + '</p>';
                });
            } else {
                html += '<p class="mb-1">Closed</p>';
            }
            html += '</div>';
        });
        $('#working_hours_edit').html(html);
    }
    
    function displayFilters(filters) {
        var html = '<ul class="p-0">';
        for (var key in filters) {
            if (filters[key] == "Yes") {
                html += '<li><span class="mdi mdi-check green mr-2"></span>' + key + '</li>';
            } else {
                html += '<li><span class="mdi mdi-close red mr-2"></span>' + key + '</li>';
            }
        }
        html += '</ul>';
        $('#filtershtml_edit').html(html);
    }
    
    function updateMapLocation() {
        var lat = $('#restaurant_latitude_edit').val();
        var lng = $('#restaurant_longitude_edit').val();
        if (lat && lng) {
            var mapSrc = `https://maps.google.com/maps?width=600&height=225&hl=en&q=${lat},${lng}&t=&z=14&ie=UTF8&iwloc=B&output=embed`;
            $('#gmap_iframe_edit').attr("src", mapSrc);
        }
    }
    
    // Save Restaurant Data
    $('.save-restaurant-btn').click(async function() {
        if (!database) {
            alert('Database not available');
            return;
        }
        
        var restaurantName = $('#restaurant_name_edit').val();
        var address = $('#restaurant_address_edit').val();
        var description = $('#restaurant_description_edit').val();
        var latitude = parseFloat($('#restaurant_latitude_edit').val());
        var longitude = parseFloat($('#restaurant_longitude_edit').val());
        var zoneId = $('#zone_edit').val();
        var countryCode = '+' + $('#country_selector_edit').val();
        var phonenumber = $('#restaurant_phone_edit').val();
        var fullPhone = countryCode + phonenumber;
        
        var cuisines = $('#restaurant_cuisines_edit').val();
        var categoryTitles = [];
        if (cuisines && cuisines.length > 0) {
            $('#restaurant_cuisines_edit option:selected').each(function() {
                categoryTitles.push($(this).text());
            });
        }
        
        var updateData = {
            'title': restaurantName,
            'description': description,
            'latitude': latitude,
            'longitude': longitude,
            'location': address,
            'phonenumber': fullPhone,
            'categoryID': cuisines || [],
            'categoryTitle': categoryTitles,
            'zoneId': zoneId,
            'photo': photo,
            'photos': galleryImages
        };
        
        // Update coordinates if lat/lng provided
        if (latitude && longitude) {
            updateData.coordinates = {
                latitude: latitude,
                longitude: longitude
            };
        }
        
        try {
            jQuery("#data-table_processing").show();
            await database.collection('vendors').doc(id).update(updateData);
            alert('Restaurant updated successfully!');
            window.location.href = '{{ route('restaurants.view', $id) }}';
        } catch (error) {
            console.error('Error updating restaurant:', error);
            alert('Error updating restaurant: ' + error.message);
            jQuery("#data-table_processing").hide();
        }
    });
    
    // Handle gallery upload
    $('#gallery_upload').change(function(e) {
        var files = e.target.files;
        if (!files || files.length === 0) return;
        
        var storageRef = firebase.storage().ref('images');
        Array.from(files).forEach(function(file) {
            var timestamp = Number(new Date());
            var filename = timestamp + '_' + file.name;
            var uploadTask = storageRef.child(filename).put(file);
            
            uploadTask.on('state_changed', 
                function(snapshot) {
                    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                    console.log('Upload is ' + progress + '% done');
                },
                function(error) {
                    console.error('Upload error:', error);
                },
                function() {
                    uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
                        galleryImages.push(downloadURL);
                        displayGallery();
                    });
                }
            );
        });
    });
</script>
@endsection

@section('styles')
<style>
    .menu-tab ul li.active a[href*="restaurants.edit.new"] {
        color: #2c9653 !important;
        border-bottom-color: #2c9653 !important;
    }
    
    .btn-primary {
        background-color: #2c9653 !important;
        border-color: #2c9653 !important;
    }
    
    .btn-primary:hover {
        background-color: #247a45 !important;
        border-color: #247a45 !important;
    }
</style>
@endsection

