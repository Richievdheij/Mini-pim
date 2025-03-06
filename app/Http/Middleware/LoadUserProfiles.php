<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware for loading the user's profiles if they are authenticated.
 *
 */
class LoadUserProfiles
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Load the user's profiles if they are authenticated
        if ($user = Auth::user()) {
            $user->load('profiles');
        }
        return $next($request);
    }
}
