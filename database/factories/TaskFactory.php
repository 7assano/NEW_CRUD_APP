<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(2),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'is_completed' => fake()->boolean(30),
            'is_favorite' => fake()->boolean(20),
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'category_id' => Category::inRandomOrder()->first()?->id ?? null,
        ];
    }
}
