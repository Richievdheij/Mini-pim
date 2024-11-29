<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): Response
    {
        // Render the Forgot Password view with any status messages
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the email field
        $request->validate([
            'email' => 'required|email',
        ]);

        // Attempt to send a reset link to the provided email
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Check if the reset link was successfully sent
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'We have emailed your password reset link!');
        }

        // Throw an error for invalid email or failure to send
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
