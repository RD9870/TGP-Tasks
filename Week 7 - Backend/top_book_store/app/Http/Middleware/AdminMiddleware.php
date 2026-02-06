<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if the user is admin or not
        if($request->user()->type == 'admin'){
            // allow user to access the route
            return $next($request);
        }
        // user is not an admin, return error message
        return response()->json([
            'message'=>'you are not a admin'
        ],401);
    }
}
