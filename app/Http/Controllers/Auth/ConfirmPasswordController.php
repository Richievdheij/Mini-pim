<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ConfirmPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Handles the user's password confirmation.
 */
class ConfirmPasswordController extends Controller
{
    /**
     * Show the password confirmation view.
     *
     * @return Response
     */
    public function show(): Response
    {
        // Render the confirm password view
        return Inertia::render('Auth/ConfirmPassword');
    }

    /**
     * Store the password confirmation.
     * @param ConfirmPasswordRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(ConfirmPasswordRequest $request): RedirectResponse
    {
        // Validate and confirm the password
        $request->confirmPassword();

        // Mark the password as confirmed by updating the session
        $request->session()->put('auth.password_confirmed_at', time());

        // Redirect the user to their intended page (default: dashboard)
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
