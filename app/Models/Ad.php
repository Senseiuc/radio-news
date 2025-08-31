<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory;

    public const PLACEMENTS = [
        'header' => 'Header (below trending bar)',
        'home-inline' => 'Home – Inline (between hero and categories)',
        'index-top' => 'Articles Index – Top (above list)',
        'sidebar' => 'Sidebar (index/show pages)',
        'article-inline' => 'Article – Inline (after main image)',
        'footer' => 'Footer (top of footer)'
    ];

    protected $fillable = [
        'name', 'slot_id', 'type', 'placement', 'is_active', 'custom_code'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'custom_code' => 'array',
    ];

    protected static function booted(): void
    {
        static::saved(function () {
            \Cache::forget('ads_by_placement');
        });
        static::deleted(function () {
            \Cache::forget('ads_by_placement');
        });
    }
}
