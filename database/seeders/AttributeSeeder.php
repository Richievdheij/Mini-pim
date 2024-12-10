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
        $attributes = [
            ['name' => 'Color', 'type' => 'Clothing'],
            ['name' => 'Size', 'type' => 'Clothing'],
            ['name' => 'Weight', 'type' => 'Electronics'],
            ['name' => 'Material', 'type' => 'Furniture'],
            ['name' => 'Brand', 'type' => 'Sports'],
        ];

        foreach ($attributes as $attribute) {
            $type = ProductType::where('name', $attribute['type'])->first();
            if ($type) {
                Attribute::firstOrCreate([
                    'name' => $attribute['name'],
                    'type_id' => $type->id,
                ]);
            }
        }
    }
}
