<?php

namespace App\Http\Controllers;

use App\Http\Requests\userSignUpValidation;
use App\Http\Requests\userLoginValidation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(userSignUpValidation $request)
    {
        $inputs = $request->validated();

        //TODO:: make db transaction
        $user = User::create($inputs);

        return response()->json([
            'message'=>'you are signed up '
        ],201);



    }


  public function login(userLoginValidation $request)
    {
        $inputs = $request->validated();

        $user = User::where('phone',$inputs['phone'])->first();


        if(!$user || !Hash::check($inputs['password'],$user->password)){
            return response()->json([
                'message'=>'wrong phone or password'
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
            "Message" => "The user {$user->name} has logged out",
        ]);
    }
}
