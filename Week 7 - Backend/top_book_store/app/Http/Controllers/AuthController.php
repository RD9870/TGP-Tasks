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
            'username'=>['required','string','min:4','max:250'],
            'password'=>['required','min:8']
        ]);




        $user = User::where('username',$inputs['username'])->first();


        if(!$user || !Hash::check($inputs['password'],$user->password)){
            return response()->json([
                'message'=>'wrong username or password'
            ],401);
        }

        if($user->status == "blocked"){
            return response()->json([
                'message'=>'sorry you have been blocked'
            ],401);
        }

        // if(!$user){
        //     return response()->json([
        //         'message'=>'wrong username'
        //     ],401);
        // }
        // else if(!Hash::check($inputs['password'],$user->password)){
        //        return response()->json([
        //         'message'=>'wrong password'
        //     ],401);
        // }


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
