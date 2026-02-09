<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
        'director',
        'cast',
    ];

    protected $casts = [
        'release_date' => 'date',
        'published_at' => 'datetime',
        'view_count' => 'integer',
        'faq' => 'array',
    ];

    /**
     * Accessors to append to model array form.
     */
    protected $appends = ['url', 'year', 'poster_url', 'backdrop_url'];

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

    public function streamings(): BelongsToMany
    {
        return $this->belongsToMany(Streaming::class)
            ->withPivot('status', 'available_date', 'external_url')
            ->withTimestamps();
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

    /**
     * Full-text search with relevance scoring
     * Returns results ordered by relevance (title match > director match > cast match > description match)
     */
    public function scopeFullSearch(Builder $query, string $searchTerm): Builder
    {
        $normalizedTerm = $this->normalizeSearchTerm($searchTerm);

        if (empty($normalizedTerm) || strlen($normalizedTerm) < 2) {
            return $query->whereRaw('1 = 0'); // Return no results for short queries
        }

        // Also search by year if query is numeric (4 digits)
        $yearFilter = '';
        if (is_numeric($searchTerm) && strlen($searchTerm) === 4) {
            $yearFilter = "OR EXTRACT(YEAR FROM release_date) = '{$searchTerm}'";
        }

        // Order by relevance score, then by view count, then by release date
        $query->selectRaw(
            "movies.*,
            ts_rank(search_text, to_tsquery('simple', ?)) as relevance_score",
            [$normalizedTerm]
        );

        // Search conditions: full-text search OR genre match OR year match
        $query->where(function ($q) use ($normalizedTerm, $yearFilter, $searchTerm) {
            // Full-text search with relevance scoring
            $q->whereRaw(
                "search_text @@ to_tsquery('simple', ?) {$yearFilter}",
                [$normalizedTerm]
            );

            // Also search by genre name
            $q->orWhereHas('genres', function ($genreQuery) use ($searchTerm) {
                $genreQuery->where('name', 'like', "%{$searchTerm}%");
            });
        });

        $query->orderByDesc('relevance_score')
            ->orderByDesc('view_count')
            ->orderByDesc('release_date');

        return $query;
    }

    /**
     * Normalize search term for Vietnamese full-text search
     * Converts the search term to a format suitable for tsquery
     */
    protected function normalizeSearchTerm(string $term): string
    {
        // Trim whitespace
        $term = trim($term);

        if (empty($term)) {
            return '';
        }

        // Replace multiple spaces with single space
        $term = preg_replace('/\s+/', ' ', $term);

        // Convert to tsquery format: words separated by & (AND)
        // Using simple search (no stemming) for better Vietnamese support
        $words = explode(' ', $term);
        $words = array_filter($words, fn($word) => strlen($word) >= 2);

        if (empty($words)) {
            return '';
        }

        return implode(' & ', $words);
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
            // Nếu backdrop là URL đầy đủ (http/https), return trực tiếp
            if (str_starts_with($this->backdrop, 'http')) {
                return $this->backdrop;
            }
            // Ngược lại là local storage
            return asset('storage/' . $this->backdrop);
        }

        // Fallback: use poster if available
        if ($this->poster) {
            if (str_starts_with($this->poster, 'http')) {
                return $this->poster;
            }
            return asset('storage/' . $this->poster);
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
