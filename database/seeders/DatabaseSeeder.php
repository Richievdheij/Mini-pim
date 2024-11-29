<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Voer de permissie seeders uit
        $this->call([
            PermissionSeeder::class,
            ProfilePermissionSeeder::class,
        ]);

        // Maak de testgebruiker aan, indien deze nog niet bestaat
        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'], // Zoek op basis van e-mailadres
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'), // Stel een standaard wachtwoord in
            ]
        );

        // Koppel de testgebruiker aan het Admin-profiel
        $adminProfile = Profile::firstOrCreate(['name' => 'Admin']);
        $testUser->profiles()->attach($adminProfile);
    }
}
