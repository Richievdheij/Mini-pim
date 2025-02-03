<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductType;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define product types
        $productTypes = [
            ['name' => 'Electronics'],
            ['name' => 'Clothing'],
            ['name' => 'Furniture'],
            ['name' => 'Sports'],
            ['name' => 'Toys'],
        ];

        // Default profile ID (ensure this ID exists in the profiles table)
        $defaultProfileId = 1;

        // Insert product types with default profile ID
        foreach ($productTypes as $type) {
            ProductType::firstOrCreate(
                ['name' => $type['name']],
                ['profile_id' => $defaultProfileId]
            );
        }
    }
}
