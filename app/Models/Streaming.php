<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Streaming extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'icon',
        'url',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class)
            ->withPivot('status', 'available_date', 'external_url')
            ->withTimestamps();
    }

    /**
     * Generate movie URL for this streaming platform
     */
    public function getMovieUrl(Movie $movie, ?string $externalUrl = null): ?string
    {
        // If external URL is provided, use it
        if ($externalUrl) {
            return $externalUrl;
        }

        // Otherwise, generate URL based on platform format
        $movieTitle = urlencode($movie->title);

        return match($this->slug) {
            'cgv' => "https://www.cgv.vn/en/movies/search?q={$movieTitle}",
            'lotte-cinema' => "https://www.lottecinema.vn/en/Movie/Search?keyword={$movieTitle}",
            'galaxy-cinema' => "https://galaxycine.vn/tu-khoa?keyword={$movieTitle}",
            'beta-cinemas' => "https://betacinemas.vn/tu-khoa?keyword={$movieTitle}",
            'cinestar' => "https://cinestar.com.vn/tu-khoa?keyword={$movieTitle}",
            'netflix' => "https://www.netflix.com/search?q={$movieTitle}",
            'disney-plus' => "https://www.disneyplus.com/search/search?q={$movieTitle}",
            'hbo-go' => $this->url, // HBO Go doesn't have public search
            'prime-video' => "https://www.primevideo.com/search/?phrase={$movieTitle}",
            'apple-tv' => $this->url, // Apple TV+ doesn't have public search
            default => $this->url,
        };
    }
}
