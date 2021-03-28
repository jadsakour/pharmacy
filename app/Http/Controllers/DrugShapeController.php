<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DrugShape;

class DrugShapeController extends Controller
{
    /**
     * Assign appropriate permissions.
     */
    public function __construct()
    {
        $this->middleware('permission:drug-shape-list|drug-shape-create|drug-shape-update|drug-shape-delete', ['only' => ['index']]);
        $this->middleware('permission:drug-shape-list', ['only' => ['index']]);
        $this->middleware('permission:drug-shape-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:drug-shape-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:drug-shape-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all the shapes
        $shapes = DrugShape::all();
        // Return the appropriate view
        return view('shape.index')->withShapes($shapes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the appropriate view
        return view('shape.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create a new object of DrugShape
        $shape = new DrugShape;

        // Assign the request values to the new shape
        $shape->name = $request->input('name');

        // Save the new shape
        $shape->save();

        // Return the appropriate view
        return redirect()->route('shape.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get the targeted shape
        $shape = DrugShape::find($id);
        // Return the appropriate view
        return view('shape.edit')->withShape($shape);
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
        // Get the targeted shape
        $shape = DrugShape::find($id);

        // Update the name of the category
        $shape->name = $request->input('name');

        // Save the updates
        $shape->save();

        // Return the appropriate view
        return redirect()->route('shape.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get the targeted shape
        $shape = DrugShape::find($id);

        // Delete the record
        $shape->delete();

        // Return the appropriate view
        return redirect()->route('shape.index');
    }
}
