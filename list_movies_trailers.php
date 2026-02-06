<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$movies = App\Models\Movie::has('trailers')->get(['title', 'slug']);

foreach ($movies as $movie) {
    echo "- {$movie->title}: /phim/{$movie->slug}" . PHP_EOL;
}

echo PHP_EOL . "Total: " . $movies->count() . " movies with trailers";
