<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): Response
    {
        // Log the email and token to ensure they are retrieved correctly
        \Log::info('Reset Password Props:', [
            'email' => $request->query('email'), // Retrieves email from the query string
            'token' => $request->route('token'), // Retrieves token from the URL
        ]);

        // Pass the email and token to the Vue component
        return Inertia::render('Auth/ConfirmPassword', [
            'email' => $request->query('email'), // Make sure the email is coming from the query
            'token' => $request->route('token'), // Make sure the token is coming from the route
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => __('Password reset successfully.')])
            : response()->json(['message' => __('Password reset failed.')], 400);
    }



}
