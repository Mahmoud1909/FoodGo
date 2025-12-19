<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RestaurantController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        Log::info('🍽️ Restaurants index page accessed', [
            'user_id' => auth()->id(),
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("restaurants.index");
    }

    public function control()
    {
        Log::info('🎛️ Restaurant Control page accessed', [
            'user_id' => auth()->id(),
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("restaurants.control");
    }

    public function view($id)
    {
        Log::info('👁️ Restaurant View page accessed', [
            'user_id' => auth()->id(),
            'restaurant_id' => $id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("restaurants.view")->with('id', $id);
    }

    public function edit($id)
    {
        Log::info('✏️ Restaurant Edit page accessed', [
            'user_id' => auth()->id(),
            'restaurant_id' => $id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("restaurants.edit")->with('id', $id);
    }

    public function create()
    {
        Log::info('➕ Restaurant Create page accessed', [
            'user_id' => auth()->id(),
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("restaurants.create");
    }

    public function promos($id)
    {
        Log::info('🎁 Restaurant Promos page accessed', [
            'user_id' => auth()->id(),
            'restaurant_id' => $id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("restaurants.promos")->with('id', $id);
    }

    public function log(Request $request)
    {
        Log::info('📝 Restaurant log action', [
            'user_id' => auth()->id(),
            'data' => $request->all(),
            'timestamp' => now()->toDateTimeString()
        ]);

        return response()->json(['success' => true]);
    }

    public function editNew($id)
    {
        Log::info('🆕 Restaurant Edit New page accessed', [
            'user_id' => auth()->id(),
            'restaurant_id' => $id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("restaurants.edit_tab")->with('id', $id);
    }

    public function vendors()
    {
        Log::info('👥 Vendors list page accessed', [
            'user_id' => auth()->id(),
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("vendors.index");
    }

    public function vendorCreate()
    {
        Log::info('➕ Vendor Create page accessed', [
            'user_id' => auth()->id(),
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("vendors.create");
    }

    public function vendorEdit($id)
    {
        Log::info('✏️ Vendor Edit page accessed', [
            'user_id' => auth()->id(),
            'vendor_id' => $id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("vendors.edit_new")->with('id', $id);
    }

    public function vendorChat($id)
    {
        Log::info('💬 Vendor Chat page accessed', [
            'user_id' => auth()->id(),
            'vendor_id' => $id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("vendors.chat", compact('id'));
    }

    public function DocumentList($id)
    {
        Log::info('📄 Vendor Document List page accessed', [
            'user_id' => auth()->id(),
            'vendor_id' => $id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("vendors.document_list")->with('id', $id);
    }

    public function DocumentUpload($driverId, $id)
    {
        Log::info('📤 Vendor Document Upload page accessed', [
            'user_id' => auth()->id(),
            'driver_id' => $driverId,
            'document_id' => $id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("vendors.document_upload", compact('driverId', 'id'));
    }

    public function vendorSubscriptionPlanHistory($id = null)
    {
        Log::info('📊 Vendor Subscription Plan History page accessed', [
            'user_id' => auth()->id(),
            'vendor_id' => $id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("subscription_plans.history")->with('id', $id);
    }

    public function controlEdit($id)
    {
        Log::info('🎛️ Restaurant Control Edit page accessed', [
            'user_id' => auth()->id(),
            'restaurant_id' => $id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("restaurants.control_edit")->with('id', $id);
    }

    public function controlEditNew($id)
    {
        Log::info('🆕 Restaurant Control Edit New page accessed', [
            'user_id' => auth()->id(),
            'restaurant_id' => $id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("restaurants.control_edit_new")->with('id', $id);
    }

    public function restaurantEditing($id)
    {
        Log::info('✏️ Restaurant Editing page accessed', [
            'user_id' => auth()->id(),
            'restaurant_id' => $id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("restaurants.edit_tab")->with('id', $id);
    }

    public function editThisRestaurant($id)
    {
        Log::info('🔧 Edit This Restaurant page accessed', [
            'user_id' => auth()->id(),
            'restaurant_id' => $id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("restaurants.edit_this_restaurant")->with('id', $id);
    }

    public function currentSubscriberList($id)
    {
        Log::info('📋 Current Subscriber List page accessed', [
            'user_id' => auth()->id(),
            'subscription_plan_id' => $id,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view("subscription_plans.current_subscriber")->with('id', $id);
    }
}
