<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->boolean(70)
                ? fake()->paragraph()
                : null,
            'is_completed' => fake()->boolean(30),

            // 👇 الحقول الجديدة
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'is_favorite' => fake()->boolean(20), // 20% احتمال أن تكون مفضلة
        ];
    }
}
