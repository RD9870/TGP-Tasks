<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all users except admins
        $authorQuery = User::where('type','!=' ,'admin')->get();
        return $authorQuery;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request){
        // create a new user with the validated request data
        $user =User::create($request->validated());
        // return a success message
        return response()->json([
            'message'=>'new user created',
            'user'=> $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // find the user with the given id
        $user = User::find($id);
        // return the user data if found
        if($user){
            return response()->json([
            'userdata'=> $user,
            ]);
        }
        // return error message if user not found
        else {
            return response()->json([
            'message'=>'Sorry, this user was not found'
        ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        // find the user with the given id
        $user = User::find($id);
        // update and return the user data if found
        if($user){
            $input = $request->validated();
            $user->update($input);
                    return response()->json([
            'message'=>'user has been updated',
            'userdata'=> $user,
            ]);
        }
        // return error message if user not found
        else {
            return response()->json([
            'message'=>'Sorry, user was not found'
        ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    // find the user with the given id
    $user = User::find($id);
    // delete and return a success message if found
        if($user){
            $user->delete();
            return response()->json([
                'message'=>"user ". $user->username ." has been deleted"
            ], 200);
        }
        // return error message if user not found
        else{
        return response()->json([
            'message'=>'Sorry, user was not found'
        ], 404);
        }
    }
}
