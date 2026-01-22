<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubcategoryRequest;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $subCategories = Subcategory::all();
        return $subCategories;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubcategoryRequest $request)
    {
        $existing = Subcategory::where('name', $request->name)
                           ->where('category_id', $request->category_id)
                           ->first();
        $newSubcat =Subcategory::create($request->validated());
            return response()->json([
                'message'=>'new subcategory created',
                'subcategory'=> $newSubcat
            ], 201);
    }


    public function show(string $id)
    {
        $subCategories = Subcategory::where('category_id', $id)->get();
        if($subCategories->isNotEmpty()){
            return $subCategories;
        }
        else {
            return response()->json([
            'message'=>'Sorry, subcategories with this category_id was not found'
        ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubcategoryRequest $request, string $id)
    {
        $category = Subcategory::find($id);
        if($category){
            $input = $request->validated();
            $category->update($input);
        }
        else {
            return response()->json([
            'message'=>'Sorry, subcategory was not found'
        ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
 {
         $subCategory = Subcategory::find($id);
         if($subCategory){
             $subCategory->delete();
             return response()->json([
                 'message'=>'category deleted'
             ], 200);
         }
         else{
                 return response()->json([
            'message'=>'Sorry, user was not found'
        ], 404);
         }
    }
}
