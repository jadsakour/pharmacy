<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DrugCategory;

class DrugCategoryController extends Controller
{
    /**
     * Assign appropriate permissions.
     */
    public function __construct()
    {
        $this->middleware('permission:drugcat-list|drugcat-create|drugcat-update|drugcat-delete', ['only' => ['index']]);
        $this->middleware('permission:drugcat-list', ['only' => ['index']]);
        $this->middleware('permission:drugcat-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:drugcat-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:drugcat-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all the categories
        $categories = DrugCategory::all();
        // Return the appropriate view
        return view('category.index')->withCategories($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the appropriate view
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create a new object of DrugCategory
        $category = new DrugCategory;

        // Assign the request values to the new category
        $category->name = $request->input('name');

        // Save the new category
        $category->save();

        // Return the appropriate view
        return redirect()->route('category.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get the targeted category
        $category = DrugCategory::find($id);
        // Return the appropriate view
        return view('category.editCategory')->withCategory($category);
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
        // Get the targeted category
        $category = DrugCategory::find($id);

        // Update the name of the category
        $category->name = $request->input('name');

        // Save the updates
        $category->save();

        // Return the appropriate view
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get the targeted category
        $category = DrugCategory::find($id);

        // Delete the record
        $category->delete();

        // Return the appropriate view
        return redirect()->route('category.index');
    }
}
