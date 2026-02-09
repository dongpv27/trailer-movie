# Streaming & Cinema URLs Documentation

## Overview

When users click on a cinema or streaming platform, they are redirected to the specific movie page on that platform's website.

## How It Works

### 1. Priority Order

The system follows this priority when generating URLs:

1. **External URL (highest priority)**: If `external_url` is set in `movie_streaming` pivot table, use it
2. **Auto-generated search URL**: If no external URL, generate a search URL based on platform format
3. **Platform homepage**: Fallback to platform's homepage

### 2. URL Formats by Platform

#### Vietnamese Cinemas

| Cinema | Base URL | Search Format |
|--------|----------|---------------|
| **CGV** | `https://www.cgv.vn` | `https://www.cgv.vn/en/movies/search?q={movie_title}` |
| **Lotte Cinema** | `https://www.lottecinema.vn` | `https://www.lottecinema.vn/en/Movie/Search?keyword={movie_title}` |
| **Galaxy Cinema** | `https://galaxycine.vn` | `https://galaxycine.vn/tu-khoa?keyword={movie_title}` |
| **Beta Cinemas** | `https://betacinemas.vn` | `https://betacinemas.vn/tu-khoa?keyword={movie_title}` |
| **Cinestar** | `https://cinestar.com.vn` | `https://cinestar.com.vn/tu-khoa?keyword={movie_title}` |

#### Streaming Platforms

| Platform | Base URL | Search Format |
|----------|----------|---------------|
| **Netflix** | `https://www.netflix.com` | `https://www.netflix.com/search?q={movie_title}` |
| **Disney+** | `https://www.disneyplus.com` | `https://www.disneyplus.com/search/search?q={movie_title}` |
| **HBO GO** | `https://www.hbogo.com` | Homepage (no public search) |
| **Prime Video** | `https://www.primevideo.com` | `https://www.primevideo.com/search/?phrase={movie_title}` |
| **Apple TV+** | `https://www.apple.com/apple-tv-plus` | Homepage (no public search) |

## How to Set External URL

### Via Filament Admin

1. Go to `/admin` → **Phim** → Select a movie
2. Go to **Nơi xem** relation manager
3. Edit a streaming platform
4. Fill in **"Link đến phim trên rạp/nền tảng"** field with the direct movie URL
5. Save

### Example External URLs

```
CGV: https://www.cgv.vn/en/movies/thunderbolts-detail/?mno=85654
Lotte: https://www.lottecinema.vn/en/Movie/Detail?movieID=12345
Galaxy: https://galaxycine.vn/phim/thunderbolts
Netflix: https://www.netflix.com/title/81234567
Disney+: https://www.disneyplus.com/movies/thunderbolft
```

## Database Schema

### `movie_streaming` table

| Column | Type | Description |
|--------|------|-------------|
| `movie_id` | bigint | Foreign key to movies |
| `streaming_id` | bigint | Foreign key to streamings |
| `status` | varchar | 'available' or 'coming_soon' |
| `available_date` | timestamp | When the movie becomes available |
| `external_url` | varchar | Direct link to movie on platform (nullable) |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

## Code Reference

### Streaming Model

```php
public function getMovieUrl(Movie $movie, ?string $externalUrl = null): ?string
{
    if ($externalUrl) {
        return $externalUrl;
    }

    $movieTitle = urlencode($movie->title);

    return match($this->slug) {
        'cgv' => "https://www.cgv.vn/en/movies/search?q={$movieTitle}",
        // ... other platforms
    };
}
```

### Blade Component

```blade
@php
    $movieUrl = $streaming->getMovieUrl($movie, $streaming->pivot->external_url);
@endphp

@if($movieUrl && $streaming->pivot->status === 'available')
    <a href="{{ $movieUrl }}" target="_blank">
        <!-- Platform info -->
    </a>
@endif
```

## Best Practices

1. **Always set external_url for accuracy** - Auto-generated search URLs may not find the exact movie
2. **Test the links** - Verify that external URLs work correctly before publishing
3. **Update when needed** - If a movie's page URL changes, update the external_url
4. **Use HTTPS** - Always use secure URLs
5. **Target blank** - All links open in new tab for better UX

## Troubleshooting

### Link doesn't work
- Check if `external_url` is set correctly
- Verify the platform's URL format hasn't changed
- Test the URL manually in browser

### Search returns no results
- The movie title might differ on the platform
- Set `external_url` manually for better accuracy
- Check if movie is available on that platform

### Link redirects to homepage
- Platform might not have public search functionality
- Set `external_url` manually for these platforms (HBO GO, Apple TV+)
