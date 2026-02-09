<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddMovieCastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update some popular movies with cast and director info
        $movies = Movie::whereIn('slug', [
            'thunderbolts',
            'mickey-17',
            'lilo-stitch-live-action',
            'zombie-4-tap-doan-phuc-sinh',
            'paddington-in-peru'
        ])->get();

        foreach ($movies as $movie) {
            switch ($movie->slug) {
                case 'thunderbolts':
                    $movie->update([
                        'director' => 'Jake Schreier',
                        'cast' => 'Sebastian Stan, Hannah John-Kamen, Wyatt Russell, Julia Louis-Dreyfus, Florence Pugh, David Harbour'
                    ]);
                    break;
                case 'mickey-17':
                    $movie->update([
                        'director' => 'Bong Joon-ho',
                        'cast' => 'Robert Pattinson, Naomi Ackie, Steven Yeun, Toni Collette, Mark Ruffalo'
                    ]);
                    break;
                case 'lilo-stitch-live-action':
                    $movie->update([
                        'director' => 'Dean Fleischer Camp',
                        'cast' => 'Maia Kealoha, Sydney Agudong, Zach Galifianakis'
                    ]);
                    break;
                case 'zombie-4-tap-doan-phuc-sinh':
                    $movie->update([
                        'director' => 'Phan Gia Nhat Linh',
                        'cast' => 'Truong Giang, Nha Phuong, Huynh Lap, Ka Tu'
                    ]);
                    break;
                case 'paddington-in-peru':
                    $movie->update([
                        'director' => 'Douglas Wilson',
                        'cast' => 'Ben Whishaw, Olivia Colman, Hugh Bonneville, Emily Mortimer'
                    ]);
                    break;
            }
            $this->command->info("Updated cast and director for: {$movie->title}");
        }
    }
}
