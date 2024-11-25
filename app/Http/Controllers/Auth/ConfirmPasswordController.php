<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ConfirmPasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(): Response
    {
        // Render the confirm password view
        return Inertia::render('Auth/ConfirmPassword');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the provided password against the user's stored password
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            // Throw validation exception if the password is incorrect
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        // Mark the password as confirmed by updating the session
        $request->session()->put('auth.password_confirmed_at', time());

        // Redirect the user to their intended page (default: dashboard)
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
