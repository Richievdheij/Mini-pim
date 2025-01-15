<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

/**
 * This controller handles the authentication of users and the management of authenticated sessions.
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return Response
     */
    public function create(): Response
    {
        // Render the login page with properties for resetting password availability and status
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Extract user credentials and "remember me" preference
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Attempt to authenticate the user with the provided credentials
        if (Auth::attempt($credentials, $remember)) {
            // Regenerate the session to prevent session fixation attacks
            $request->session()->regenerate();

            // Redirect to the intended page after successful login
            return redirect()->intended(route('dashboard'));
        }

        // Handle failed login attempt with an error message
        return back()->withErrors([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log out the authenticated user
        Auth::guard('web')->logout();

        // Invalidate the current session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to the login page after logout
        return redirect('/login');
    }
}
