<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Urgent',
                'Important',
                'Low Priority',
                'Bug',
                'Feature',
                'Enhancement',
                'Documentation',
                'Testing',
                'Design',
                'Review',
                'Meeting',
                'Research',
                'Planning',
                'Development',
                'Deployment'
            ]),
        ];
    }
}
