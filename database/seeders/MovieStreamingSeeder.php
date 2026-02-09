<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Streaming;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieStreamingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first few movies
        $movies = Movie::published()->take(5)->get();

        if ($movies->isEmpty()) {
            $this->command->warn('No published movies found. Skipping movie streaming seeder.');
            return;
        }

        // Get streaming platforms
        $cinemas = Streaming::where('type', 'cinema')->get();
        $streamings = Streaming::where('type', 'streaming')->get();

        foreach ($movies as $index => $movie) {
            // Attach cinemas (all cinemas available)
            foreach ($cinemas as $cinema) {
                $movie->streamings()->attach($cinema->id, [
                    'status' => $index === 0 ? 'coming_soon' : 'available', // First movie coming soon
                    'available_date' => $index === 0 ? now()->addWeek() : now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Attach streaming platforms (mix of available and coming_soon)
            $streamingsToAttach = $streamings->take($index + 2);
            foreach ($streamingsToAttach as $streaming) {
                $movie->streamings()->attach($streaming->id, [
                    'status' => $index % 2 === 0 ? 'available' : 'coming_soon',
                    'available_date' => $index % 2 === 0 ? now() : now()->addDays(7),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $this->command->info("Attached streaming platforms to movie: {$movie->title}");
        }
    }
}
