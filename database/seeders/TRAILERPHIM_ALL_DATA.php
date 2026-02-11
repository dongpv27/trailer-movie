<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Movie;
use App\Models\MovieStatus;
use App\Models\Post;
use App\Models\Streaming;
use App\Models\Trailer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * TRAILERPHIM - ALL DATA IN ONE FILE
 *
 * File này tổng hợp tất cả data cần thiết cho TrailerPhim:
 * - Categories (genres, countries, years)
 * - Streamings (cinemas, streaming platforms)
 * - Movies from 2015-2025 (from TMDB API)
 *
 * Usage: php artisan db:seed --class=TRAILERPHIM_ALL_DATA
 *
 * Requirements:
 * - TMDB_API_KEY in .env file (get free at: https://www.themoviedb.org/settings/api)
 */
class TRAILERPHIM_ALL_DATA extends Seeder
{
    /**
     * TMDB API Configuration
     */
    private string $tmdbApiKey;
    private string $tmdbBaseUrl = 'https://api.themoviedb.org/3';
    private string $tmdbImageBaseUrl = 'https://image.tmdb.org/t/p';

    public function __construct()
    {
        $this->tmdbApiKey = env('TMDB_API_KEY', '');
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->newLine();
        $this->command->info('========================================');
        $this->command->info('  TRAILERPHIM - SEEDING ALL DATA');
        $this->command->info('========================================');
        $this->command->newLine();

        // Step 1: Seed Categories
        $this->seedCategories();

        // Step 2: Seed Streamings
        $this->seedStreamings();

        // Step 3: Seed Sample Posts
        $this->seedPosts();

        // Step 4: Seed Movies from TMDB (if API key available)
        if (!empty($this->tmdbApiKey)) {
            $this->seedMoviesFromTMDB();
        } else {
            $this->command->warn('TMDB_API_KEY not found - skipping movie seeding');
            $this->command->info('To seed movies, add TMDB_API_KEY to .env file');
            $this->command->info('Get your free API key at: https://www.themoviedb.org/settings/api');
        }

        $this->command->newLine();
        $this->command->info('========================================');
        $this->command->info('  SEEDING COMPLETE!');
        $this->command->info('========================================');
    }

    /**
     * Seed Categories (Genres, Countries, Years)
     */
    private function seedCategories(): void
    {
        $this->command->info('📂 Seeding Categories...');

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

        // Years (2015 to current year + 2)
        $years = [];
        $currentYear = (int) date('Y');
        for ($i = $currentYear + 2; $i >= 2015; $i--) {
            $years[] = [
                'name' => (string) $i,
                'slug' => (string) $i,
                'type' => 'year',
                'description' => "Phim ra mắt năm {$i}",
            ];
        }

        $totalCategories = count($genres) + count($countries) + count($years);
        $createdCount = 0;

        foreach ($genres as $genre) {
            $category = Category::firstOrCreate(
                ['slug' => $genre['slug']],
                $genre
            );
            if ($category->wasRecentlyCreated) $createdCount++;
        }

        foreach ($countries as $country) {
            $category = Category::firstOrCreate(
                ['slug' => $country['slug']],
                $country
            );
            if ($category->wasRecentlyCreated) $createdCount++;
        }

        foreach ($years as $year) {
            $category = Category::firstOrCreate(
                ['slug' => $year['slug']],
                $year
            );
            if ($category->wasRecentlyCreated) $createdCount++;
        }

        $this->command->info("   Created {$createdCount}/{$totalCategories} categories");
    }

    /**
     * Seed Streamings (Cinemas & Streaming Platforms)
     */
    private function seedStreamings(): void
    {
        $this->command->info('🎬 Seeding Streamings...');

        $cinemas = [
            ['name' => 'CGV', 'url' => 'https://www.cgv.vn'],
            ['name' => 'Lotte Cinema', 'url' => 'https://www.lottecinema.vn'],
            ['name' => 'Galaxy Cinema', 'url' => 'https://galaxycine.vn'],
            ['name' => 'Beta Cinemas', 'url' => 'https://beta.com.vn'],
            ['name' => 'Cinestar', 'url' => 'https://cinestar.com.vn'],
        ];

        $streamingPlatforms = [
            ['name' => 'Netflix', 'icon' => 'play-circle', 'url' => 'https://www.netflix.com'],
            ['name' => 'Disney+', 'icon' => 'film', 'url' => 'https://www.disneyplus.com'],
            ['name' => 'HBO Go', 'icon' => 'video-camera', 'url' => 'https://www.hbogo.com'],
            ['name' => 'Prime Video', 'icon' => 'play', 'url' => 'https://www.primevideo.com'],
            ['name' => 'Apple TV+', 'icon' => 'tv', 'url' => 'https://www.apple.com/apple-tv-plus'],
        ];

        $sortOrder = 1;
        $createdCount = 0;

        // Create cinemas
        foreach ($cinemas as $cinema) {
            $streaming = Streaming::updateOrCreate(
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
            if ($streaming->wasRecentlyCreated) $createdCount++;
        }

        // Create streaming platforms
        foreach ($streamingPlatforms as $platform) {
            $streaming = Streaming::updateOrCreate(
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
            if ($streaming->wasRecentlyCreated) $createdCount++;
        }

        $this->command->info("   Created {$createdCount}/" . (count($cinemas) + count($streamingPlatforms)) . " streamings");
    }

    /**
     * Seed Sample Posts
     */
    private function seedPosts(): void
    {
        $this->command->info('📰 Seeding Sample Posts...');

        $posts = [
            [
                'title' => 'Top 10 phim hành động hay nhất 2024',
                'slug' => 'top-10-phim-hanh-dong-hay-nhat-2024',
                'excerpt' => 'Tổng hợp những bộ phim hành động xuất sắc nhất năm 2024 không thể bỏ lỡ.',
                'content' => 'Năm 2024 là một năm bùng nổ của dòng phim hành động với những siêu phẩm như "Deadpool & Wolverine", "Gladiator 2"...',
                'status' => 'published',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Review: Dune Part Two - Kiệt tác sci-fi của thập niên',
                'slug' => 'review-dune-part-two-kiet-tac-sci-fi',
                'excerpt' => 'Đánh giá chi tiết về Dune: Part Two - bộ phim khoa học viễn tưởng được mong chờ nhất năm.',
                'content' => 'Dune: Part Two của Denis Villeneuve đã vượt qua mọi kỳ vọng... Tác phẩm tiếp tục hành trình của Paul Atreides...',
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Trailer phim sắp chiếu tháng 3/2025',
                'slug' => 'trailer-phim-sap-chieu-thang-3-2025',
                'excerpt' => 'Tổng hợp những trailer phim hay nhất sẽ ra mắt trong tháng 3/2025.',
                'content' => 'Tháng 3/2025 hứa hẹn mang đến những bom tấn đáng mong chờ như Captain America: Brave New World...',
                'status' => 'published',
                'published_at' => now()->subDays(2),
            ],
        ];

        $createdCount = 0;
        foreach ($posts as $post) {
            $postObj = Post::firstOrCreate(
                ['slug' => $post['slug']],
                array_merge($post, ['view_count' => 0])
            );
            if ($postObj->wasRecentlyCreated) $createdCount++;
        }

        $this->command->info("   Created {$createdCount}/" . count($posts) . " posts");
    }

    /**
     * Seed Movies from TMDB API
     */
    private function seedMoviesFromTMDB(): void
    {
        $this->command->newLine();
        $this->command->info('🎥 Seeding Movies from TMDB...');
        $this->command->newLine();

        // List of popular movies from 2015-2025
        $moviesToSeed = [
            // 2025
            ['title' => 'Captain America: Brave New World', 'year' => 2025],
            ['title' => 'Mission: Impossible 8', 'year' => 2025],
            ['title' => 'Avatar 3', 'year' => 2025],
            ['title' => 'Thunderbolts', 'year' => 2025],
            ['title' => 'The SpongeBob Movie: Search for SquarePants', 'year' => 2025],

            // 2024
            ['title' => 'Deadpool & Wolverine', 'year' => 2024],
            ['title' => 'Dune: Part Two', 'year' => 2024],
            ['title' => 'Inside Out 2', 'year' => 2024],
            ['title' => 'Gladiator 2', 'year' => 2024],
            ['title' => 'Wicked', 'year' => 2024],
            ['title' => 'Joker: Folie à Deux', 'year' => 2024],
            ['title' => 'Kingdom of the Planet of the Apes', 'year' => 2024],
            ['title' => 'Godzilla x Kong: The New Empire', 'year' => 2024],

            // 2023
            ['title' => 'Oppenheimer', 'year' => 2023],
            ['title' => 'Barbie', 'year' => 2023],
            ['title' => 'Spider-Man: Across the Spider-Verse', 'year' => 2023],
            ['title' => 'Guardians of the Galaxy Vol. 3', 'year' => 2023],
            ['title' => 'John Wick: Chapter 4', 'year' => 2023],
            ['title' => 'Killers of the Flower Moon', 'year' => 2023],
            ['title' => 'The Marvels', 'year' => 2023],

            // 2022
            ['title' => 'Top Gun: Maverick', 'year' => 2022],
            ['title' => 'Avatar: The Way of Water', 'year' => 2022],
            ['title' => 'Black Panther: Wakanda Forever', 'year' => 2022],
            ['title' => 'Thor: Love and Thunder', 'year' => 2022],
            ['title' => 'The Batman', 'year' => 2022],

            // 2021
            ['title' => 'Spider-Man: No Way Home', 'year' => 2021],
            ['title' => 'Dune', 'year' => 2021],
            ['title' => 'Shang-Chi and the Legend of the Ten Rings', 'year' => 2021],
            ['title' => 'Eternals', 'year' => 2021],
            ['title' => 'Fast & Furious 9', 'year' => 2021],
            ['title' => 'No Time to Die', 'year' => 2021],

            // 2020
            ['title' => 'Tenet', 'year' => 2020],
            ['title' => 'Wonder Woman 1984', 'year' => 2020],
            ['title' => 'Soul', 'year' => 2020],
            ['title' => 'Enola Holmes', 'year' => 2020],
            ['title' => 'The Trial of the Chicago 7', 'year' => 2020],

            // 2019
            ['title' => 'Avengers: Endgame', 'year' => 2019],
            ['title' => 'Joker', 'year' => 2019],
            ['title' => 'Star Wars: The Rise of Skywalker', 'year' => 2019],
            ['title' => 'Once Upon a Time in Hollywood', 'year' => 2019],
            ['title' => 'The Lion King', 'year' => 2019],
            ['title' => 'Frozen II', 'year' => 2019],
            ['title' => 'Spider-Man: Far From Home', 'year' => 2019],
            ['title' => 'Captain Marvel', 'year' => 2019],
            ['title' => 'Toy Story 4', 'year' => 2019],
            ['title' => 'It Chapter Two', 'year' => 2019],

            // 2018
            ['title' => 'Avengers: Infinity War', 'year' => 2018],
            ['title' => 'Black Panther', 'year' => 2018],
            ['title' => 'Incredibles 2', 'year' => 2018],
            ['title' => 'Jurassic World: Fallen Kingdom', 'year' => 2018],
            ['title' => 'Mission: Impossible - Fallout', 'year' => 2018],
            ['title' => 'Bohemian Rhapsody', 'year' => 2018],
            ['title' => 'Aquaman', 'year' => 2018],
            ['title' => 'Venom', 'year' => 2018],
            ['title' => 'Ralph Breaks the Internet', 'year' => 2018],

            // 2017
            ['title' => 'Star Wars: The Last Jedi', 'year' => 2017],
            ['title' => 'Beauty and the Beast', 'year' => 2017],
            ['title' => 'Wonder Woman', 'year' => 2017],
            ['title' => 'Justice League', 'year' => 2017],
            ['title' => 'Thor: Ragnarok', 'year' => 2017],
            ['title' => 'Spider-Man: Homecoming', 'year' => 2017],
            ['title' => 'Guardians of the Galaxy Vol. 2', 'year' => 2017],
            ['title' => 'Pirates of the Caribbean: Dead Men Tell No Tales', 'year' => 2017],

            // 2016
            ['title' => 'Captain America: Civil War', 'year' => 2016],
            ['title' => 'Rogue One: A Star Wars Story', 'year' => 2016],
            ['title' => 'Finding Dory', 'year' => 2016],
            ['title' => 'The Jungle Book', 'year' => 2016],
            ['title' => 'Suicide Squad', 'year' => 2016],
            ['title' => 'Doctor Strange', 'year' => 2016],
            ['title' => 'Deadpool', 'year' => 2016],
            ['title' => 'Zootopia', 'year' => 2016],
            ['title' => 'Moana', 'year' => 2016],

            // 2015
            ['title' => 'Star Wars: The Force Awakens', 'year' => 2015],
            ['title' => 'Avengers: Age of Ultron', 'year' => 2015],
            ['title' => 'Jurassic World', 'year' => 2015],
            ['title' => 'Inside Out', 'year' => 2015],
            ['title' => 'Furious 7', 'year' => 2015],
            ['title' => 'Minions', 'year' => 2015],
            ['title' => 'Spectre', 'year' => 2015],
            ['title' => 'The Hunger Games: Mockingjay - Part 2', 'year' => 2015],
            ['title' => 'Cinderella', 'year' => 2015],
            ['title' => 'Ant-Man', 'year' => 2015],
        ];

        $totalMovies = count($moviesToSeed);
        $successCount = 0;
        $skipCount = 0;

        foreach ($moviesToSeed as $index => $movieInfo) {
            $progress = $this->createProgressBar($index + 1, $totalMovies, $movieInfo['title'], $movieInfo['year']);

            try {
                // Check if movie already exists
                $slug = Str::slug($movieInfo['title']);
                $existingMovie = Movie::where('slug', $slug)->first();

                if ($existingMovie) {
                    $this->command->line($progress . " <fg=yellow>SKIP</> (already exists)");
                    $skipCount++;
                    continue;
                }

                // Search movie on TMDB
                $searchResult = $this->searchMovie($movieInfo['title'], $movieInfo['year']);

                if (!$searchResult) {
                    $this->command->line($progress . " <fg=red>FAIL</> (not found on TMDB)");
                    continue;
                }

                // Get full movie details
                $movieDetails = $this->getMovieDetails($searchResult['id']);

                if (!$movieDetails) {
                    $this->command->line($progress . " <fg=red>FAIL</> (failed to fetch details)");
                    continue;
                }

                // Get movie videos/trailers
                $videos = $this->getMovieVideos($searchResult['id']);

                // Get movie credits
                $credits = $this->getMovieCredits($searchResult['id']);

                // Create the movie
                $movie = $this->createMovie($movieDetails, $credits);

                // Create trailers
                $this->createTrailers($movie, $videos);

                // Attach categories
                $this->attachCategories($movie, $movieDetails);

                $successCount++;
                $this->command->line($progress . " <fg=green>OK</>");

                // Rate limiting: sleep between requests
                usleep(250000); // 0.25 seconds

            } catch (\Exception $e) {
                $this->command->line($progress . " <fg=red>ERROR</> " . $e->getMessage());
                continue;
            }
        }

        $this->command->newLine();
        $this->command->info("   Total: {$totalMovies} | Created: {$successCount} | Skipped: {$skipCount} | Failed: " . ($totalMovies - $successCount - $skipCount));
    }

    /**
     * Create progress bar for seeder output
     */
    private function createProgressBar(int $current, int $total, string $title, int $year): string
    {
        $percentage = round(($current / $total) * 100);
        $progressBar = str_repeat('=', min(20, (int) ($percentage / 5))) . '>';
        $progressBar = str_pad($progressBar, 21, ' ');

        return "   [<fg=cyan>{$progressBar}</>] " .
               str_pad("{$current}/{$total}", 8, ' ', STR_PAD_LEFT) . " " .
               "<fg=white>{$title}</> ({$year})";
    }

    /**
     * Search for a movie on TMDB
     */
    private function searchMovie(string $title, int $year): ?array
    {
        $response = Http::withoutVerifying()->get("{$this->tmdbBaseUrl}/search/movie", [
            'api_key' => $this->tmdbApiKey,
            'query' => $title,
            'year' => $year,
            'language' => 'vi-VN',
        ]);

        if (!$response->successful()) {
            return null;
        }

        $results = $response->json('results', []);
        if (empty($results)) {
            return null;
        }

        return $results[0];
    }

    /**
     * Get full movie details from TMDB
     */
    private function getMovieDetails(int $tmdbId): ?array
    {
        $response = Http::withoutVerifying()->get("{$this->tmdbBaseUrl}/movie/{$tmdbId}", [
            'api_key' => $this->tmdbApiKey,
            'language' => 'vi-VN',
            'append_to_response' => 'credits,videos,images',
        ]);

        if (!$response->successful()) {
            return null;
        }

        return $response->json();
    }

    /**
     * Get movie videos/trailers from TMDB
     */
    private function getMovieVideos(int $tmdbId): array
    {
        $response = Http::withoutVerifying()->get("{$this->tmdbBaseUrl}/movie/{$tmdbId}/videos", [
            'api_key' => $this->tmdbApiKey,
            'language' => 'vi-VN,en-US',
        ]);

        if (!$response->successful()) {
            return [];
        }

        return $response->json('results', []);
    }

    /**
     * Get movie credits from TMDB
     */
    private function getMovieCredits(int $tmdbId): array
    {
        $response = Http::withoutVerifying()->get("{$this->tmdbBaseUrl}/movie/{$tmdbId}/credits", [
            'api_key' => $this->tmdbApiKey,
        ]);

        if (!$response->successful()) {
            return [];
        }

        return $response->json();
    }

    /**
     * Create movie from TMDB data
     */
    private function createMovie(array $details, array $credits): Movie
    {
        // Extract director and cast from credits
        $director = '';
        $cast = '';

        if (isset($credits['crew'])) {
            $directors = collect($credits['crew'])->filter(fn($person) => $person['job'] === 'Director');
            if ($directors->isNotEmpty()) {
                $director = $directors->pluck('name')->take(2)->implode(', ');
            }
        }

        if (isset($credits['cast'])) {
            $castNames = collect($credits['cast'])->pluck('name')->take(5)->toArray();
            $cast = implode(', ', $castNames);
        }

        // Determine statuses based on release date
        $releaseDate = $details['release_date'] ?? null;
        $statuses = ['released']; // Default status

        if ($releaseDate) {
            $releaseDateObj = Carbon::parse($releaseDate);
            if ($releaseDateObj->isFuture()) {
                $statuses = ['upcoming'];
            }
        }

        // Randomly add 'hot' status to some movies (about 30%)
        if (rand(1, 100) <= 30) {
            $statuses[] = 'hot';
        }

        // Generate SEO content
        $seoContent = $this->generateSeoContent($details, $credits);

        $slug = Str::slug($details['title']);
        $originalSlug = $slug;

        // Ensure unique slug
        $counter = 1;
        while (Movie::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $movie = Movie::create([
            'title' => $details['title'],
            'original_title' => $details['original_title'] ?? $details['title'],
            'slug' => $slug,
            'description' => $details['overview'] ?? '',
            'content' => $seoContent['content'],
            'notable_points' => $seoContent['notable_points'],
            'faq' => $seoContent['faq'],
            'poster' => $details['poster_path'] ? "{$this->tmdbImageBaseUrl}/w500{$details['poster_path']}" : null,
            'backdrop' => $details['backdrop_path'] ? "{$this->tmdbImageBaseUrl}/w1280{$details['backdrop_path']}" : null,
            'release_date' => $releaseDate,
            'duration' => $details['runtime'] ?? null,
            'country' => null, // Will be set from categories
            'view_count' => 0,
            'published_at' => now(),
            'director' => $director,
            'cast' => $cast,
        ]);

        // Attach statuses using pivot table
        foreach ($statuses as $status) {
            MovieStatus::create([
                'movie_id' => $movie->id,
                'status' => $status,
            ]);
        }

        return $movie;
    }

    /**
     * Generate SEO content based on movie details
     */
    private function generateSeoContent(array $details, array $credits): array
    {
        $title = $details['title'] ?? '';
        $overview = $details['overview'] ?? '';
        $releaseDate = $details['release_date'] ?? '';

        // Extract genres
        $genres = [];
        if (isset($details['genres'])) {
            $genres = collect($details['genres'])->pluck('name')->toArray();
        }

        // Extract director
        $directorName = '';
        if (isset($credits['crew'])) {
            $directors = collect($credits['crew'])->filter(fn($person) => $person['job'] === 'Director');
            if ($directors->isNotEmpty()) {
                $directorName = $directors->first()['name'] ?? '';
            }
        }

        // Generate content (120-180 words)
        $content = $this->generateContent($title, $overview, $genres);

        // Generate notable points (2-3 sentences)
        $notablePoints = $this->generateNotablePoints($title, $genres, $releaseDate);

        // Generate FAQ
        $faq = $this->generateFaq($title, $releaseDate, $genres, $directorName);

        return [
            'content' => $content,
            'notable_points' => $notablePoints,
            'faq' => $faq,
        ];
    }

    /**
     * Generate main content (120-180 words)
     */
    private function generateContent(string $title, string $overview, array $genres): string
    {
        // If TMDB overview exists and is substantial, enhance it
        if (!empty($overview) && strlen($overview) > 50) {
            // Use overview but ensure it's not too short
            if (strlen($overview) > 150) {
                return $overview;
            }
            // Enhance short overview
            $genreText = !empty($genres) ? implode(', ', array_slice($genres, 0, 2)) : 'điện ảnh';
            return $overview . " " . $title . " mang đến cho khán giả những trải nghiệm điện ảnh đầy cảm xúc với tiết chế diễn biến căng thẳng. Bộ phim thuộc thể loại {$genreText} hứa hẹn là một tác phẩm đáng xem trong năm nay.";
        }

        // Otherwise, generate contextual content
        $genreText = !empty($genres) ? implode(', ', array_slice($genres, 0, 2)) : 'điện ảnh';

        $content = "{$title} là một tác phẩm {$genreText} được đầu tư công phu về mặt hình ảnh. Bộ phim mở ra một thế giới nơi nhân vật chính phải đối mặt với những thử thách cam go, đặt ra những quyết định khó khăn ảnh hưởng đến số phận của bản thân và những người xung quanh. ";

        $content .= "Xung đột nội tại và ngoại tại được khai thác sâu sắc, tạo nên những thước phim đầy kịch tính và cảm xúc. ";
        $content .= "Với bối cảnh được xây dựng tỉ mỉ, ấn tượng, {$title} hứa hẹn mang đến những trải nghiệm thị giác mãn nhãn cho khán giả yêu thích thể loại {$genreText}.";

        return $content;
    }

    /**
     * Generate notable points (2-3 sentences)
     */
    private function generateNotablePoints(string $title, array $genres, string $releaseDate): string
    {
        $points = [];

        $points[] = "{$title} thu hút sự quan tâm đặc biệt từ khán giả nhờ vào concept độc đáo và dàn diễn viên tài năng.";

        if (!empty($genres)) {
            $genreText = implode(' và ', array_slice($genres, 0, 2));
            $points[] = "Bộ phim kết hợp yếu tố {$genreText}, tạo nên những phân cảnh căng thẳng và cảm xúc mãnh liệt.";
        }

        if ($releaseDate) {
            $releaseYear = date('Y', strtotime($releaseDate));
            $points[] = "Được khởi chiếu vào năm {$releaseYear}, tác phẩm nhanh chóng trở thành hiện tượng và thu hút lượng lớn khán giả.";
        }

        return implode("\n\n", $points);
    }

    /**
     * Generate FAQ (3 Q&A)
     */
    private function generateFaq(string $title, string $releaseDate, array $genres, string $director): array
    {
        $faq = [];

        // Q1: Release date
        if ($releaseDate) {
            $formattedDate = date('d/m/Y', strtotime($releaseDate));
            $isReleased = Carbon::parse($releaseDate)->isPast();

            if ($isReleased) {
                $faq[] = [
                    'question' => "{$title} công chiếu vào lúc nào?",
                    'answer' => "{$title} đã được công chiếu rộng rãi từ ngày {$formattedDate}.",
                ];
            } else {
                $faq[] = [
                    'question' => "{$title} sẽ công chiếu vào khi nào?",
                    'answer' => "{$title} dự kiến khởi chiếu vào ngày {$formattedDate}.",
                ];
            }
        }

        // Q2: Trailer
        $faq[] = [
            'question' => "Trailer chính thức của {$title} đã được phát hành chưa?",
            'answer' => "Có, trailer chính thức của {$title} đã được nhà sản xuất phát hành và đang có sẵn trên các nền tảng video như YouTube.",
        ];

        // Q3: Genre
        if (!empty($genres)) {
            $genreText = implode(', ', $genres);
            $faq[] = [
                'question' => "{$title} thuộc thể loại gì?",
                'answer' => "{$title} là một bộ phim thuộc thể loại {$genreText}.",
            ];
        } else {
            $faq[] = [
                'question' => "{$title} có nội dung gì?",
                'answer' => "{$title} mang đến cho khán giả những trải nghiệm điện ảnh đặc sắc với cốt truyện đầy kịch tính và bất ngờ.",
            ];
        }

        // Q4: Director (optional 4th FAQ)
        if (!empty($director)) {
            $faq[] = [
                'question' => "Ai là đạo diễn của {$title}?",
                'answer' => "{$title} do đạo diễn {$director} chỉ đạo, người đã mang đến một góc nhìn nghệ thuật độc đáo cho tác phẩm.",
            ];
        }

        return $faq;
    }

    /**
     * Create trailers for a movie
     */
    private function createTrailers(Movie $movie, array $videos): void
    {
        $trailers = collect($videos)->filter(fn($video) =>
            in_array($video['type'], ['Trailer', 'Teaser']) &&
            in_array($video['site'], ['YouTube']) &&
            in_array($video['official'], [true, null])
        );

        if ($trailers->isEmpty()) {
            // Try to find any YouTube video
            $trailers = collect($videos)->filter(fn($video) => $video['site'] === 'YouTube');
        }

        $mainTrailerSet = false;

        foreach ($trailers->take(3) as $index => $video) {
            $isMain = (!$mainTrailerSet && $video['type'] === 'Trailer') ||
                      (!$mainTrailerSet && $index === 0);

            // Generate slug from title
            $title = $video['name'] ?? 'Trailer';
            $slug = Str::slug($title) . '-' . $video['key'];

            Trailer::create([
                'movie_id' => $movie->id,
                'youtube_id' => $video['key'],
                'title' => $title,
                'slug' => $slug,
                'is_main' => $isMain,
            ]);

            if ($isMain) {
                $mainTrailerSet = true;
            }
        }
    }

    /**
     * Attach categories to movie
     */
    private function attachCategories(Movie $movie, array $details): void
    {
        $genreIds = [];
        $countryIds = [];
        $yearIds = [];

        // Map TMDB genres to local categories
        $genreMapping = [
            'Action' => 'hanh-dong',
            'Adventure' => 'phieu-luu',
            'Animation' => 'hoat-hinh',
            'Comedy' => 'hai-huoc',
            'Crime' => 'toi-pham',
            'Documentary' => 'tai-lieu',
            'Drama' => 'tinh-cam',
            'Family' => 'gia-dinh',
            'Fantasy' => 'vien-tuong',
            'History' => 'kich-tinh',
            'Horror' => 'kinh-di',
            'Mystery' => 'bi-an',
            'Romance' => 'tinh-cam',
            'Science Fiction' => 'vien-tuong',
            'Thriller' => 'kich-tinh',
            'War' => 'chien-tranh',
            'Western' => 'phieu-luu',
        ];

        // Process genres
        if (isset($details['genres'])) {
            foreach ($details['genres'] as $tmdbGenre) {
                $genreSlug = $genreMapping[$tmdbGenre['name']] ?? null;

                if ($genreSlug) {
                    $category = Category::where('slug', $genreSlug)
                        ->where('type', 'genre')
                        ->first();

                    if ($category) {
                        $genreIds[] = $category->id;
                    }
                }
            }
        }

        // Detect country from production countries
        if (isset($details['production_countries']) && !empty($details['production_countries'])) {
            $countryMapping = [
                'US' => 'my',
                'GB' => 'anh',
                'FR' => 'phap',
                'DE' => 'duc',
                'JP' => 'nhat-ban',
                'KR' => 'han-quoc',
                'CN' => 'trung-quoc',
                'VN' => 'viet-nam',
                'TH' => 'thai-lan',
                'AU' => 'uc',
                'CA' => 'canada',
                'IN' => 'an-do',
                'ID' => 'indonesia',
                'PH' => 'philippines',
            ];

            $mainCountry = $details['production_countries'][0]['iso_3166_1'] ?? null;
            $countrySlug = $countryMapping[$mainCountry] ?? null;

            if ($countrySlug) {
                $category = Category::where('slug', $countrySlug)
                    ->where('type', 'country')
                    ->first();

                if ($category) {
                    $countryIds[] = $category->id;
                    // Update movie country
                    $movie->update(['country' => $category->name]);
                }
            }
        }

        // Attach year category
        if (isset($details['release_date'])) {
            $releaseYear = date('Y', strtotime($details['release_date']));
            $yearCategory = Category::where('name', (string) $releaseYear)
                ->where('type', 'year')
                ->first();

            if ($yearCategory) {
                $yearIds[] = $yearCategory->id;
            }
        }

        // Attach all categories
        $allCategoryIds = array_merge($genreIds, $countryIds, $yearIds);
        if (!empty($allCategoryIds)) {
            $movie->categories()->attach($allCategoryIds);
        }
    }
}
