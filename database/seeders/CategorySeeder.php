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
            ['name' => 'Breaking',      'slug' => 'breaking',      'color' => '#ef4444'], // red-500
            ['name' => 'Politics',      'slug' => 'politics',      'color' => '#dc2626'], // red-600
            ['name' => 'Business',      'slug' => 'business',      'color' => '#f59e0b'], // amber-500
            ['name' => 'Health',        'slug' => 'health',        'color' => '#10b981'], // emerald-500
            ['name' => 'World',         'slug' => 'world',         'color' => '#0ea5e9'], // sky-500
            ['name' => 'Tech',          'slug' => 'tech',          'color' => '#3b82f6'], // blue-500
            ['name' => 'Sports',        'slug' => 'sports',        'color' => '#22c55e'], // green-500
            ['name' => 'Travel',        'slug' => 'travel',        'color' => '#06b6d4'], // cyan-500
            ['name' => 'Events',        'slug' => 'events',        'color' => '#a855f7'], // purple-500
            ['name' => 'News',          'slug' => 'news',          'color' => '#64748b'], // slate-500
            ['name' => 'Environment',   'slug' => 'environment',   'color' => '#16a34a'], // green-600
            ['name' => 'Entertainment', 'slug' => 'entertainment', 'color' => '#8b5cf6'], // violet-500
            ['name' => 'Africa',        'slug' => 'africa',        'color' => '#ea580c'], // orange-600
        ];

        foreach ($categories as $i => $data) {
            // Avoid duplicate slug errors on repeated seeding
            Category::updateOrCreate(
                ['slug' => $data['slug']],
                ['name' => $data['name'], 'color' => $data['color'], 'sort_order' => $i]
            );
        }
    }
}
