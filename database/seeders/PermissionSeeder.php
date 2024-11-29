<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'view_pim', 'title' => 'View PIM', 'description' => 'View PIM module'],
            ['name' => 'edit_pim', 'title' => 'Edit PIM', 'description' => 'Edit PIM module'],
            ['name' => 'delete_pim', 'title' => 'Delete PIM', 'description' => 'Delete PIM module'],
            ['name' => 'view_users', 'title' => 'View Users', 'description' => 'View users list'],
            ['name' => 'edit_users', 'title' => 'Edit Users', 'description' => 'Edit users'],
            ['name' => 'delete_users', 'title' => 'Delete Users', 'description' => 'Delete users'],
            ['name' => 'manage_permissions', 'title' => 'Manage Permissions', 'description' => 'Manage permissions'],
            ['name' => 'view_reports', 'title' => 'View Reports', 'description' => 'View reports'],
            ['name' => 'generate_reports', 'title' => 'Generate Reports', 'description' => 'Generate reports'],
            ['name' => 'export_data', 'title' => 'Export Data', 'description' => 'Export data'],
            ['name' => 'view_dashboard', 'title' => 'View Dashboard', 'description' => 'Access the dashboard'],
            ['name' => 'create_users', 'title' => 'Create Users', 'description' => 'Create a new user'],
            ['name' => 'create_profiles', 'title' => 'Create Profiles', 'description' => 'Create profiles'],
            ['name' => 'edit_profiles', 'title' => 'Edit Profiles', 'description' => 'Edit profiles'],
            ['name' => 'delete_profiles', 'title' => 'Delete Profiles', 'description' => 'Delete profiles'],
            ['name' => 'view_profiles', 'title' => 'View Profiles', 'description' => 'View profiles'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']], $permission);
        }
    }
}
