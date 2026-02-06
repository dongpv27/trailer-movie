# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is **TrailerPhim**, a Vietnamese movie trailer website built with Laravel 12. It displays movie trailers organized by categories (genres, countries, years), manages news/posts, and includes an admin panel for content management.

### Tech Stack
- **Backend**: Laravel 12 (PHP 8.2+)
- **Admin Panel**: Filament 5.x (accessed at `/admin`)
- **Frontend**: Blade templates with TailwindCSS 4.x, Alpine.js for interactivity
- **Build Tool**: Vite 7.x
- **SEO**: Spatie Laravel Sitemap, custom structured data (Schema.org)

## Common Commands

### Development
```bash
# Full development stack (server, queue, logs, vite)
composer dev

# Start only Laravel dev server
php artisan serve

# Start Vite frontend build watcher
npm run dev
```

### Testing
```bash
# Run all tests
composer test
# or
php artisan test

# Run PHPUnit directly
./vendor/bin/phpunit

# Run a single test file
php artisan test --testsuite=Feature
php artisan test --filter=ExampleTest
```

### Code Quality
```bash
# Laravel Pint (code formatting)
./vendor/bin/pint

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Sitemap
```bash
# Generate sitemap.xml
php artisan sitemap:generate

# Generate and ping Google
php artisan sitemap:generate --ping
```

### Initial Setup
```bash
composer setup
```

## Architecture

### Core Models & Relationships

- **Movie**: Main entity representing a film. Has many Trailers, belongs to many Categories.
- **Trailer**: YouTube video embeds linked to a Movie. Each has a `youtube_id` and optional `is_main` flag.
- **Category**: Polymorphic categorization with `type` field (`genre`, `country`, `year`).
- **Post**: Blog/news articles about cinema.

### Key Model Scopes

- `Movie::published()` - movies with `published_at` in the past
- `Movie::hot()` - published movies with `status = 'hot'`
- `Movie::upcoming()` - published movies with `status = 'upcoming'` and future `release_date`
- `Movie::released()` - published movies with `status = 'released'` and past `release_date`
- `Movie::top()` - published movies ordered by `view_count` desc

### View Counting

Movies and Posts use cache-based locking to safely increment view counts:
```php
$movie->incrementView(); // Uses cache lock to prevent race conditions
```

### Routing Structure

All routes are in `routes/web.php`. Key patterns:
- Movies: `/phim/{slug}` → `MovieController@show`
- Categories by type:
  - `/the-loai/{slug}` → `CategoryController@genre` (type: genre)
  - `/quoc-gia/{slug}` → `CategoryController@country` (type: country)
  - `/nam-pham/{slug}` → `CategoryController@year` (type: year)
- Posts: `/tin-dien-anh` (index), `/tin-dien-anh/{slug}` (show)

### SEO & Structured Data

`App\Helpers\SeoHelper` provides Schema.org JSON-LD generation:
- `movieSchema()` - Movie + VideoObject for trailers
- `postSchema()` - NewsArticle schema
- `breadcrumbListSchema()` - Breadcrumb navigation
- `webSiteSchema()` - WebSite + SearchAction
- `collectionSchema()` - CollectionPage for listing pages

### Filament Admin Resources

Admin panel resources are in `app/Filament/Resources/`:
- `MovieResource` - manages movies with nested trailers via Repeater
- `PostResource` - blog/news management
- `CategoryResource` - genre, country, year management

The admin panel uses a custom color scheme (Amber primary) and is located at `/admin`.

### Blade Components

Reusable components in `resources/views/components/`:
- `<x-movie-card :movie="$movie" />` - movie poster card with hover effects
- `<x-hero-slider />` - homepage hero slider
- `<x-youtube-embed />` - YouTube iframe embed

### File Storage

Images (posters, backdrops, thumbnails) are stored in `storage/app/public/` and served via `storage/` symlink. Use `asset('storage/...')` to reference.

### Sitemap Service

`App\Services\SitemapService` generates sitemaps using Spatie package. Includes:
- Static pages with appropriate priorities
- All published movies, categories, and posts
- Optional Google ping notification
