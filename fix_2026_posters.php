<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Fixing 2026 Movie Posters ===" . PHP_EOL . PHP_EOL;

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
        // Set poster to null to use SVG placeholder
        $movie->update(['poster' => null]);
        echo "✓ Fixed poster for: {$movie->title}" . PHP_EOL;
    } else {
        echo "✗ Movie not found: {$slug}" . PHP_EOL;
    }
}

echo PHP_EOL . "Done! Movies will use SVG placeholder." . PHP_EOL;
