<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class ProfilePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create the Admin profile
        $adminProfile = Profile::firstOrCreate(['name' => 'Admin']);

        // Get all permissions
        $permissions = Permission::all();
        $adminProfile->permissions()->sync($permissions->pluck('id'));
    }
}
