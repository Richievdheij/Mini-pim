<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountUpdateRequest;
use App\Http\Requests\DeleteUpdateRequest;
use App\Http\Services\AccountService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Handles account settings actions (edit, update, delete).
 *
 */
class AccountController extends Controller
{
    private AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

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
     *
     * @return RedirectResponse
     */
    public function update(AccountUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Use the AccountService to update the user's account
        $this->accountService->updateAccount($validated);

        // Determine route to redirect to after update
        $route = $request->routeIs('pim.account.*') ? 'pim.account.edit' : 'account.edit';

        return Redirect::route($route);
    }

    /**
     * Delete the user's account (shared logic).
     *
     * @param DeleteUpdateRequest $request
     *
     * @return RedirectResponse
     */
    public function destroy(DeleteUpdateRequest $request): RedirectResponse
    {
        // Validate the password before allowing deletion
        $request->validated();

        // Use the AccountService to delete the user's account
        $this->accountService->deleteAccount();

        return Redirect::to('/login');
    }
}
