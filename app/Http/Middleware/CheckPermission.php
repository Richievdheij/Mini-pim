<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware for checking if the user has a specific permission.
 * 
 */
class CheckPermission
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, $permission)
    {
        // Check if the user is authenticated and has the required permission
        if (!Auth::user() || !Auth::user()->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }

        // Continue to the next request
        return $next($request);
    }
}
