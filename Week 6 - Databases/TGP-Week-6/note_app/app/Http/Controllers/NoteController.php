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
        // get all notes with their associated subNotes and noteComments and return them
        $note = Note::all();
        return $note->Load(["subNotes", "noteComments"]);
        // return Note::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the incoming request data
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'isChecked' => 'boolean',
            'user_id' => 'required|integer',
        ]);

        // create a new note with the validated data
        $note = Note::create($data);

        // return a response with the created note
        return response()->json($note, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // find the note by id, or return a 404 error if not found
        $note = Note::findOrFail($id);
        // return $note->Load("subNotes");
        // return the note with its associated subNotes and noteComments
        return $note->Load(["subNotes", "noteComments"]);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // find the note by id, or return a 404 error if not found
        $note = Note::findOrFail($id);

        // validate the incoming request data
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'isChecked' => 'boolean',
            'user_id' => 'integer',
        ]);

        // update the note with the validated data
        $note->update($data);

        // return a response with the updated note
        return response()->json(['message' => 'Note updated successfully', 'note' => $note]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // find the note by id, or return a 404 error if not found
        $note = Note::findOrFail($id);
        // delete the note
        $note->delete();
        // return a response with a success message
        return response()->json(['message' => 'Note deleted successfully']);
    }
}
