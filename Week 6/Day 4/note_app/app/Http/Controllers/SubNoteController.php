<?php

namespace App\Http\Controllers;

use App\Models\SubNote;
use Illuminate\Http\Request;

class SubNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SubNote::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
        'title'=> 'required|string|max:255',
        'description' => 'nullable|string',
        'isChecked' => 'boolean',
        'main_note' => 'required|integer'
        ]);

    SubNote::create($inputs);

    return response()->json(['message' => 'New sub note added'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return SubNote::find($id);    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $Subnote = SubNote::find($id);
        $inputs = $request->validate([
        'title'=> 'required|string|max:255',
        'description' => 'nullable|string',
        'isChecked' => 'boolean',
        ]);
      $Subnote->update($inputs);
       return response()->json($Subnote);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $Subnote = SubNote::find($id);
      $Subnote->delete();

      return response()->json(['message' => 'Sub Note deleted successfully']);
    }
}
