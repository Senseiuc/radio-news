<?php

namespace Tests\Unit;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_scope_excludes_future_or_null(): void
    {
        Article::factory()->create(['published_at' => now()->subDay()]);
        Article::factory()->create(['published_at' => null]);
        Article::factory()->create(['published_at' => now()->addDay()]);

        $this->assertSame(1, Article::published()->count());
    }

    public function test_audio_source_prefers_file_path(): void
    {
        Storage::fake('public');
        $a = Article::factory()->create([
            'audio_url' => 'https://example.com/audio.mp3',
            'audio_file_path' => 'media/articles/test.mp3',
        ]);

        $this->assertStringContainsString('/storage/', $a->audio_source);
    }

    public function test_video_source_prefers_file_path(): void
    {
        Storage::fake('public');
        $a = Article::factory()->create([
            'video_url' => 'https://example.com/video.mp4',
            'video_file_path' => 'media/articles/test.mp4',
        ]);

        $this->assertStringContainsString('/storage/', $a->video_source);
    }
}
