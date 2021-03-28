<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpecialCustomer;

class SpecialCustomerController extends Controller
{
    /**
     * Assign appropriate permissions.
     */
    function __construct()
    {
        $this->middleware('permission:sp-cust-list|sp-cust-create|sp-cust-update|sp-cust-delete', ['only' => ['index']]);
        $this->middleware('permission:sp-cust-list', ['only' => ['index']]);
        $this->middleware('permission:sp-cust-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sp-cust-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sp-cust-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all the special customers
        $customers = SpecialCustomer::all();
        // Return the appropriate view
        return view('customer.index')->withCustomers($customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the appropriate view
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create a new object of SpecialCustomer
        $customer = new SpecialCustomer;

        // Assign the request values to the new customer
        $customer->name = $request->input('name');
        $customer->national_id = $request->input('national_id');
        $customer->phone = $request->input('phone');
        $customer->whats_app = $request->input('whats_app');

        // Save the new customer
        $customer->save();

        // Return the appropriate view
        return redirect()->route('customer.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get the targeted customer
        $customer = SpecialCustomer::find($id);
        // Return the appropriate view
        return view('customer.edit')->withCustomer($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Get the targeted customer
        $customer = SpecialCustomer::find($id);

        // Assign the request values to the new customer
        $customer->name = $request->input('name');
        $customer->national_id = $request->input('national_id');
        $customer->phone = $request->input('phone');
        $customer->whats_app = $request->input('whats_app');

        // Save the updates
        $customer->save();

        // Return the appropriate view
        return redirect()->route('customer.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get the targeted customer
        $customer = SpecialCustomer::find($id);

        // Delete the record
        $customer->delete();

        // Return the appropriate view
        return redirect()->route('customer.index');
    }
}
