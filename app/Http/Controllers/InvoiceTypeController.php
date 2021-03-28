<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvoiceType;

class InvoiceTypeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      // Get all the types
      $types = InvoiceType::all();
      // Return the appropriate view
      return view('')->withTypes($types);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      // Return the appropriate view
      return view('');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      // Create a new object of InvoiceType
      $type = new InvoiceType;

      // Assign the request values to the new type
      $type->name = $request->input('name');

      // Save the new type
      $type->save();

      return redirect()->route('.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      // Get the targeted type
      $type = InvoiceType::find($id);
      // Return the appropriate view
      return view('')->withType($type);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      // Get the targeted type
      $type = InvoiceType::find($id);
      // Return the appropriate view
      return view('')->withType($type);
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
      // Get the targeted type
      $type = InvoiceType::find($id);

      // Update the properties of the company
      $type->name = $request->input('name');

      // Save the updates
      $type->save();

      return redirect()->route('.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      // Get the targeted type
      $type = InvoiceType::find($id);

      // Delete the record
      $type->delete();

      // Return the appropriate view
      return redirect()->route('.index');
  }
}
