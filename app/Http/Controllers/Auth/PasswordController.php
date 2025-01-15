<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     * @param UpdatePasswordRequest $request
     * @return RedirectResponse
     */
    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        // Validate the current password, new password, and confirmation
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Update the user's password in the database
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect back after updating the password
        return back();
    }
}
