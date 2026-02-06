<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Total Movies: " . App\Models\Movie::count() . " ===" . PHP_EOL;
echo "=== Total Trailers: " . App\Models\Trailer::count() . " ===" . PHP_EOL;
echo PHP_EOL;

echo "=== Movies with Categories ===" . PHP_EOL;
$movies = App\Models\Movie::take(5)->get();
foreach ($movies as $movie) {
    $categories = $movie->categories->pluck('name')->join(', ');
    echo "- {$movie->title}: {$categories}" . PHP_EOL;
}

echo PHP_EOL;
echo "=== Movies with Trailers ===" . PHP_EOL;
$moviesWithTrailers = App\Models\Movie::has('trailers')->get();
foreach ($moviesWithTrailers as $movie) {
    echo "- {$movie->title}: " . $movie->trailers->count() . " trailer(s)" . PHP_EOL;
}
