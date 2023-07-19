<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Priority>
 */
class PriorityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->unique()->text(100),
            'rang' => fake()->numberBetween(4, 255),
            'warning_timer' => fake()->numberBetween(2, 255),
            'danger_timer' => fake()->numberBetween(256, 512),
        ];
    }
}
