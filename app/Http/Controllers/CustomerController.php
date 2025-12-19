<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view("customers.index");
    }

    public function edit($id)
    {
        return view('customers.edit')->with('id', $id);
    }

    public function allCustomers()
    {
        return view("all_customers.index");
    }

    public function allCustomersEdit($id)
    {
        return view('all_customers.edit')->with('id', $id);
    }
}

