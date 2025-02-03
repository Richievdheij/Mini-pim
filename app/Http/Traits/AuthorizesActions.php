<?php

namespace App\Http\Traits;

/**
 * Trait for authorizing actions, such as checking if the user has permission to perform an action.
 */
trait AuthorizesActions
{
    /**
     * Check if the current user has permission to perform an action.
     *
     * @param string $permission
     * @return void
     */
    public function authorizeAction(string $permission): void
    {
        $user = auth()->user();

        // Check if the user is authenticated and has the required permission
        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
