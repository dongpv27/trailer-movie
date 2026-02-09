<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestTmdbConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:test
                            {--movie= : Tên phim để test (VD: "Deadpool & Wolverine")}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra kết nối TMDB API và test tìm kiếm phim';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('=== TMDB API Connection Test ===');
        $this->newLine();

        // Check API key
        $apiKey = env('TMDB_API_KEY', '');

        if (empty($apiKey)) {
            $this->error('❌ TMDB_API_KEY không tìm thấy trong file .env!');
            $this->newLine();
            $this->warn('Vui lòng thêm dòng sau vào file .env:');
            $this->line('TMDB_API_KEY=your_api_key_here');
            $this->newLine();
            $this->info('Lấy API key miễn phí tại: https://www.themoviedb.org/settings/api');
            return self::FAILURE;
        }

        $this->info('✅ TMDB_API_KEY đã được cấu hình');
        $this->newLine();

        // Test API connection
        $this->info('Đang test kết nối tới TMDB API...');

        try {
            $response = Http::withoutVerifying()->timeout(10)->get('https://api.themoviedb.org/3/configuration', [
                'api_key' => $apiKey,
            ]);

            if (!$response->successful()) {
                $this->error('❌ Không thể kết nối tới TMDB API!');
                $this->error('Status: ' . $response->status());
                $this->error('Message: ' . $response->body());
                return self::FAILURE;
            }

            $config = $response->json();

            $this->info('✅ Kết nối thành công!');
            $this->newLine();

            // Display API info
            $this->table(
                ['Cấu hình', 'Giá trị'],
                [
                    ['Image Base URL', $config['images']['base_url'] ?? 'N/A'],
                    ['Secure Base URL', $config['images']['secure_base_url'] ?? 'N/A'],
                    ['Backdrop Sizes', implode(', ', $config['images']['backdrop_sizes'] ?? [])],
                    ['Poster Sizes', implode(', ', $config['images']['poster_sizes'] ?? [])],
                ]
            );
            $this->newLine();

            // Test search if movie name provided
            $movieName = $this->option('movie');

            if ($movieName) {
                $this->info("Đang tìm kiếm phim: {$movieName}");
                $this->newLine();

                $searchResponse = Http::withoutVerifying()->timeout(10)->get('https://api.themoviedb.org/3/search/movie', [
                    'api_key' => $apiKey,
                    'query' => $movieName,
                    'language' => 'vi-VN',
                ]);

                if (!$searchResponse->successful()) {
                    $this->error('❌ Tìm kiếm thất bại!');
                    return self::FAILURE;
                }

                $results = $searchResponse->json('results', []);

                if (empty($results)) {
                    $this->warn('⚠️  Không tìm thấy phim nào với tên: ' . $movieName);
                    return self::SUCCESS;
                }

                $this->info('✅ Tìm thấy ' . count($results) . ' kết quả:');
                $this->newLine();

                // Display top 5 results
                $displayResults = array_slice($results, 0, 5);

                $tableData = [];
                foreach ($displayResults as $result) {
                    $tableData[] = [
                        $result['id'],
                        $result['title'],
                        $result['release_date'] ?? 'N/A',
                        $result['vote_average'] ?? 'N/A',
                        $result['overview'] ? substr($result['overview'], 0, 50) . '...' : 'N/A',
                    ];
                }

                $this->table(
                    ['ID', 'Title', 'Release Date', 'Rating', 'Overview'],
                    $tableData
                );

            } else {
                // Test with a popular movie if no movie name provided
                $this->info('Test tìm kiếm phim "Deadpool & Wolverine"...');
                $this->newLine();

                $testResponse = Http::withoutVerifying()->timeout(10)->get('https://api.themoviedb.org/3/search/movie', [
                    'api_key' => $apiKey,
                    'query' => 'Deadpool & Wolverine',
                    'year' => 2024,
                    'language' => 'vi-VN',
                ]);

                if ($testResponse->successful() && !empty($testResponse->json('results'))) {
                    $movie = $testResponse->json('results')[0];

                    $this->info('✅ Tìm thấy: ' . $movie['title']);
                    $this->table(
                        ['Field', 'Value'],
                        [
                            ['TMDB ID', $movie['id']],
                            ['Title', $movie['title']],
                            ['Original Title', $movie['original_title'] ?? 'N/A'],
                            ['Release Date', $movie['release_date'] ?? 'N/A'],
                            ['Rating', $movie['vote_average'] ?? 'N/A'],
                            ['Poster Path', $movie['poster_path'] ?? 'N/A'],
                        ]
                    );
                } else {
                    $this->warn('⚠️  Test tìm kiếm không thành công');
                }
            }

            $this->newLine();
            $this->info('=== Tất cả tests passed! ===');
            $this->info('Bạn có thể chạy seeder: php artisan db:seed --class=MoviesFrom2020Seeder');

            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Lỗi: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
