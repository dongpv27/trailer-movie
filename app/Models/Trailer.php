<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trailer extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'title',
        'slug',
        'youtube_id',
        'thumbnail',
        'is_main',
        'published_at',
        'play_count',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'published_at' => 'datetime',
        'play_count' => 'integer',
    ];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function plays(): HasMany
    {
        return $this->hasMany(TrailerPlay::class);
    }

    public function incrementPlay(): void
    {
        $lock = cache()->lock("trailer:{$this->id}:play", 10);
        if ($lock->get()) {
            try {
                $this->increment('play_count');
            } finally {
                $lock->release();
            }
        }
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }

        return "https://img.youtube.com/vi/{$this->youtube_id}/maxresdefault.jpg";
    }

    public function getEmbedUrlAttribute(): string
    {
        return "https://www.youtube.com/embed/{$this->youtube_id}";
    }

    public function getUrlAttribute(): string
    {
        return route('movie.show', $this->movie->slug) . '#trailer-' . $this->id;
    }
}
