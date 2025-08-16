<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Politics', 'color' => '#ef4444', 'slug' => 'politics'], // red-500
            ['name' => 'Business', 'color' => '#f59e0b', 'slug' => 'business'], // amber-500
            ['name' => 'Technology', 'color' => '#3b82f6', 'slug' => 'technology'], // blue-500
            ['name' => 'Health', 'color' => '#10b981', 'slug' => 'health'], // emerald-500
            ['name' => 'Entertainment', 'color' => '#8b5cf6', 'slug' => 'entertainment'], // violet-500
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
