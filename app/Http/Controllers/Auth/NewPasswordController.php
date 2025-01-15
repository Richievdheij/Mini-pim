<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NewPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

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
        // Handle the password reset process
        $request->resetPassword();

        return redirect()
            ->route('login')
            ->with('status', trans('Your password has been reset successfully. Please log in with your new password.'));
    }
}
