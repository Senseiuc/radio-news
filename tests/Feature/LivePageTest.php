<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_live_section_hidden_when_no_urls(): void
    {
        SiteSetting::factory()->create(['youtube_live_url' => null, 'facebook_live_url' => null]);

        $res = $this->get(route('live'));
        $res->assertOk();
        $res->assertDontSee('LIVE</span>', false);
    }

    public function test_live_section_shows_when_youtube_url_present(): void
    {
        SiteSetting::factory()->create(['youtube_live_url' => 'https://youtu.be/dQw4w9WgXcQ']);

        $res = $this->get(route('live'));
        $res->assertOk();
        $res->assertSee('LIVE', false);
        $res->assertSee('YouTube Live');
        $res->assertSee('iframe', false);
    }
}
