<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Mime\Message;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // validate the request data
        $inputs = $request->validate([
            'username'=>['required','string'],
            'password'=>['required','min:8']
        ]);
        // check if the user exists
        $user = User::where('username',$inputs['username'])->first();
        // check if the password is correct
        if(!$user || !Hash::check($inputs['password'],$user->password)){
            // the user does not exist or the password is incorrect return an error
            return response()->json([
                'message'=>'wrong username or password'
            ],401);
        }
        // the user exists and the password is correct create a token for the user
        $token = $user->createToken('token')->plainTextToken;
        // return the token to the client
        return response()->json([
            'access_token'=>$token,
            'type'=>'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        // get the authenticated user from requests
        $user =$request->user();
        // delete the current access token of the user
        $user->currentAccessToken()->delete();
        // return a message to the client
        return response()->json([
            "Message" => "The user {$user->username} has logged out",
        ]);
    }
}
