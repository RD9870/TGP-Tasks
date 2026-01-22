<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //show all cats
    public function index()
    {
        $categories = Category::all();
        return $categories;
    }

    //add a new category
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'name'=>['required']
        ]);
        $category = Category::create($inputs);
        return response()->json([
            'message'=>'category created',
            'category'=> $category
        ]);
    }


    //show a specific category
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return $category;
    }

    //update a specific category
    public function update(Request $request, string $id)
    {
        $inputs = $request->validate([
            'name'=>['required']
        ]);
        $category = Category::findOrFail($id);
        $category->update($inputs);
        return $category;
    }

    //delete a category
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
            'message'=>'category deleted'
        ]);
    }
}
