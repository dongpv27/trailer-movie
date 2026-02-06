<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
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

        // Years (last 10 years + current year)
        $years = [];
        $currentYear = (int) date('Y');
        for ($i = $currentYear + 1; $i >= $currentYear - 10; $i--) {
            $years[] = [
                'name' => (string) $i,
                'slug' => (string) $i,
                'type' => 'year',
                'description' => "Phim ra mắt năm {$i}",
            ];
        }

        foreach ($genres as $genre) {
            Category::firstOrCreate(
                ['slug' => $genre['slug']],
                $genre
            );
        }

        foreach ($countries as $country) {
            Category::firstOrCreate(
                ['slug' => $country['slug']],
                $country
            );
        }

        foreach ($years as $year) {
            Category::firstOrCreate(
                ['slug' => $year['slug']],
                $year
            );
        }

        $this->command->info('Categories seeded successfully!');
    }
}
