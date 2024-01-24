<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 50),
            'cabinet' => fake()->numberBetween(1, 5).fake()->numberBetween(0, 1).fake()->numberBetween(1, 7),
            'title' => fake()->sentence(5),
            'description' => fake()->text(100),
        ];
    }
}
