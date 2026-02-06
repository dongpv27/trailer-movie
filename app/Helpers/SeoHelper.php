<?php

namespace App\Helpers;

use App\Models\Movie;
use App\Models\Trailer;
use App\Models\Category;
use App\Models\Post;

class SeoHelper
{
    public static function movieSchema(Movie $movie): string
    {
        $mainTrailer = $movie->mainTrailer?->first() ?: $movie->trailers->first();

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Movie',
            'name' => $movie->title,
            'url' => $movie->url,
            'image' => $movie->poster_url,
            'description' => $movie->description ?: "Xem trailer {$movie->title} tại TrailerPhim",
            'datePublished' => $movie->release_date?->format('Y-m-d'),
            'inLanguage' => 'vi',
            'countryOfOrigin' => [
                '@type' => 'Country',
                'name' => $movie->country ?? 'Vietnam',
            ],
        ];

        if ($movie->duration) {
            $schema['duration'] = 'PT' . $movie->duration . 'M';
        }

        if ($mainTrailer) {
            $schema['trailer'] = self::videoObjectSchema($mainTrailer, $movie);
        }

        if ($movie->genres->isNotEmpty()) {
            $schema['genre'] = $movie->genres->pluck('name')->toArray();
        }

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public static function videoObjectSchema(Trailer $trailer, Movie $movie): array
    {
        return [
            '@type' => 'VideoObject',
            'name' => $trailer->title ?: "Trailer {$movie->title}",
            'description' => "Xem trailer {$movie->title} chính thức",
            'thumbnailUrl' => [
                $trailer->thumbnail_url,
                "https://img.youtube.com/vi/{$trailer->youtube_id}/maxresdefault.jpg",
                "https://img.youtube.com/vi/{$trailer->youtube_id}/hqdefault.jpg",
            ],
            'uploadDate' => $trailer->published_at?->format('Y-m-d') ?: $movie->published_at?->format('Y-m-d'),
            'embedUrl' => $trailer->embed_url,
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'TrailerPhim',
                'url' => config('app.url'),
            ],
        ];
    }

    public static function breadcrumbListSchema(array $breadcrumbs): string
    {
        $items = [];
        $position = 1;

        foreach ($breadcrumbs as $name => $url) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $name,
                'item' => $url,
            ];
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public static function webSiteSchema(): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'TrailerPhim',
            'url' => config('app.url'),
            'description' => 'Trailer phim - Xem trailer phim mới nhất, hot nhất, cập nhật liên tục',
            'inLanguage' => 'vi-VN',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => config('app.url') . '/search?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public static function organizationSchema(): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'TrailerPhim',
            'url' => config('app.url'),
            'logo' => asset('images/logo.png'),
            'description' => 'TrailerPhim - Website xem trailer phim mới nhất, cập nhật liên tục',
            'sameAs' => [
                // Add social media URLs here
            ],
        ];

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public static function postSchema(Post $post): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $post->title,
            'url' => $post->url,
            'image' => $post->thumbnail_url,
            'description' => $post->excerpt ?: strip_tags($post->content),
            'datePublished' => $post->published_at?->format('Y-m-d'),
            'dateModified' => $post->updated_at->format('Y-m-d'),
            'author' => [
                '@type' => 'Organization',
                'name' => 'TrailerPhim',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'TrailerPhim',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png'),
                ],
            ],
        ];

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public static function collectionSchema(string $name, string $url, array $items): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $name,
            'url' => $url,
            'description' => "Danh sách {$name} tại TrailerPhim",
        ];

        if (!empty($items)) {
            $schema['itemListElement'] = array_map(function ($item, $index) {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'item' => [
                        '@type' => 'Movie',
                        'name' => $item['name'],
                        'url' => $item['url'],
                        'image' => $item['image'] ?? null,
                    ],
                ];
            }, $items, array_keys($items));
        }

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
