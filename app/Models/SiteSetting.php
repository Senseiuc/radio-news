<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'youtube_url',
        'youtube_live_url',
        'facebook_live_url',
        'linkedin_url',
        'tiktok_url',
        'contact_email',
        // Radio fields
        'radio_stream_url',
        'radio_now_playing',
        'radio_schedule',
        // Chat widgets
        'tawk_property_id',
        'tawk_widget_id',
    ];

    protected $casts = [
        'radio_schedule' => 'array',
    ];
}
