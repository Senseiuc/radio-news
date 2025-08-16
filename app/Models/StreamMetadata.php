<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamMetadata extends Model
{
    protected $fillable = [
        'current_song',
        'listeners',
        'is_online',
        'peak_listeners',
        'bitrate',
        'last_online_at'
    ];

    protected $casts = [
        'is_online' => 'boolean',
        'last_online_at' => 'datetime'
    ];
}
