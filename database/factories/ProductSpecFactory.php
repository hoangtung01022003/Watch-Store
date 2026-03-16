<?php

namespace Database\Factories;

use App\Models\ProductSpec;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductSpec>
 */
class ProductSpecFactory extends Factory
{
    protected $model = ProductSpec::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'case_size' => fake()->randomElement(['38mm', '40mm', '42mm', '44mm']),
            'water_resistance' => fake()->randomElement(['30m', '50m', '100m', '200m']),
            'strap_material' => fake()->randomElement(['Leather', 'Stainless Steel', 'Rubber', 'Nylon']),
            'movement' => fake()->randomElement(['Automatic', 'Quartz', 'Mechanical']),
            'glass_type' => fake()->randomElement(['Sapphire Crystal', 'Mineral Glass', 'Acrylic']),
        ];
    }
}
