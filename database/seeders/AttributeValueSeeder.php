<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\AttributeValue;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            ['attribute' => 'Color', 'value' => 'Red'],
            ['attribute' => 'Color', 'value' => 'Blue'],
            ['attribute' => 'Size', 'value' => 'Small'],
            ['attribute' => 'Size', 'value' => 'Large'],
            ['attribute' => 'Weight', 'value' => '1kg'],
            ['attribute' => 'Weight', 'value' => '5kg'],
            ['attribute' => 'Material', 'value' => 'Wood'],
            ['attribute' => 'Material', 'value' => 'Metal'],
            ['attribute' => 'Brand', 'value' => 'Nike'],
            ['attribute' => 'Brand', 'value' => 'Adidas'],
        ];

        foreach ($values as $value) {
            $attribute = Attribute::where('name', $value['attribute'])->first();
            if ($attribute) {
                AttributeValue::firstOrCreate([
                    'attribute_id' => $attribute->id,
                    'value' => $value['value'],
                ]);
            }
        }
    }
}
