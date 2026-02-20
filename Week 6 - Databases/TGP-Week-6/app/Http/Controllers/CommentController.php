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
        // get all comments with their associated note and return them
        $comments = Comment::all();
        return $comments->Load("noteComments");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the incoming request data
    $data = $request->validate([
            'content' => 'required|string',
            'note_id' => 'required|integer',
        ]);
        // create a new comment
        $comment = Comment::create($data);
        // return a success response with the created comment
        return response()->json(['message' => 'comment added successfully', 'comment' => $comment], 201);    }



              /**
               * Display the specified resource.
     */
    public function show(string $id)
    {
        // return the commet with the specified id, or return a 404 error if not found
        return comment::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // find the comment by id
        $comment = comment::findOrFail($id);
        // validate the incoming request data
        $data = $request->validate([
            'content' => 'required|string',
            'note_id' => 'required|integer',
        ]);
        // update the comment with the validated data
        $comment->update($data);
        // return response()->json($note);
        // return a response with the updated comment
        return response()->json(
            ['message' => 'comment updated successfully', 'comment' => $comment]);
    //     return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy(string $id)
    {
        // find the comment by id
        $comment = Comment::find($id);
        // delete the comment
        $comment->delete();
        // return a success response
        return response()->json(['message' => 'comment deleted successfully']);
    }

}
