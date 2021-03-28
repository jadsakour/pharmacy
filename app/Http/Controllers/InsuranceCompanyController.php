<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InsuranceCompany;

class InsuranceCompanyController extends Controller
{
    /**
     * Assign appropriate permissions.
     */
    public function __construct()
    {
        $this->middleware('permission:ins-com-list|ins-com-create|ins-com-update|ins-com-delete', ['only' => ['index']]);
        $this->middleware('permission:ins-com-list', ['only' => ['index']]);
        $this->middleware('permission:ins-com-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:ins-com-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:ins-com-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $insurance_companies = InsuranceCompany::all();

        return view('insurnce-company.index')->with(['insurance_companies' => $insurance_companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('insurnce-company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insurance_company = new InsuranceCompany;

        $insurance_company->name = $request->input('name');
        $insurance_company->address = $request->input('address');
        $insurance_company->phone = $request->input('phone');
        $insurance_company->email = $request->input('email');
        $insurance_company->discount = $request->input('discount');

        $insurance_company->save();

        return redirect()->route('insurnce-company.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $insurance_company = InsuranceCompany::find($id);

        return view('insurnce-company.edit')->with(['insurance_companies' => $insurance_company]);
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
        $insurance_company = InsuranceCompany::find($id);

        $insurance_company->name = $request->input('name');
        $insurance_company->address = $request->input('address');
        $insurance_company->phone = $request->input('phone');
        $insurance_company->email = $request->input('email');
        $insurance_company->discount = $request->input('discount');

        $insurance_company->save();

        return redirect()->route('insurnce-company.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $insurance_company = InsuranceCompany::find($id);
        $insurance_company->delete();
        return redirect()->route('insurnce-company.index');
    }
}
