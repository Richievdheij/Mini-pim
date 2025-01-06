<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignPermissionCategoriesSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // PIM Permissions
            ['name' => 'view_pim', 'category' => 'PIM'],
            ['name' => 'edit_pim', 'category' => 'PIM'],
            ['name' => 'delete_pim', 'category' => 'PIM'],

            // User Permissions
            ['name' => 'view_users', 'category' => 'Users'],
            ['name' => 'edit_users', 'category' => 'Users'],
            ['name' => 'delete_users', 'category' => 'Users'],

            // Rights/Security Permissions
            ['name' => 'manage_permissions', 'category' => 'Rights/Security'],
            ['name' => 'view_permissions', 'category' => 'Rights/Security'],

            // Reports Permissions
            ['name' => 'view_reports', 'category' => 'Reports'],
            ['name' => 'generate_reports', 'category' => 'Reports'],

            // Data Permissions
            ['name' => 'export_data', 'category' => 'Data'],
            ['name' => 'view_dashboard', 'category' => 'Dashboard'],

            // Profile Permissions
            ['name' => 'create_profiles', 'category' => 'Profiles'],
            ['name' => 'edit_profiles', 'category' => 'Profiles'],
            ['name' => 'delete_profiles', 'category' => 'Profiles'],
            ['name' => 'view_profiles', 'category' => 'Profiles'],

            // User Creation Permissions
            ['name' => 'create_users', 'category' => 'Users'],
        ];

        // Update permissions with categories
        foreach ($permissions as $permission) {
            DB::table('permissions')
                ->where('name', $permission['name'])
                ->update(['category' => $permission['category']]);
        }
    }
}
