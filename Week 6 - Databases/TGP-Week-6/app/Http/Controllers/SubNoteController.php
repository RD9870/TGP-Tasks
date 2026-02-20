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
        // get all sub notes and return them
        return SubNote::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the incoming request data
        $inputs = $request->validate([
        'title'=> 'required|string|max:255',
        'description' => 'nullable|string',
        'isChecked' => 'boolean',
        'main_note' => 'required|integer'
        ]);

        // create a new sub note with the validated data
        $subNote = SubNote::create($inputs);

        // return a response with the created sub note
        return response()->json(['message' => 'New sub note added', 'subNote' => $subNote], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return the sub note with the specified id, or return a 404 error if not found
        return SubNote::find($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // find the sub note by id, or return a 404 error if not found
        $Subnote = SubNote::find($id);

        // validate the incoming request data
        $inputs = $request->validate([
        'title'=> 'required|string|max:255',
        'description' => 'nullable|string',
        'isChecked' => 'boolean',
        ]);

        // update the sub note with the validated data
        $Subnote->update($inputs);

        // return a response with the updated sub note
        return response()->json(['message' => 'Sub note updated successfully', 'subNote' => $Subnote]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // find the sub note by id, or return a 404 error if not found
        $Subnote = SubNote::find($id);

        // delete the sub note
        $Subnote->delete();

        // return a response with a success message
        return response()->json(['message' => 'Sub Note deleted successfully']);
    }
}
