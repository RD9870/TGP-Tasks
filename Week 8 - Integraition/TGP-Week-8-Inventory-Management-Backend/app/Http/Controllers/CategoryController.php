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
        $categories = Category::all();
        return $categories;
    }
    public function filtercut()
    {
     $categories = Category::with('subcategories')->get();

$formattedCategories = $categories->map(function ($category) {
    return [
        'label' => $category->name,
        'options' => $category->subcategories->pluck('name')->toArray(),
    ];
});

return response()->json([
    'cats' => $formattedCategories]);
    }


    public function store(CategoryRequest $request)
    {
         $existing = Category::where('name', $request->name)->first();

    if ($existing) {
        return response()->json([
            'message' => 'Category with this name already exists',
            'category' => $existing
        ], 409);
    }
        $newCat =Category::create($request->validated());
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
        $category = Category::find($id);
        if($category){
            return $category;
        }
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
        $category = Category::find($id);
        if($category){
            $input = $request->validated();
            $category->update($input);
            return response()->json([
                "message"=>"category ". $category->name ." has been updated",
                "new category"=>$category,
            ]);
        }
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
        $category = Category::find($id);
        if($category){
            $category->subcategories()->delete();
            $category->delete();
            return response()->json([
                'message'=>"category".$category->name ." was deleted"
            ], 200);
        }
        else{
                return response()->json([
        'message'=>'Sorry, catefory was not found'
        ], 404);
        }
    }
}
