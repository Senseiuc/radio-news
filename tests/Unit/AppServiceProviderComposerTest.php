<?php

namespace Tests\Unit;

use App\Models\Ad;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class AppServiceProviderComposerTest extends TestCase
{
    use RefreshDatabase;

    public function test_global_view_composer_shares_settings_and_ads(): void
    {
        Cache::flush();
        $settings = SiteSetting::factory()->create(['contact_email' => 'contact@site.tld']);
        Ad::factory()->create(['placement' => 'header', 'is_active' => true]);

        $html = view('home')->render();

        $this->assertIsString($html);
        $sharedSettings = View::shared('siteSettings');
        $this->assertNotNull($sharedSettings);
        $this->assertSame('contact@site.tld', $sharedSettings->contact_email);

        $ads = View::shared('adsByPlacement');
        $this->assertTrue($ads->has('header'));
    }
}
