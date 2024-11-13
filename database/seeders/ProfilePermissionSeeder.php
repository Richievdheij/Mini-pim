<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class ProfilePermissionSeeder extends Seeder
{
    public function run()
    {
        // Zorg ervoor dat het Admin-profiel bestaat
        $adminProfile = Profile::firstOrCreate(['name' => 'Admin']);

        // Haal alle permissies op en koppel ze aan het Admin-profiel
        $permissions = Permission::all();
        $adminProfile->permissions()->sync($permissions->pluck('id'));
    }
}
