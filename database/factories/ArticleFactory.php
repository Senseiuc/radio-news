<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence();
        return [
            'title' => $title,
            'slug' => fake()->unique()->slug(),
            'excerpt' => fake()->paragraph(),
            'body' => '<p>' . implode('</p><p>', fake()->paragraphs(6)) . '</p>',
            'published_at' => fake()->dateTimeBetween('-90 days', 'now'),
            // Default to local placeholder; a seeder can override from a pool
            'image_url' => '/images/articles/placeholder-1.svg',
            'video_url' => null,
            'is_featured' => fake()->boolean(20),
            'is_top' => fake()->boolean(20),
            'is_trending' => fake()->boolean(15),
            'author_id' => User::factory(),
        ];
    }
}
