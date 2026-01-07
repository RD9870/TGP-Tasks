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
        $inputs = $request->validate([
            'username'=>['required','string'],
            'password'=>['required','min:8']
        ]);

        $user = User::where('username',$inputs['username'])->first();


        if(!$user || !Hash::check($inputs['password'],$user->password)){
            return response()->json([
                'message'=>'wrong username or password'
            ],401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'access_token'=>$token,
            'type'=>'Bearer'
        ]);

    }

    public function logout(Request $request)
    {
        $user =$request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            "Message" => "The user {$user->username} has logged out",
        ]);
    }
}
