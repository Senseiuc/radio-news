<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::first();
        if (! $author) {
            $this->command->error('No users found. Create a user before seeding articles.');
            return;
        }

        $images = [
            '/images/articles/placeholder-1.svg',
            '/images/articles/placeholder-2.svg',
            '/images/articles/placeholder-3.svg',
        ];

        $categories = Category::query()->pluck('id')->all();

        Article::factory()
            ->count(20)
            ->make()
            ->each(function ($article, $i) use ($author, $images, $categories) {
                $article->author_id = $author->id;
                $article->image_url = $images[$i % count($images)];
                $article->save();

                if (! empty($categories)) {
                    // attach 1-3 random categories
                    $count = min(3, max(1, random_int(1, 3)));
                    $ids = collect($categories)->shuffle()->take($count)->values()->all();
                    $article->categories()->sync($ids);
                }
            });

        $this->command->info('Seeded 20 articles with local images. ✅');
    }
}
