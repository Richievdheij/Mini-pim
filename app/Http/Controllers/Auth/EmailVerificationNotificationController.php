<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        // Check if the user's email is already verified
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Send a new email verification link to the user
        $request->user()->sendEmailVerificationNotification();

        // Redirect back with a status message indicating the link has been sent
        return back()->with('status', 'verification-link-sent');
    }
}
