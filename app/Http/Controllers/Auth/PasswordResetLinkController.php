<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetLinkRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controller for handling the password reset link request.
 */
class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return Response
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
     * @param PasswordResetLinkRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(PasswordResetLinkRequest $request): RedirectResponse
    {
        // Validate the request
        $validated = $request->validated();

        // Attempt to send a reset link to the provided email
        $status = Password::sendResetLink(['email' => $validated['email']]);

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
