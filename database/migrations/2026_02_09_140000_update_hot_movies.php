<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Update some popular movies to have status = 'hot'
     * (Using Vietnamese titles since TMDB auto-translates them)
     */
    public function up(): void
    {
        // List of popular movie titles (in Vietnamese) to mark as HOT
        $hotMovies = [
            'Deadpool và Wolverine',
            'Hành Tinh Cát: Phần Hai',
            'Oppenheimer',
            'Barbie',
            'Những Mảnh Ghép Cảm Xúc 2',
            'Phi Công Siêu Đẳng: Maverick',
            'Avatar:  Dòng Chảy Của Nước',
            'Võ Sĩ Giác Đấu II',
            'Dune',
            'Người Nhện: Không Còn Nhà',
            'Avatar: Lửa và Tro Tàn',
            'Bác Siêu Vệ Ba',
        ];

        // Update these movies to have status = 'hot'
        $updated = DB::table('movies')
            ->whereIn('title', $hotMovies)
            ->update(['status' => 'hot']);

        echo "Updated {$updated} movies to HOT status\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert all hot movies to released
        DB::table('movies')
            ->where('status', 'hot')
            ->update(['status' => 'released']);
    }
};
