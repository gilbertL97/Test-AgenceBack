<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return Customer::all();
    }

    // public function store(Request $request)
    // {
    //     $customer = Customer::create($request->all());
    //     return response()->json($customer, 201);
    // }

    public function show($id)
    {
        return Customer::findOrFail($id);
    }

    // public function update(Request $request, $id)
    // {
    //     $customer = Customer::findOrFail($id);
    //     $customer->update($request->all());
    //     return response()->json($customer, 200);
    // }

    public function destroy($id)
    {
        Customer::destroy($id);
        return response()->json(null, 204);
    }
}
