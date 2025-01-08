<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    // Create roles
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'editor']);
    Role::create(['name' => 'user']);
}
}
