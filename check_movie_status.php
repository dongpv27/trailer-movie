<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Movie Status Check ===" . PHP_EOL;

$movies = App\Models\Movie::take(5)->get();

foreach ($movies as $movie) {
    echo "Title: {$movie->title}" . PHP_EOL;
    echo "  Status: {$movie->status}" . PHP_EOL;
    echo "  Published At: " . ($movie->published_at ? $movie->published_at->format('Y-m-d H:i:s') : 'null') . PHP_EOL;
    echo "  Release Date: " . ($movie->release_date ? $movie->release_date->format('Y-m-d') : 'null') . PHP_EOL;
    echo "  Is Published: " . ($movie->published_at && $movie->published_at->isPast() ? 'Yes' : 'No') . PHP_EOL;
    echo PHP_EOL;
}

echo "=== Total published movies ===" . PHP_EOL;
echo "Published: " . App\Models\Movie::published()->count() . PHP_EOL;
echo "Upcoming: " . App\Models\Movie::upcoming()->count() . PHP_EOL;
echo "Released: " . App\Models\Movie::released()->count() . PHP_EOL;
