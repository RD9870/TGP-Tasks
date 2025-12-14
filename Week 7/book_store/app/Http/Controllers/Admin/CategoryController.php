<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string'],
        ]);

        $new_category = Category::create($data);

        return response()-> json(
            [
                "message" => "new category was vreates",
                "data" => $new_category,
            ],
            201);
    }
    
    /**
     * Display the specified resource.
    */
    public function show(string $id)
    {
        return Category::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $data = request()->validate([
            'name' => 'required | string',
        ]);
        $category->update($data);

        return response()->json([
            'message' => "category with id: $id was updated",
            'data' => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
                'message' => "category with id: $id was deleted",
        ]);
    }
}
