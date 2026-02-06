<?php

namespace App\Console\Commands;

use App\Models\Movie;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FetchMoviePosters extends Command
{
    protected $signature = 'posters:fetch';
    protected $description = 'Fetch and store movie posters locally';

    public function handle(): int
    {
        $this->info('Fetching movie posters...');

        $movies = Movie::whereNotNull('poster')
            ->where('poster', 'like', 'https://%')
            ->get();

        foreach ($movies as $movie) {
            $this->info("Processing: {$movie->title}");

            try {
                // Download image (disable SSL verify for dev)
                $response = Http::withoutVerifying()
                    ->timeout(30)
                    ->get($movie->poster);

                if ($response->successful()) {
                    $imageContent = $response->body();
                    $extension = $this->getImageExtension($response->header('Content-Type'));
                    $filename = "{$movie->slug}.{$extension}";
                    $path = "posters/{$filename}";

                    // Store locally
                    Storage::disk('public')->put($path, $imageContent);

                    // Update movie with local path
                    $movie->update(['poster' => $path]);

                    $this->info("  ✓ Saved to: {$path}");
                } else {
                    $this->warn("  ✗ Failed to download (HTTP {$response->status()})");
                }
            } catch (\Exception $e) {
                $this->error("  ✗ Error: {$e->getMessage()}");
            }
        }

        $this->info('Done!');
        return Command::SUCCESS;
    }

    private function getImageExtension(?string $contentType): string
    {
        return match($contentType) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => 'jpg',
        };
    }
}
