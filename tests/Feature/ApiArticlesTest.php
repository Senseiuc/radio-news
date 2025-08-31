<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiArticlesTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_articles_index_returns_list(): void
    {
        Article::factory()->count(2)->create();

        $res = $this->getJson('/api/articles');
        $res->assertOk()->assertJsonStructure(['data' => [['id','title','slug']]]);
    }

    public function test_api_articles_filter_by_category(): void
    {
        $cat = Category::factory()->create(['slug' => 'news']);
        $a1 = Article::factory()->create();
        $a2 = Article::factory()->create();
        $a1->categories()->attach($cat->id);

        $res = $this->getJson('/api/articles?category=news');
        $res->assertOk();
        $res->assertSee($a1->slug, false);
        $res->assertDontSee($a2->slug, false);
    }
}
