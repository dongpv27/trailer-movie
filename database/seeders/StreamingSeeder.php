<?php

namespace Database\Seeders;

use App\Models\Streaming;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StreamingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cinemas = [
            ['name' => 'CGV', 'url' => 'https://www.cgv.vn'],
            ['name' => 'Lotte Cinema', 'url' => 'https://www.lottecinema.vn'],
            ['name' => 'Galaxy Cinema', 'url' => 'https://galaxycine.vn'],
            ['name' => 'Beta Cinemas', 'url' => 'https://beta.com.vn'],
            ['name' => 'Cinestar', 'url' => 'https://cinestar.com.vn'],
        ];

        $streamingPlatforms = [
            ['name' => 'Netflix', 'icon' => 'play-circle', 'url' => 'https://www.netflix.com'],
            ['name' => 'Disney+', 'icon' => 'film', 'url' => 'https://www.disneyplus.com'],
            ['name' => 'HBO Go', 'icon' => 'video-camera', 'url' => 'https://www.hbogo.com'],
            ['name' => 'Prime Video', 'icon' => 'play', 'url' => 'https://www.primevideo.com'],
            ['name' => 'Apple TV+', 'icon' => 'tv', 'url' => 'https://www.apple.com/apple-tv-plus'],
        ];

        $sortOrder = 1;

        // Create cinemas
        foreach ($cinemas as $cinema) {
            Streaming::updateOrCreate(
                ['slug' => Str::slug($cinema['name'])],
                [
                    'name' => $cinema['name'],
                    'slug' => Str::slug($cinema['name']),
                    'type' => 'cinema',
                    'icon' => 'logo', // Will show SVG logo
                    'url' => $cinema['url'],
                    'is_active' => true,
                    'sort_order' => $sortOrder++,
                ]
            );
        }

        // Create streaming platforms
        foreach ($streamingPlatforms as $platform) {
            Streaming::updateOrCreate(
                ['slug' => Str::slug($platform['name'])],
                [
                    'name' => $platform['name'],
                    'slug' => Str::slug($platform['name']),
                    'type' => 'streaming',
                    'icon' => 'logo', // Will show SVG logo
                    'url' => $platform['url'],
                    'is_active' => true,
                    'sort_order' => $sortOrder++,
                ]
            );
        }
    }
}
