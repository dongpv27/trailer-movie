<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Checking 2026 Movie Poster URLs ===" . PHP_EOL . PHP_EOL;

$slugs = [
    'the-odyssey-2026',
    'toy-story-5-2026',
    'scream-7-2026',
    'mortal-kombat-2-2026',
    'avengers-doomsday-2026',
];

foreach ($slugs as $slug) {
    $movie = App\Models\Movie::where('slug', $slug)->first();
    if ($movie) {
        echo "{$movie->title}" . PHP_EOL;
        echo "  Poster DB: " . ($movie->poster ?? 'NULL') . PHP_EOL;
        echo "  Poster URL: " . substr($movie->poster_url, 0, 100) . "..." . PHP_EOL;
        echo PHP_EOL;
    }
}
