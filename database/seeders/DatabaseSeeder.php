<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            MovieSeeder::class,
            PostSeeder::class,
        ]);

        // Movies 2025 from TMDB
        $this->call([
            Movies2025Seeder::class,
        ]);

        // Movies 2026
        $this->call([
            Movies2026Seeder::class,
        ]);

        // Admin user for Filament
        User::firstOrCreate(
            ['email' => 'admin@trailerphim.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
