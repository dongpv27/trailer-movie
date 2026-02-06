<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'original_title',
        'slug',
        'description',
        'content',
        'notable_points',
        'faq',
        'poster',
        'backdrop',
        'release_date',
        'status',
        'country',
        'duration',
        'view_count',
        'published_at',
    ];

    protected $casts = [
        'release_date' => 'date',
        'published_at' => 'datetime',
        'view_count' => 'integer',
        'faq' => 'array',
    ];

    public function trailers(): HasMany
    {
        return $this->hasMany(Trailer::class);
    }

    public function mainTrailer(): HasMany
    {
        return $this->hasMany(Trailer::class)->where('is_main', true);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->where('type', 'genre');
    }

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->where('type', 'country');
    }

    public function scopeHot($query)
    {
        return $query->where('status', 'hot')->published();
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming')
            ->where('release_date', '>=', now())
            ->published();
    }

    public function scopeReleased($query)
    {
        return $query->where('status', 'released')
            ->where('release_date', '<=', now())
            ->published();
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeTop($query)
    {
        return $query->published()->orderByDesc('view_count');
    }

    public function getYearAttribute(): ?int
    {
        return $this->release_date?->year;
    }

    public function incrementView(): void
    {
        $lock = cache()->lock("movie:{$this->id}:view", 10);

        if ($lock->get()) {
            try {
                $this->increment('view_count');
            } finally {
                $lock->release();
            }
        }
    }

    public function getUrlAttribute(): string
    {
        return route('movie.show', $this->slug);
    }

    public function getPosterUrlAttribute(): string
    {
        if ($this->poster) {
            // Nếu poster là URL đầy đủ (http/https), return trực tiếp
            if (str_starts_with($this->poster, 'http')) {
                return $this->poster;
            }
            // Ngược lại là local storage
            return asset('storage/' . $this->poster);
        }

        // Local SVG placeholder with film icon
        $svg = '<svg width="300" height="450" xmlns="http://www.w3.org/2000/svg">
  <rect fill="#374151" width="300" height="450"/>
  <circle cx="150" cy="200" r="40" fill="#dc2626" opacity="0.2"/>
  <rect x="130" y="180" width="40" height="40" fill="#dc2626" rx="4"/>
  <polygon points="145,190 145,210 160,200" fill="#fff"/>
  <text x="150" y="280" fill="#9ca3af" font-family="sans-serif" font-size="14" text-anchor="middle">TrailerPhim</text>
</svg>';
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    public function getBackdropUrlAttribute(): string
    {
        if ($this->backdrop) {
            return asset('storage/' . $this->backdrop);
        }

        // Local SVG placeholder
        $svg = '<svg width="1920" height="1080" xmlns="http://www.w3.org/2000/svg">
  <rect fill="#374151" width="1920" height="1080"/>
  <circle cx="960" cy="480" r="80" fill="#dc2626" opacity="0.2"/>
  <rect x="920" y="440" width="80" height="80" fill="#dc2626" rx="8"/>
  <polygon points="950,470 950,490 980,480" fill="#fff"/>
  <text x="960" y="600" fill="#9ca3af" font-family="sans-serif" font-size="32" text-anchor="middle">TrailerPhim</text>
</svg>';
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
