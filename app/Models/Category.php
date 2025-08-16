<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'color'];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
