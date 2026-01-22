<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $comments = Comment::all();
        return $comments->Load("noteComments");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $data = $request->validate([
            'content' => 'required|string',
            'note_id' => 'required|integer',
        ]);
        $comment = Comment::create($data);
        // return response()->json($comment, 201);
              return response()->json(['message' => 'comment added successfully']);    }

              
              /**
               * Display the specified resource.
     */
    public function show(string $id)
    {
        return comment::findOrFail($id);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $comment = comment::findOrFail($id);
        $data = $request->validate([
            'content' => 'required|string',
            'note_id' => 'required|integer',
        ]);
        $comment->update($data);
        return response()->json($note);
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy(string $id)
    {
  $comment = Comment::find($id);
      $comment->delete();

      return response()->json(['message' => 'comment deleted successfully']);    }

}