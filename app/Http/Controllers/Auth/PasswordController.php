<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

/**
 * Controller for updating the user's password.
 */
class PasswordController extends Controller
{
    /**
     * Update the user's password.
     * @param UpdatePasswordRequest $request
     * @return RedirectResponse
     */
    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        // Validate the request
        $request->validated();

        // Update the user's password in the database
        $request->user()->update([
            'password' => Hash::make($request->input('password')),
        ]);

        // Redirect back after updating the password
        return back();
    }
}
