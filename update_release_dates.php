<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Update release dates to future dates
$updates = [
    'avatar-fire-and-ash-2025' => '2026-12-17',
    'phi-vu-dong-troi-2-2025' => '2026-11-26',
    '96-phut-sinh-tu-2025' => '2026-09-05',
    'bo-phong-truy-anh-2025' => '2026-08-16',
    'co-hau-gai-2025' => '2026-12-18',
    'dem-giang-sinh-dam-mau-2025' => '2026-12-11',
    'phi-vu-the-ky-3-2025' => '2026-11-12',
    'cuoc-chien-giua-cac-the-gioi-2025' => '2026-07-29',
    'quai-thu-vo-hinh-vung-dat-chet-choc-2025' => '2026-11-05',
    'con-trai-cua-shakespeare-2025' => '2026-11-26',
    'sponge-bi-loi-nguyen-hai-tac-2025' => '2026-12-19',
    'dung-do-sieu-tran-2025' => '2026-12-24',
];

foreach ($updates as $slug => $releaseDate) {
    $movie = App\Models\Movie::where('slug', $slug)->first();
    if ($movie) {
        $movie->update(['release_date' => $releaseDate]);
        echo "Updated: {$movie->title} -> {$releaseDate}" . PHP_EOL;
    }
}

echo PHP_EOL . "Done! Total upcoming: " . App\Models\Movie::upcoming()->count() . PHP_EOL;
