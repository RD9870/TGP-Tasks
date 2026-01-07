<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //update admin/customer/author profile
    public function updateProfile(Request $request)
    {
        //get the user
        $user = $request->user();
        //validate the data
        $data = $request->validate([
            'name'=>['sometimes','string'],
            'username'=>['sometimes','string','min:4','max:250',Rule::unique('users')->ignore($user->id)],
            'password'=>['sometimes','min:8'],
            'phone_number' =>['sometimes','string'],
            'address'=>['sometimes','string'],
            'email'=>['sometimes','email'],
            'bio'=>['sometimes','string','min:60'],
            'country'=>['sometimes','string'],
        ]);
        //if user updated the password hash it first
        if ($request->password){
            $data["password"] = Hash::make($request->password);
        }
        //update the user data
        $user->update($data);
        //return a msg
        return response()->json(
        [
            'message'=> 'user profile updated sucsessfully',
            'user info'=> $user,
        ]);
    }

//change the adress of the custo,er
    public function changeAddress(Request $request){
        //get the customer from current user id
        $customer = Customer::where('user_id', Auth::id())->first();
        //get the cart assosicated with that user
        $cart = Cart::where('user_id', Auth::id())->first();
        //update the address inside the customer
        $customer->update([
            'address'=> $request->address
        ]);
        //update the address inside the cart
        $cart->update([
            'address'=> $request->address
        ]);
        //show user ok msg
        return response()->json([
            'message'=> 'user $customer->username changed their address',
            "new address" => $customer->address
        ]);
    }
}
