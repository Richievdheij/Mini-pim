<?php

namespace App\Http\Services;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

/**
 * Service class to handle user-related business logic, including creation,
 * updating, deletion, and retrieving users and profiles based on the
 * authenticated user's permissions.
 */
class UserService
{
    /**
     * Handle the creation of a new user.
     * @param $request
     *
     * @return void
     */
    public function storeUser($request): void
    {
        // Create a new user with the provided data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->profiles()->sync($request->profiles);
    }

    /**
     * Update the specified user in storage.
     * @param $request
     * @param User $user
     *
     * @return void
     */
    public function updateUser($request, User $user): void
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        if ($request->has('profiles')) {
            $user->profiles()->sync($request->profiles);
        }
    }

    /**
     * Remove the specified user from storage.
     * @param User $user
     *
     * @return void
     */
    public function deleteUser(User $user): void
    {
        $user->delete();
    }

    /**
     * Retrieve all users based on the authenticated user's profile.
     * @param $authUser
     *
     * @return Collection
     */
    public function getUsersForAuthUser($authUser): Collection
    {
        // If the authenticated user has the admin profile, return all users
        if ($authUser->profiles->first()->id === 1) {
            return User::with('profiles')->get();
        }

        // Otherwise, return only users with the same profile as the authenticated user
        return User::with('profiles')
            ->whereHas('profiles', function ($query) use ($authUser) {
                $query->where('id', $authUser->profiles->first()->id);
            })
            ->get();
    }

    /**
     * Retrieve all profiles based on the authenticated user's profile.
     * @param $authUser
     *
     * @return mixed
     */
    public function getProfilesForAuthUser($authUser): mixed
    {
        return $authUser->profiles->contains('id', 1)
            ? Profile::all() // Admin profile: return all profiles
            : Profile::where('id', $authUser->profiles->first()->id)->get(); // Other profiles: return only the user's profile
    }
}
