<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all users with their associated notes and return them
        $user = User::all();
        return $user->Load("userNotes");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the incoming request data
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        // create a new user with the validated data
        $user = User::create($data);
        // return a response with the created user
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // find the user by id, or return a 404 error if not found
        $user = User::findOrFail($id);
        // return the user with its associated notes
        return $user->Load("userNotes");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // find the user by id, or return a 404 error if not found
        $user = User::findOrFail($id);
        // validate the incoming request data
        $data = $request->validate([
            'name' => 'string',
            'email' => 'string',
            'password' => 'string',
        ]);
        // update the user with the validated data
        $user->update($data);
        // return a response with the updated user
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // find the user by id, or return a 404 error if not found
        $user = User::findOrFail($id);
        // delete the user
        $user->delete();
        // return a response with a success message
        return response()->json(['message' => 'user deleted successfully']);
    }
}
