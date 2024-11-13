<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'view_pim', 'description' => 'View PIM module'],
            ['name' => 'edit_pim', 'description' => 'Edit PIM module'],
            ['name' => 'delete_pim', 'description' => 'Delete PIM module'],
            ['name' => 'view_users', 'description' => 'View users list'],
            ['name' => 'edit_users', 'description' => 'Edit users'],
            ['name' => 'delete_users', 'description' => 'Delete users'],
            ['name' => 'manage_permissions', 'description' => 'Manage permissions'],
            ['name' => 'view_reports', 'description' => 'View reports'],
            ['name' => 'generate_reports', 'description' => 'Generate reports'],
            ['name' => 'export_data', 'description' => 'Export data'],
            ['name' => 'view_dashboard', 'description' => 'Access the dashboard'],
            ['name' => 'create_users', 'description' => 'Create a new user'],
            ['name' => 'create_profiles', 'description' => 'Create profiles'],
            ['name' => 'edit_profiles', 'description' => 'Edit profiles'],
            ['name' => 'delete_profiles', 'description' => 'Delete profiles'],
            ['name' => 'view_profiles', 'description' => 'View profiles'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], $permission);
        }
    }
}
