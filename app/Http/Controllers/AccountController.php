<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    /**
     * Show the default account edit form.
     *
     * @return Response
     */
    public function edit(): Response
    {
        return Inertia::render('Account/Edit', [ // Default component
            'status' => session('status'),
        ]);
    }

    /**
     * Show the PIM-specific account edit form.
     *
     * @return Response
     */
    public function editPim(): Response
    {
        return Inertia::render('Account/Pim-sidebar/PimEdit', [ // Account PIM component
            'status' => session('status'),
        ]);
    }

    /**
     * Update account information (shared logic).
     *
     * @param ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        // Reset email verification if email is changed
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Determine where to redirect based on the route name
        $route = $request->routeIs('pim.account.*') ? 'pim.account.edit' : 'account.edit';

        return Redirect::route($route);
    }

    /**
     * Delete the user's account (shared logic).
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Log out, delete user, and clear session
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/login')->with('status', 'Your account has been deleted successfully.');
    }
}
