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
        // Step 1: Seed permissions and profile-permissions
        $this->call([
            PermissionSeeder::class,
            ProfilePermissionSeeder::class,
        ]);

        // Step 2: Create a test user if it doesn't exist
        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'], // Lookup based on email
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'), // Set a default password
            ]
        );

        // Step 3: Link the test user to the Admin profile
        $adminProfile = Profile::firstOrCreate(['name' => 'Admin']);
        $testUser->profiles()->syncWithoutDetaching([$adminProfile->id]);

        // Step 4: Seed the product-related data (product types, attributes, values)
        $this->call([
            ProductTypeSeeder::class,    // Seeds product types like Electronics, Clothing
            AttributeSeeder::class,     // Seeds attributes like Color, Size
            AttributeValueSeeder::class, // Seeds attribute values like Red, Large
        ]);

        // Step 5: Associate existing users with profiles if not already associated
        $this->call(UserProfileSeeder::class);
    }
}
