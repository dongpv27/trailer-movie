<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Streaming;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * TRAILERPHIM ALL-IN-ONE SEEDER
 *
 * File seeder này tổng hợp tất cả dữ liệu mẫu cần thiết cho project TrailerPhim.
 * Chạy seeder này sau khi migrate để tạo dữ liệu ban đầu.
 *
 * Cách sử dụng:
 * php artisan db:seed --class=TRAILERPHIM_INSTALL
 *
 * Hoặc với migrate fresh:
 * php artisan migrate:fresh --seed
 */
class TRAILERPHIM_INSTALL extends Seeder
{
    public function run(): void
    {
        $this->command->info('=== TRAILERPHIM INSTALLATION ===');
        $this->command->newLine();

        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // ==================== CATEGORIES ====================
        $this->command->info('Seeding Categories...');
        $this->seedCategories();

        // ==================== STREAMINGS ====================
        $this->command->info('Seeding Streaming Platforms...');
        $this->seedStreamings();

        // ==================== ADMIN USER ====================
        $this->command->info('Creating Admin User...');
        $this->seedAdminUser();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->newLine();
        $this->command->info('=== TRAILERPHIM INSTALLATION COMPLETE ===');
        $this->command->info('Admin Email: admin@trailerphim.com');
        $this->command->info('Admin Password: password');
        $this->command->newLine();
        $this->command->info('Next steps:');
        $this->command->info('1. Login to /admin to manage content');
        $this->command->info('2. Add movies, trailers, and posts via admin panel');
        $this->command->info('3. Run: php artisan sitemap:generate');
    }

    /**
     * Seed Categories (Genres, Countries, Years)
     */
    private function seedCategories(): void
    {
        // Genres
        $genres = [
            ['name' => 'Hành động', 'slug' => 'hanh-dong', 'type' => 'genre', 'description' => 'Phim hành động với những cảnh chiến đấu mãn nhãn'],
            ['name' => 'Kinh dị', 'slug' => 'kinh-di', 'type' => 'genre', 'description' => 'Phim kinh dị, ma quái'],
            ['name' => 'Hài hước', 'slug' => 'hai-huoc', 'type' => 'genre', 'description' => 'Phim hài hước, giải trí'],
            ['name' => 'Tình cảm', 'slug' => 'tinh-cam', 'type' => 'genre', 'description' => 'Phim tình cảm, lãng mạn'],
            ['name' => 'Viễn tưởng', 'slug' => 'vien-tuong', 'type' => 'genre', 'description' => 'Phim viễn tưởng, khoa học'],
            ['name' => 'Hoạt hình', 'slug' => 'hoat-hinh', 'type' => 'genre', 'description' => 'Phim hoạt hình, anime'],
            ['name' => 'Phiêu lưu', 'slug' => 'phieu-luu', 'type' => 'genre', 'description' => 'Phim phiêu lưu, khám phá'],
            ['name' => 'Tội phạm', 'slug' => 'toi-pham', 'type' => 'genre', 'description' => 'Phim tội phạm, trinh thám'],
            ['name' => 'Gia đình', 'slug' => 'gia-dinh', 'type' => 'genre', 'description' => 'Phim về gia đình'],
            ['name' => 'Bí ẩn', 'slug' => 'bi-an', 'type' => 'genre', 'description' => 'Phim bí ẩn, thám hiểm'],
            ['name' => 'Chiến tranh', 'slug' => 'chien-tranh', 'type' => 'genre', 'description' => 'Phim chiến tranh, lịch sử'],
            ['name' => 'Kịch tính', 'slug' => 'kich-tinh', 'type' => 'genre', 'description' => 'Phim kịch tính, gay cấn'],
            ['name' => 'Tài liệu', 'slug' => 'tai-lieu', 'type' => 'genre', 'description' => 'Phim tài liệu'],
            ['name' => 'Thể thao', 'slug' => 'the-thao', 'type' => 'genre', 'description' => 'Phim về thể thao'],
        ];

        // Countries
        $countries = [
            ['name' => 'Việt Nam', 'slug' => 'viet-nam', 'type' => 'country'],
            ['name' => 'Hàn Quốc', 'slug' => 'han-quoc', 'type' => 'country'],
            ['name' => 'Mỹ', 'slug' => 'my', 'type' => 'country'],
            ['name' => 'Trung Quốc', 'slug' => 'trung-quoc', 'type' => 'country'],
            ['name' => 'Nhật Bản', 'slug' => 'nhat-ban', 'type' => 'country'],
            ['name' => 'Thái Lan', 'slug' => 'thai-lan', 'type' => 'country'],
            ['name' => 'Anh', 'slug' => 'anh', 'type' => 'country'],
            ['name' => 'Pháp', 'slug' => 'phap', 'type' => 'country'],
            ['name' => 'Đức', 'slug' => 'duc', 'type' => 'country'],
            ['name' => 'Úc', 'slug' => 'uc', 'type' => 'country'],
            ['name' => 'Canada', 'slug' => 'canada', 'type' => 'country'],
            ['name' => 'Ấn Độ', 'slug' => 'an-do', 'type' => 'country'],
            ['name' => 'Indonesia', 'slug' => 'indonesia', 'type' => 'country'],
            ['name' => 'Philippines', 'slug' => 'philippines', 'type' => 'country'],
        ];

        // Years (current year ± 2)
        $years = [];
        $currentYear = (int) date('Y');
        for ($i = $currentYear + 2; $i >= $currentYear - 2; $i--) {
            $years[] = [
                'name' => (string) $i,
                'slug' => (string) $i,
                'type' => 'year',
                'description' => "Phim ra mắt năm {$i}",
            ];
        }

        // Insert genres
        foreach ($genres as $genre) {
            Category::firstOrCreate(
                ['slug' => $genre['slug']],
                $genre
            );
        }

        // Insert countries
        foreach ($countries as $country) {
            Category::firstOrCreate(
                ['slug' => $country['slug']],
                $country
            );
        }

        // Insert years
        foreach ($years as $year) {
            Category::firstOrCreate(
                ['slug' => $year['slug']],
                $year
            );
        }

        $this->command->info('  ✓ Created ' . count($genres) . ' genres');
        $this->command->info('  ✓ Created ' . count($countries) . ' countries');
        $this->command->info('  ✓ Created ' . count($years) . ' years');
    }

    /**
     * Seed Streaming Platforms (Cinemas & Streaming Services)
     */
    private function seedStreamings(): void
    {
        // Vietnamese Cinemas
        $cinemas = [
            ['name' => 'CGV', 'url' => 'https://www.cgv.vn'],
            ['name' => 'Lotte Cinema', 'url' => 'https://www.lottecinema.vn'],
            ['name' => 'Galaxy Cinema', 'url' => 'https://galaxycine.vn'],
            ['name' => 'Beta Cinemas', 'url' => 'https://beta.com.vn'],
            ['name' => 'Cinestar', 'url' => 'https://cinestar.com.vn'],
        ];

        // International Streaming Platforms
        $streamingPlatforms = [
            ['name' => 'Netflix', 'url' => 'https://www.netflix.com'],
            ['name' => 'Disney+', 'url' => 'https://www.disneyplus.com'],
            ['name' => 'HBO Go', 'url' => 'https://www.hbogo.com'],
            ['name' => 'Prime Video', 'url' => 'https://www.primevideo.com'],
            ['name' => 'Apple TV+', 'url' => 'https://www.apple.com/apple-tv-plus'],
        ];

        $sortOrder = 1;

        // Create cinemas
        foreach ($cinemas as $cinema) {
            Streaming::updateOrCreate(
                ['slug' => Str::slug($cinema['name'])],
                [
                    'name' => $cinema['name'],
                    'slug' => Str::slug($cinema['name']),
                    'type' => 'cinema',
                    'icon' => 'logo',
                    'url' => $cinema['url'],
                    'is_active' => true,
                    'sort_order' => $sortOrder++,
                ]
            );
        }

        // Create streaming platforms
        foreach ($streamingPlatforms as $platform) {
            Streaming::updateOrCreate(
                ['slug' => Str::slug($platform['name'])],
                [
                    'name' => $platform['name'],
                    'slug' => Str::slug($platform['name']),
                    'type' => 'streaming',
                    'icon' => 'logo',
                    'url' => $platform['url'],
                    'is_active' => true,
                    'sort_order' => $sortOrder++,
                ]
            );
        }

        $this->command->info('  ✓ Created ' . count($cinemas) . ' cinemas');
        $this->command->info('  ✓ Created ' . count($streamingPlatforms) . ' streaming platforms');
    }

    /**
     * Seed Admin User for Filament Admin Panel
     */
    private function seedAdminUser(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@trailerphim.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('  ✓ Admin user created');
    }
}
