<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create profiles
        $admin = Profile::firstOrCreate(['name' => 'Admin']); // firstOrCreate() method is used to create a new profile if it doesn't exist
        $editor = Profile::firstOrCreate(['name' => 'Editor']);
        $viewer = Profile::firstOrCreate(['name' => 'Viewer']);

        // Get permissions
        $adminPermissions = Permission::all(); // Get all permissions
        $editorPermissions = Permission::whereIn('name', ['view_pim', 'edit_pim', 'view_users'])->get(); // Get specific permissions
        $viewerPermissions = Permission::where('name', 'view_pim')->get();

        // Attach permissions to profiles
        $admin->permissions()->syncWithoutDetaching($adminPermissions); // syncWithoutDetaching() method is used to attach permissions to profiles without removing existing permissions
        $editor->permissions()->syncWithoutDetaching($editorPermissions);
        $viewer->permissions()->syncWithoutDetaching($viewerPermissions);
    }
}

