<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users
        $users = User::all();
        $defaultProfile = Profile::firstOrCreate(['name' => 'Default']); // Create the Default profile

        // Assign the Default profile to all users
        foreach ($users as $user) {
            $user->profiles()->syncWithoutDetaching([$defaultProfile->id]);
        }
    }
}
