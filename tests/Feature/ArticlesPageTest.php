<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticlesPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_articles_index_renders_and_lists_published_articles(): void
    {
        $articles = Article::factory()->count(3)->create();

        $res = $this->get(route('articles.index'));
        $res->assertOk();
        foreach ($articles as $a) {
            $res->assertSeeText($a->title);
        }
    }

    public function test_articles_index_filters_by_category(): void
    {
        $catNews = Category::factory()->create(['slug' => 'news']);
        $catBiz = Category::factory()->create(['slug' => 'business']);

        $a1 = Article::factory()->create();
        $a2 = Article::factory()->create();
        $a1->categories()->attach($catNews->id);
        $a2->categories()->attach($catBiz->id);

        $res = $this->get(route('articles.index', ['category' => 'news']));
        $res->assertOk()
            ->assertSeeText($a1->title)
            ->assertDontSeeText($a2->title);
    }

    public function test_article_show_404s_when_unpublished(): void
    {
        $article = Article::factory()->create(['published_at' => null]);

        $this->get(route('articles.show', $article->slug))->assertNotFound();
    }

    public function test_article_show_renders_media_players_when_present(): void
    {
        $article = Article::factory()->create([
            'audio_url' => 'https://example.com/audio.mp3',
            'video_url' => 'https://youtu.be/dQw4w9WgXcQ',
        ]);

        $res = $this->get(route('articles.show', $article->slug));
        $res->assertOk();
        $res->assertSee('audio', escape:false);
        $res->assertSee('iframe', escape:false);
    }
}
