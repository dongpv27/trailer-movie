<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Updating Movie Statuses ===" . PHP_EOL . PHP_EOL;

// 1. Set some movies as HOT
$hotMovies = [
    'avatar-fire-and-ash-2025',
    'dung-do-sieu-tran-2025',
    'phi-vu-the-ky-3-2025',
];

foreach ($hotMovies as $slug) {
    $movie = \App\Models\Movie::where('slug', $slug)->first();
    if ($movie) {
        $movie->update(['status' => 'hot']);
        echo "✓ {$movie->title} -> HOT" . PHP_EOL;
    }
}

// 2. Set some movies as RELEASED (with past release date)
$releasedMovies = [
    'bo-phong-truy-anh-2025' => '2025-08-16',
    '96-phut-sinh-tu-2025' => '2025-09-05',
];

foreach ($releasedMovies as $slug => $releaseDate) {
    $movie = \App\Models\Movie::where('slug', $slug)->first();
    if ($movie) {
        $movie->update(['status' => 'released', 'release_date' => $releaseDate]);
        echo "✓ {$movie->title} -> RELEASED ({$releaseDate})" . PHP_EOL;
    }
}

// 3. Keep rest as UPCOMING (already set)

echo PHP_EOL . "=== Summary ===" . PHP_EOL;
echo "HOT: " . \App\Models\Movie::hot()->count() . PHP_EOL;
echo "UPCOMING: " . \App\Models\Movie::upcoming()->count() . PHP_EOL;
echo "RELEASED: " . \App\Models\Movie::released()->count() . PHP_EOL;
echo "Total Published: " . \App\Models\Movie::published()->count() . PHP_EOL;
