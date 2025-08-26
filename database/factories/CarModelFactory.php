<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarModelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'brand_id' => 1, // Can be replaced with dynamic brand selection
        ];
    }
} 