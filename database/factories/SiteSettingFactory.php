<?php

namespace Database\Factories;

use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteSettingFactory extends Factory
{
    protected $model = SiteSetting::class;

    public function definition(): array
    {
        return [
            'facebook_url' => 'https://facebook.com/example',
            'twitter_url' => 'https://twitter.com/example',
            'instagram_url' => 'https://instagram.com/example',
            'youtube_url' => 'https://youtube.com/@example',
            'youtube_live_url' => null,
            'facebook_live_url' => null,
            'linkedin_url' => 'https://linkedin.com/company/example',
            'tiktok_url' => 'https://tiktok.com/@example',
            'contact_email' => 'info@example.com',
            'radio_stream_url' => null,
            'radio_now_playing' => null,
            'radio_schedule' => null,
            'tawk_property_id' => null,
            'tawk_widget_id' => null,
        ];
    }
}
