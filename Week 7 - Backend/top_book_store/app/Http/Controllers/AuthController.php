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
        // validate the inputs
        $inputs = $request->validate([
            'username'=>['required','string','min:4','max:250'],
            'password'=>['required','min:8']
        ]);
        // get the user if the user exists
        $user = User::where('username',$inputs['username'])->first();
        // check if the user exists and the password is correct
        if(!$user || !Hash::check($inputs['password'],$user->password)){
            //if either one is wrong return an error message
            return response()->json([
                'message'=>'wrong username or password'
            ],401);
        }
        // check if the user is blocked
        if($user->status == "blocked"){
            // if the user is blocked return an error message
            return response()->json([
                'message'=>'sorry you have been blocked'
            ],401);
        }
        // if the user is valid and not blocked create a token
        $token = $user->createToken('token')->plainTextToken;
        // return the token to the frontend
        return response()->json([
            'access_token'=>$token,
            'type'=>'Bearer'
        ]);
    }


    public function logout(Request $request)
    {
        // get the user from the request
        $user =$request->user();
        // delete the current access token
        $user->currentAccessToken()->delete();
        // return a message to the frontend
        return response()->json([
            "Message" => "The user {$user->username} has logged out",
        ]);
    }
}
