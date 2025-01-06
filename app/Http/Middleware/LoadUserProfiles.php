<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoadUserProfiles
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Load the user's profiles if authenticated
        if ($user = Auth::user()) {
            $user->load('profiles');
        }

        // Continue to the next request
        return $next($request);
    }
}
