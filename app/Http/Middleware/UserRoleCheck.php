<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserRoleCheck
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user has user_role = 0
        if ($request->user() && $request->user()->user_role == 0) {
            return $next($request);
        }
        
        // If user_role is not 0, redirect back with an error message
        return redirect()->back()->with('error', 'You are not authorized to access this page.');
    }
}
