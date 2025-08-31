<?php

namespace Tests\Unit;

use App\Http\Resources\ArticleResource as ArticleJsonResource;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_article_resource_returns_computed_media_urls(): void
    {
        Storage::fake('public');
        $article = Article::factory()->create([
            'image_url' => '/images/foo.jpg',
            'audio_file_path' => 'media/articles/a.mp3',
            'video_file_path' => 'media/articles/v.mp4',
        ]);

        $array = (new ArticleJsonResource($article->fresh()))->toArray(request());

        $this->assertStringContainsString('/storage/', $array['video_url']);
        $this->assertStringContainsString('/storage/', $array['audio_url']);
        $this->assertTrue(str_starts_with($array['image_url'], url('/')));
        $this->assertArrayHasKey('published_at', $array);
    }
}
