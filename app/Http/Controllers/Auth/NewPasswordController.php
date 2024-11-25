<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRules;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): Response
    {
        // Log email and token for debugging purposes
        \Log::info('Reset Password Props:', [
            'email' => $request->query('email'),
            'token' => $request->route('token'),
        ]);

        // Render the reset password view with email and token passed to the frontend
        return Inertia::render('Auth/ConfirmPassword', [
            'email' => $request->query('email'),
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate input fields with custom rules for password strength and confirmation
        $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed', // Ensure password matches confirmation field
                PasswordRules::min(8)
                    ->mixedCase() // At least one uppercase and one lowercase character
                    ->letters() // At least one letter
                    ->numbers() // At least one number
                    ->symbols(), // At least one special character
                function ($attribute, $value, $fail) use ($request) {
                    // Custom validation to ensure the new password is not the same as the current one
                    $user = User::where('email', $request->email)->first();
                    if ($user && Hash::check($value, $user->password)) {
                        $fail(__('The new password cannot be the same as your current password.'));
                    }
                },
            ],
            'token' => 'required', // Ensure a valid token is provided
        ]);

        // Attempt to reset the password using the provided details
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Update the user's password in the database
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();

                // Trigger the PasswordReset event
                event(new PasswordReset($user));
            }
        );

        // Redirect user based on the outcome of the password reset process
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __('Your password has been reset successfully. Please log in with your new password.'));
        } else {
            return redirect()->back()->withErrors(['email' => __('Password reset failed. Please try again.')]);
        }
    }
}
