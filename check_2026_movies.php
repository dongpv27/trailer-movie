<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== PHIM 2026 ===" . PHP_EOL . PHP_EOL;

$movies = App\Models\Movie::where('release_date', '>=', '2026-01-01')
    ->where('release_date', '<=', '2026-12-31')
    ->orderBy('release_date')
    ->get(['title', 'slug', 'release_date', 'status']);

foreach ($movies as $m) {
    echo "{$m->release_date->format('d/m/Y')} - {$m->title}" . PHP_EOL;
    echo "  Slug: {$m->slug}" . PHP_EOL;
    echo "  Status: {$m->status}" . PHP_EOL;
    echo PHP_EOL;
}

echo "Tổng cộng: {$movies->count()} phim" . PHP_EOL;
