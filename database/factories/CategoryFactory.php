<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = ucfirst(fake()->unique()->word());
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }
}
