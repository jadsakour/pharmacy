<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Assign appropriate permissions.
     */
    public function __construct()
    {
        $this->middleware('permission:company-list|company-create|company-update|company-delete', ['only' => ['index']]);
        $this->middleware('permission:company-list', ['only' => ['index']]);
        $this->middleware('permission:company-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:company-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:company-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all the companies
        $companies = Company::all();
        // Return the appropriate view
        return view('company.index')->withCompanies($companies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the appropriate view
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create a new object of Company
        $company = new Company;

        // Assign the request values to the new company
        $company->name = $request->input('name');
        $company->delegate_name = $request->input('delegate_name');
        $company->phone = $request->input('phone');
        $company->address = $request->input('address');
        $company->web_site = $request->input('web_site');
        $company->email = $request->input('email');
        $company->fax = $request->input('fax');

        // Save the new company
        $company->save();

        // Return the appropriate view
        return redirect()->route('company.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get the targeted company
        $company = Company::find($id);
        // Return the appropriate view
        return view('company.edit')->withCompany($company);
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
        // Get the targeted company
        $company = Company::find($id);

        // Update the properties of the company
        $company->name = $request->input('name');
        $company->delegate_name = $request->input('delegate_name');
        $company->phone = $request->input('phone');
        $company->address = $request->input('address');
        $company->web_site = $request->input('web_site');
        $company->email = $request->input('email');
        $company->fax = $request->input('fax');

        // Save the updates
        $company->save();

        // Return the appropriate view
        return redirect()->route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get the targeted company
        $company = Company::find($id);

        // Delete the record
        $company->delete();

        // Return the appropriate view
        return redirect()->route('company.index');
    }
}
