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
    public function index(){
        // return all subcategories
        $subCategories = Subcategory::all();
        return $subCategories;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubcategoryRequest $request){
        // check if a subcategory with the same name and category_id already exists
        $existing = Subcategory::where('name', $request->name)
                    ->where('category_id', $request->category_id)
                    ->first();
        // if subcat already exsists return an error
        if ($existing) {
            return response()->json([
                'message' => 'A subcategory with the same name already exists'
            ], 409);
        }
        // else create a new subcategory and return it in the response
        $newSubcat =Subcategory::create($request->validated());
            return response()->json([
                'message'=>'new subcategory created',
                'subcategory'=> $newSubcat
            ], 201);
    }


    public function show(string $id)
    {
        // find the subcategories with the given id
        $subCategories = Subcategory::where('category_id', $id)->get();
        // return thr subcategories with the id if found
        if($subCategories->isNotEmpty()){
            return $subCategories;
        }
        // no subcategories were found return an error message
        else {
            return response()->json([
            'message'=>'Sorry, subcategories with this category_id was not found'
        ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubcategoryRequest $request, string $id){
        // find the subcategory with the id
        $category = Subcategory::find($id);
        // if the subcategory is found
        if($category){
            // validate the incoming request data
            $input = $request->validated();
            // update it with the request data
            $category->update($input);
            // return a success message
            return response()->json([
                'message'=>'subcategory updated',
                'subcategory'=>$category
            ], 200);
        }
        // if the subcategory is not found return an error message
        else {
            return response()->json([
            'message'=>'Sorry, subcategory was not found'
        ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        // find the subcategory with the id
        $subCategory = Subcategory::find($id);
        // check if the subcategory exists
        if($subCategory){
            // delete the subcategory
            $subCategory->delete();
            // return a success message
            return response()->json([
            'message'=>'category deleted'
            ], 200);
        }
        // subcategory not found return an error message
        else{
            return response()->json([
            'message'=>'Sorry, subcategory was not found'
        ], 404);
        }
    }
}
