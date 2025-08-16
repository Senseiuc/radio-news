<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->unique()->slug(),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->text(2000),
            'published_at' => fake()->optional()->dateTimeThisYear(),
            'image_url' => fake()->optional()->imageUrl(800, 600),
            'video_url' => fake()->optional()->url(),
            'is_featured' => fake()->boolean(20),
            'is_breaking' => fake()->boolean(10),
            'author_id' => User::factory(),
        ];
    }
}
