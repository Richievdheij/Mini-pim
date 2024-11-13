<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run()
    {
        $admin = Profile::firstOrCreate(['name' => 'Admin']);
        $editor = Profile::firstOrCreate(['name' => 'Editor']);
        $viewer = Profile::firstOrCreate(['name' => 'Viewer']);

        $adminPermissions = Permission::all();
        $editorPermissions = Permission::whereIn('name', ['view_pim', 'edit_pim', 'view_users'])->get();
        $viewerPermissions = Permission::where('name', 'view_pim')->get();

        $admin->permissions()->syncWithoutDetaching($adminPermissions);
        $editor->permissions()->syncWithoutDetaching($editorPermissions);
        $viewer->permissions()->syncWithoutDetaching($viewerPermissions);
    }
}

