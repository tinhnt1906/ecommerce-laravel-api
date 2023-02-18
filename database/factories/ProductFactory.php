<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'slug' => Str::of($this->faker->name)->slug('-'),
            'description' => $this->faker->text,
            'image' => $this->faker->imageUrl($width = 640, $height = 480),
            'quantity' => $this->faker->numberBetween(1, 50),
            'price' => $this->faker->numberBetween(1000, 50000),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'category_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
