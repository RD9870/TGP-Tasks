<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if the user is a customer
        if($request->user()->type == 'customer'){
        // user is a customer, allow access to the route
        return $next($request);
        }
        // user is not a customer, return error message
        return response()->json([
            'message'=>'you are not a customer'
        ],401);
    }
}
