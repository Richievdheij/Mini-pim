<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NewPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;

/**
 * NewPasswordController to reset the user's password.
 */
class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        // Log email and token for debugging purposes
        Log::info('Reset Password Props:', [
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
     * @param NewPasswordRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(NewPasswordRequest $request): RedirectResponse
    {
        // Validate the request
        $request->validated();

        // Fetch the user based on email
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => trans('No user found with the provided email address.'),
            ]);
        }

        // Attempt to reset the password
        $status = Password::reset(
            $request->validated(),
            static function ($user, $password) {
                // Update password in the database
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                // Fire the PasswordReset event
                event(new PasswordReset($user));
            }
        );

        // Check the status and handle accordingly
        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => trans('Password reset failed. Please try again.'),
            ]);
        }

        // Redirect to login page with success message
        return redirect()->route('login')
            ->with('status', trans('Your password has been reset successfully. Please log in with your new password.'));
    }
}
