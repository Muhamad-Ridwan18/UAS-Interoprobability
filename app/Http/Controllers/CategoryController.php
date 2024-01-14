<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
      $categories = Category::all();
      return response()->json($categories);
    }

    public function store(Request $request){
      $this->validate($request, [
        'name' => 'required|unique:categories'
      ]);

      $category = Category::create($request->all());
      return response()->json($category);
    }

    public function update(Request $request, $id){
      $this->validate($request, [
        'name' => 'required|unique:categories'
      ]);

      $category = Category::find($id);
      $category->update($request->all());
      return response()->json($category);
    }

    public function destroy($id){
      $category = Category::find($id);
      $category->delete();
      return response()->json($category);
    }
}
