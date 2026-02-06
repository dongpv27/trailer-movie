<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DEBUG UPCOMING MOVIES ===" . PHP_EOL;
echo "Current date: " . now() . PHP_EOL . PHP_EOL;

$upcoming = App\Models\Movie::upcoming()
    ->with(['categories', 'mainTrailer'])
    ->orderBy('release_date')
    ->get(['id', 'title', 'slug', 'release_date', 'status', 'published_at']);

echo "Found: {$upcoming->count()} upcoming movies" . PHP_EOL . PHP_EOL;

foreach ($upcoming as $m) {
    echo "{$m->release_date->format('d/m/Y')} - {$m->title}" . PHP_EOL;
    echo "  Slug: {$m->slug}" . PHP_EOL;
    echo "  Status: {$m->status}" . PHP_EOL;
    echo "  Published: " . ($m->published_at ? $m->published_at->format('d/m/Y H:i') : 'NULL') . PHP_EOL;
    echo "  Trailers: " . $m->mainTrailer->count() . PHP_EOL;
    echo PHP_EOL;
}
