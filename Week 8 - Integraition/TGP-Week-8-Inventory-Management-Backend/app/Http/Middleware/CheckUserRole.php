<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // get the authenticated user from the request
        $user = $request->user();
        // if user is not authenticated or does not have one of the established roles, return 403
        if (!$user || !in_array($user->type, $roles)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        // user is authorized and has a role proceed with the request
        return $next($request);
    }
}
