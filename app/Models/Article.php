<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        // Core content
        'title',
        'slug',
        'excerpt',
        'body',

        // Publishing
        'published_at',
        'is_featured',
        'is_top',
        'is_trending',

        // Media
        'image_url',
        'video_url',
        'audio_url',
        'audio_file_path',
        'video_file_path',

        // Relationships
        'author_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_top' => 'boolean',
        'is_trending' => 'boolean',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(ArticleRevision::class);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($query) use ($term) {
            $query->where('title', 'like', "%{$term}%")
                ->orWhere('body', 'like', "%{$term}%")
                ->orWhere('excerpt', 'like', "%{$term}%");
        });
    }

    protected static function booted(): void
    {
        static::updated(function ($article) {
            // Avoid creating revision if nothing meaningful changed
            if ($article->wasChanged(['title','body','excerpt'])) {
                $article->revisions()->create([
                    'user_id' => auth()->id(),
                    'content' => [
                        'title' => $article->getOriginal('title'),
                        'body' => $article->getOriginal('body'),
                        'excerpt' => $article->getOriginal('excerpt')
                    ]
                ]);
            }
        });
    }

    public function scopePublished(Builder $query): void
    {
        $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
    public function getAudioSourceAttribute(): ?string
    {
        if (!empty($this->audio_file_path)) {
            return Storage::url($this->audio_file_path);
        }
        return $this->audio_url ?: null;
    }

    public function getVideoSourceAttribute(): ?string
    {
        if (!empty($this->video_file_path)) {
            return Storage::url($this->video_file_path);
        }
        return $this->video_url ?: null;
    }
}
