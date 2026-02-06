<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      public function index()
    {
        // return all categories
        $categories = Category::all();
        return $categories;
    }

    // filter categories with their subcategories
    public function filtercut()
    {
    // get all categories with their subcategories
    $categories = Category::with('subcategories')->get();
    // format the categories to have the name as label and the subcategories as options
    $formattedCategories = $categories->map(function ($category) {
        return [
            'label' => $category->name,
            'options' => $category->subcategories->pluck('name')->toArray(),
        ];
});
    // return the formatted categories
    return response()->json([
        'cats' => $formattedCategories]);
        }

    public function store(CategoryRequest $request)
    {
        // get the first category with the same name as the request
        $existing = Category::where('name', $request->name)->first();
        // return a message if the category already exists
        if ($existing) {
            return response()->json([
                'message' => 'Category with this name already exists',
                'category' => $existing
            ], 409);
    }
        // it doesn't exist create it
        $newCat =Category::create($request->validated());
        // return the message
        return response()->json([
            'message'=>'category created',
            'category'=> $newCat
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // find a spcific category
        $category = Category::find($id);
        // return the category if it exsists
        if($category){
            return $category;
        }
        // retetn an error message
        else {
            return response()->json([
            'message'=>'Sorry, category was not found'
        ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        // find a specific category
        $category = Category::find($id);
        // if it exisist
        if($category){
            // validate request data
            $input = $request->validated();
            // update the category
            $category->update($input);
            // return a response
            return response()->json([
                "message"=>"category ". $category->name ." has been updated",
                "new category"=>$category,
            ]);
        }
        // it doesn't exsist return error
        else {
            return response()->json([
            'message'=>'Sorry, category was not found'
        ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // find a category by id
        $category = Category::find($id);
        // the category exsists
        if($category){
            // delete the related subcategories
            $category->subcategories()->delete();
            // then delete the category
            $category->delete();
            // retunn a response
            return response()->json([
                'message'=>"category".$category->name ." was deleted"
            ], 200);
        }
        // show error oif it doesn't exsist
        else{
            return response()->json([
                'message'=>'Sorry, catefory was not found'
            ], 404);
        }
    }
}
