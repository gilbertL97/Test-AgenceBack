<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class ClientController extends Controller
{
    public function index()
    {
        $customer =  Customer::all();
        return response()->json($customer);
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }
}
