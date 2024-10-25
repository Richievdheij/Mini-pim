<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        // Find the first user
        $user = User::find(1);  // Replace with actual user ID or logic

        // Find the role 'admin'
        $role = Role::where('name', 'admin')->first();

        // Attach the 'admin' role to the user
        if ($user && $role) {
            $user->roles()->attach($role);
        }
    }
}
