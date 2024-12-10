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
        $users = User::all();
        $defaultProfile = Profile::firstOrCreate(['name' => 'Default']);

        foreach ($users as $user) {
            $user->profiles()->syncWithoutDetaching([$defaultProfile->id]);
        }
    }
}
