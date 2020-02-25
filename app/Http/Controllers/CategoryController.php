<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Category;

class CategoryController extends Controller
{

  public function __construct() {
    $this->middleware('auth')->except('getLogout');
  }
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $categories = Category::paginate(7);
    return view('admin.category.index')->withCategories($categories);
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('admin.category.create');

  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $this->validate($request, array(
      'name' => 'required|max:255'
    ));

    $category = new Category;
    $category->name = $request->name;

    $category->save();
    Session::flash('success', 'New Category was successfully created!');
    return redirect()->route('category.show', $category->id);
  }

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $category = Category::find($id);
    return view('admin.category.show')->withCategory($category);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $category = Category::find($id);
    return view('admin.category.edit')->withCategory($category);
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
    $this->validate($request, array(
      'name' => 'required|max:255'
    ));

    $category = Category::find($id);
    $category->name = $request->input('name');

    $category->save();
    Session::flash('success', 'Category was successfully updated!');

    return redirect()->route('category.show', $category->id);
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $category = Category::find($id);
    $category->delete();

    Session::flash('success', 'Category was successfully deleted!');
    return redirect()->route('category.index');
  }
}
