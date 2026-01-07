<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;

use function Laravel\Prompts\select;

class UserController extends Controller
{

    public function blockUser(Request $request)
    {
        //get username from request
        $userName = $request->username;
        //get user data from database
        $user =FacadesDB::table('users')->
        //get the user id of the included username
            select("id")
            ->where("username", $userName)
            //get the first result
            ->first();

            //updste the status to blocked
        FacadesDB::table('users')
            ->where("id", $user->id)
            ->update( ["status" => "blocked"]);

            //return a message
            return response()->json([
                "message"=> "user with the name $userName has been blocked"
            ]);
    }
}
