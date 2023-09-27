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
            'category_id' => fake()->numberBetween(1, 99),
            'status_id' => fake()->numberBetween(1, 4),
            'priority_id' => fake()->numberBetween(1, 6),
            'user_id' => fake()->numberBetween(1, 999),
            'executor_id' => fake()->numberBetween(1, 999),
            'info' => fake()->text(),
            'info_final' => fake()->text(),
            'calendar_request' => fake()->date(),
            'calendar_accept' => fake()->date(),
            'calendar_warning' => fake()->date(),
            'calendar_execution' => fake()->date(),
            'calendar_final' => fake()->date(),
            'description_long' => fake()->text(),
            'lead_at' => fake()->numberBetween(1, 999),
        ];
    }
}
