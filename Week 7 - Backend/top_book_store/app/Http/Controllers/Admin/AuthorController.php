<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AuthorResource;
use App\Http\Resources\Admin\AuthroResource;
use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    //change the status of a newly signed up author to approved
    public function approve($user_id)
    {
        //get users of type author
        $user = User::where('type', 'author')
        //get the ones that don't have an approve status
        ->where('status','!=','approve')
        //get the ones with the id passed to the function
        ->where('id', $user_id)
        //get the first one or return null
        ->firstOrFail();
        //call the approve function in the user model
        $user->approve();
        //return a message to the user
        return response()->json([
            'message' => 'author approved'
        ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // prepare query
        $authorQuery = User::query();
        //get users with author type
        $authorQuery->where('type', 'author');
        //if the request has the parameter status
        if ($request->has('status')) {
            //get users with that status
            $authorQuery->where('status', $request->status);
        }
        //fetch author as well as tbe author relationship from user model
        $authors = $authorQuery->with('author')->get();
        //retur the data formated like in the resources
        return AuthorResource::collection($authors);
    }
}
