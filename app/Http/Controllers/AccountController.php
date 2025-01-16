<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountUpdateRequest;
use App\Http\Requests\DeleteUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Handles account settings actions (edit, update, delete).
 */
class AccountController extends Controller
{
    /**
     * Show the default account edit form.
     *
     * @return Response
     */
    public function edit(): Response
    {
        return Inertia::render('Account/Edit', [
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
        return Inertia::render('Account/Pim-sidebar/PimEdit', [
            'status' => session('status'),
        ]);
    }

    /**
     * Update account information (shared logic).
     *
     * @param AccountUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(AccountUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Update user account information
        $request->user()->fill($validated);
        $request->user()->save();

        // Determine route to redirect to after update
        $route = $request->routeIs('pim.account.*') ? 'pim.account.edit' : 'account.edit';

        return Redirect::route($route);
    }

    /**
     * Delete the user's account (shared logic).
     *
     * @param DeleteUpdateRequest $request
     * @return RedirectResponse
     */
    public function destroy(DeleteUpdateRequest $request): RedirectResponse
    {
        // Validate the password before allowing deletion
        $request->validated();

        $user = $request->user();

        // Log out the user, delete account, and clear session
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to login page with a success message
        return Redirect::to('/login')->with('status', 'Your account has been deleted successfully.');
    }
}
