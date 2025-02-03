<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\ProductType;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Attributes to be added
        $attributes = [
            ['name' => 'Color', 'type' => 'Clothing'],
            ['name' => 'Size', 'type' => 'Clothing'],
            ['name' => 'Weight', 'type' => 'Electronics'],
            ['name' => 'Material', 'type' => 'Furniture'],
            ['name' => 'Brand', 'type' => 'Sports'],
        ];

        // Default profile ID (ensure this ID exists in the profiles table)
        $defaultProfileId = 1;

        // Add attributes
        foreach ($attributes as $attribute) {
            $type = ProductType::where('name', $attribute['type'])->first();
            if ($type) {
                // Create attribute with default profile_id
                Attribute::firstOrCreate(
                    [
                        'name' => $attribute['name'],
                        'type_id' => $type->id,
                    ],
                    [
                        'profile_id' => $defaultProfileId,
                    ]
                );
            }
        }
    }
}
