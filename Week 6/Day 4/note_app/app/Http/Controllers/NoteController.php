<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;



class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $note = Note::all();
        return $note->Load(["subNotes", "noteComments"]);
        // return Note::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'isChecked' => 'boolean',
            'user_id' => 'required|integer',
        ]);
        $note = Note::create($data);
        return response()->json($note, 201);
    }  

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $note = Note::findOrFail($id);
        return $note->Load("subNotes");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $note = Note::findOrFail($id);
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'isChecked' => 'boolean',
            'user_id' => 'integer',
        ]);
        $note->update($data);
        return response()->json($note);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $note = Note::findOrFail($id);
        $note->delete();
        return response()->json(['message' => 'Note deleted successfully']);
    }
}
