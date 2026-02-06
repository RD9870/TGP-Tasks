<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if the user is not an approved author
        if ($request->user()->type != 'author' ) {
            // user is not an author, return error message
            return response()->json([
                'message' => 'you are not an author'
            ], 401);
        }
        // check if the user is a not approved author
        if ($request->user()->status != 'approve') {
            // user is not an approved author, return error message
            return response()->json([
                'message' => 'you are being approve yet'
            ], 401);
        }
        // user is an approved author, allow access to the route
        return $next($request);
    }
}
