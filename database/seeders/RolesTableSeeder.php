<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
{
    public function run()
{
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'editor']);
    Role::create(['name' => 'user']);
}
}
