<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // PIM Category
            ['name' => 'view_pim', 'title' => 'View PIM', 'description' => 'View PIM module', 'category' => 'PIM'],
            ['name' => 'edit_pim', 'title' => 'Edit PIM', 'description' => 'Edit PIM module', 'category' => 'PIM'],
            ['name' => 'delete_pim', 'title' => 'Delete PIM', 'description' => 'Delete PIM module', 'category' => 'PIM'],

            // Products Permissions
            ['name' => 'view_products', 'title' => 'View Products', 'description' => 'View products', 'category' => 'PIM'],
            ['name' => 'create_products', 'title' => 'Create Products', 'description' => 'Create products', 'category' => 'PIM'],
            ['name' => 'edit_products', 'title' => 'Edit Products', 'description' => 'Edit products', 'category' => 'PIM'],
            ['name' => 'delete_products', 'title' => 'Delete Products', 'description' => 'Delete products', 'category' => 'PIM'],

            // Attributes Permissions
            ['name' => 'view_attributes', 'title' => 'View Attributes', 'description' => 'View product attributes', 'category' => 'PIM'],
            ['name' => 'create_attributes', 'title' => 'Create Attributes', 'description' => 'Create product attributes', 'category' => 'PIM'],
            ['name' => 'edit_attributes', 'title' => 'Edit Attributes', 'description' => 'Edit product attributes', 'category' => 'PIM'],
            ['name' => 'delete_attributes', 'title' => 'Delete Attributes', 'description' => 'Delete product attributes', 'category' => 'PIM'],

            // Types Permissions
            ['name' => 'view_types', 'title' => 'View Types', 'description' => 'View product types', 'category' => 'PIM'],
            ['name' => 'create_types', 'title' => 'Create Types', 'description' => 'Create product types', 'category' => 'PIM'],
            ['name' => 'edit_types', 'title' => 'Edit Types', 'description' => 'Edit product types', 'category' => 'PIM'],
            ['name' => 'delete_types', 'title' => 'Delete Types', 'description' => 'Delete product types', 'category' => 'PIM'],

            // User Permissions
            ['name' => 'view_users', 'title' => 'View Users', 'description' => 'View users list', 'category' => 'Users'],
            ['name' => 'edit_users', 'title' => 'Edit Users', 'description' => 'Edit users', 'category' => 'Users'],
            ['name' => 'delete_users', 'title' => 'Delete Users', 'description' => 'Delete users', 'category' => 'Users'],
            ['name' => 'create_users', 'title' => 'Create Users', 'description' => 'Create a new user', 'category' => 'Users'],

            // Permission Management
            ['name' => 'manage_permissions', 'title' => 'Manage Permissions', 'description' => 'Manage permissions', 'category' => 'Rights/Security'],
            ['name' => 'view_permissions', 'title' => 'View Permissions', 'description' => 'View permissions', 'category' => 'Rights/Security'],

            // Reports
            ['name' => 'view_reports', 'title' => 'View Reports', 'description' => 'View reports', 'category' => 'Reports'],
            ['name' => 'generate_reports', 'title' => 'Generate Reports', 'description' => 'Generate reports', 'category' => 'Reports'],

            // Data
            ['name' => 'export_data', 'title' => 'Export Data', 'description' => 'Export data', 'category' => 'Data'],

            // Dashboard
            ['name' => 'view_dashboard', 'title' => 'View Dashboard', 'description' => 'Access the dashboard', 'category' => 'Dashboard'],

            // Profile Management
            ['name' => 'create_profiles', 'title' => 'Create Profiles', 'description' => 'Create profiles', 'category' => 'Profiles'],
            ['name' => 'edit_profiles', 'title' => 'Edit Profiles', 'description' => 'Edit profiles', 'category' => 'Profiles'],
            ['name' => 'delete_profiles', 'title' => 'Delete Profiles', 'description' => 'Delete profiles', 'category' => 'Profiles'],
            ['name' => 'view_profiles', 'title' => 'View Profiles', 'description' => 'View profiles', 'category' => 'Profiles'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']], $permission);
        }
    }
}
