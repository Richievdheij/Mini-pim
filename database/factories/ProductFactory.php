<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition()
    {
        return [
            'product_id' => $this->faker->unique()->uuid(), // Generate a unique UUID
            'name' => $this->faker->word(), // Random word
            'type_id' => ProductType::factory(), // Create a related ProductType
            'weight' => $this->faker->randomFloat(2, 1, 100), // Weight in kg
            'description' => $this->faker->sentence(), // Random sentence
            'price' => $this->faker->randomFloat(2, 10, 5000), // Random price
            'stock_quantity' => $this->faker->numberBetween(1, 500), // Random stock quantity
        ];
    }
}
