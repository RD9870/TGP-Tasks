<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        // validate inputs
        $inputs = $request->validate([
            //user
            'name'=>['required'],
            'username'=>['required','unique:users'],
            'password'=>['required'],
            // author
            'bio'=>['required'],
            'country'=>['required']
        ]);
        // add type and status
        $inputs['type'] = 'author';
        $inputs['status'] = 'approve';

        // create user and author
        $user = User::create($inputs);
        $user->author()->create($inputs);

        // return response
        return response()->json([
            'message'=>'you ware signup wait for approve'
        ],201);



    }
}
