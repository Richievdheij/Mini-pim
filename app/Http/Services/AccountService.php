<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/**
 * Service for handling account-related actions.
 *
 */
class AccountService
{
    /**
     * Update the account information of the authenticated user.
     *
     * @param array $validatedData
     * @return void
     */
    public function updateAccount(array $validatedData): void
    {
        $user = Auth::user();

        // Optionally hash the password if it's provided
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->fill($validatedData);
        $user->save();
    }

    /**
     * Delete the authenticated user's account.
     *
     * @return void
     */
    public function deleteAccount(): void
    {
        $user = Auth::user();
        $user->delete();
    }
}
