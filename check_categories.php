<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$categories = \App\Models\Category::select('slug', 'name')->get();

foreach ($categories as $cat) {
    echo $cat->slug . ' - ' . $cat->name . PHP_EOL;
}
