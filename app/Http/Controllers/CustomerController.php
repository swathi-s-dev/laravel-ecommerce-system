<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    
    public function index()
    {
        $customers = Customer::latest()->get();
        return view ('customers.index',compact('customers'));
    }

    public function create()
    {
        return view ('customers.create');
    }

   
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Za-z ]+$/|unique:customers,name',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|digits:10',
            'address' => 'required|string',
            'city' => 'required|string|max:100|regex:/^[A-Za-z ]+$/',
            'state' => 'required|string|max:100|regex:/^[A-Za-z ]+$/',
            'pincode' => 'required|digits:6',
            'status' => 'required|boolean',
        ]);
        
        $customer = Customer::create($validate);

        return response()->json([
            'success' => true,
            'message' => 'Customer added successfully.',
            'customer' => $customer
        ]);
    }

  
    // public function show(Customer $customer)
    // {
    //     return view('customers.show',compact('customer'));
    // }

    
    public function edit(Customer $customer)
    {
          return view('customers.edit', compact('customer'));
    }

    
    public function update(Request $request, Customer $customer)
    {
        
        $validate = $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Za-z ]+$/|unique:customers,name,' . $customer->id,
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|digits:10',
            'address' => 'required|string',
            'city' => 'required|string|max:100|regex:/^[A-Za-z ]+$/',
            'state' => 'required|string|max:100|regex:/^[A-Za-z ]+$/',
            'pincode' => 'required|digits:6',
            'status' => 'required|boolean',
        ]);
        $customer->update($validate);

        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully.',
            'customer' => $customer
        ]);
    
    }

    
    public function destroy(Customer $customer)
    {
       $customer->delete();
        return response()->json([
                'success' => true,
                'message' => 'Customer deleted successfully.'
        ]);
    }
}
