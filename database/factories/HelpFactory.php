<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Help>
 */
class HelpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => fake()->unique()->numberBetween(1, 999),
            'user_id' => fake()->unique()->numberBetween(1, 999),
            'description_long' => fake()->text(),
        ];
    }
}
