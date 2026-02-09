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
        // Sử dụng seeder tổng hợp - chạy tất cả trong 1 file
        $this->call([
            \Database\Seeders\TRAILERPHIM_INSTALL::class,
        ]);

        // Nếu muốn thêm dữ liệu mẫu (movies, posts), chạy các seeder riêng:
        // $this->call([
        //     MovieSeeder::class,
        //     Movies2025Seeder::class,
        //     Movies2026Seeder::class,
        //     PostSeeder::class,
        //     MovieStreamingSeeder::class,
        // ]);

        // Seeder để import phim từ 2020-2025 từ TMDB
        // $this->call([
        //     MoviesFrom2020Seeder::class,
        // ]);
    }
}
