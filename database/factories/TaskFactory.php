<?php

namespace Database\Factories;

use App\Models\User;
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
        $is_completed = fake()->boolean();
        $completed_at = $is_completed ? now() : null;

        return [
            'user_id' => User::all()->random()->id,
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(13),
            'is_completed' => $is_completed,
            'completed_at' => $completed_at,
        ];
    }
}
