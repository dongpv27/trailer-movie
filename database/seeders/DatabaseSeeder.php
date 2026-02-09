<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * TRAILERPHIM - Database Seeder
     *
     * Sử dụng 1 file duy nhất để seed toàn bộ data:
     * - Categories (genres, countries, years)
     * - Streamings (cinemas, streaming platforms)
     * - Movies from 2020-2025 (via TMDB API)
     * - Sample posts
     *
     * Yêu cầu:
     * - TMDB_API_KEY trong file .env (lấy miễn phí tại: https://www.themoviedb.org/settings/api)
     *
     * Usage:
     *   php artisan db:seed --class=TRAILERPHIM_ALL_DATA
     */
    public function run(): void
    {
        // Seeder tổng hợp - chạy 1 file là đủ
        $this->call([
            TRAILERPHIM_ALL_DATA::class,
        ]);
    }
}
