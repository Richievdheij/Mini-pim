<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
