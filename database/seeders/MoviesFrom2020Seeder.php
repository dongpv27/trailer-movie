<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Movie;
use App\Models\Trailer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MoviesFrom2020Seeder extends Seeder
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

        if (empty($this->tmdbApiKey)) {
            $this->command->error('TMDB_API_KEY not found in .env file!');
            $this->command->warn('Please add: TMDB_API_KEY=your_key_here to your .env file');
            $this->command->warn('Get your free API key at: https://www.themoviedb.org/settings/api');
            exit(1);
        }
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== Seeding Movies from 2020-2025 ===');

        // List of popular movies from 2020-2025 to seed
        $moviesToSeed = [
            // 2025
            ['title' => 'Captain America: Brave New World', 'year' => 2025],
            ['title' => 'Mission: Impossible 8', 'year' => 2025],
            ['title' => 'Avatar 3', 'year' => 2025],
            ['title' => 'The SpongeBob Movie: Search for SquarePants', 'year' => 2025],
            ['title' => 'Thunderbolts', 'year' => 2025],

            // 2024
            ['title' => 'Deadpool & Wolverine', 'year' => 2024],
            ['title' => 'Dune: Part Two', 'year' => 2024],
            ['title' => 'Inside Out 2', 'year' => 2024],
            ['title' => 'Gladiator 2', 'year' => 2024],
            ['title' => 'Wicked', 'year' => 2024],
            ['title' => 'Joker: Folie à Deux', 'year' => 2024],
            ['title' => 'Kingdom of the Planet of the Apes', 'year' => 2024],
            ['title' => 'Godzilla x Kong: The New Empire', 'year' => 2024],
            ['title' => 'Beekeeper', 'year' => 2024],
            ['title' => 'Argylle', 'year' => 2024],

            // 2023
            ['title' => 'Oppenheimer', 'year' => 2023],
            ['title' => 'Barbie', 'year' => 2023],
            ['title' => 'Spider-Man: Across the Spider-Verse', 'year' => 2023],
            ['title' => 'Guardians of the Galaxy Vol. 3', 'year' => 2023],
            ['title' => 'John Wick: Chapter 4', 'year' => 2023],
            ['title' => 'Killers of the Flower Moon', 'year' => 2023],
            ['title' => 'The Marvels', 'year' => 2023],
            ['title' => 'Ant-Man and the Wasp: Quantumania', 'year' => 2023],
            ['title' => 'Indiana Jones and the Dial of Destiny', 'year' => 2023],
            ['title' => 'Mission: Impossible - Dead Reckoning', 'year' => 2023],

            // 2022
            ['title' => 'Top Gun: Maverick', 'year' => 2022],
            ['title' => 'Avatar: The Way of Water', 'year' => 2022],
            ['title' => 'Black Panther: Wakanda Forever', 'year' => 2022],
            ['title' => 'Thor: Love and Thunder', 'year' => 2022],
            ['title' => 'The Batman', 'year' => 2022],
            ['title' => 'Doctor Strange in the Multiverse of Madness', 'year' => 2022],
            ['title' => 'Jurassic World Dominion', 'year' => 2022],
            ['title' => 'Minions: The Rise of Gru', 'year' => 2022],

            // 2021
            ['title' => 'Spider-Man: No Way Home', 'year' => 2021],
            ['title' => 'Dune', 'year' => 2021],
            ['title' => 'Shang-Chi and the Legend of the Ten Rings', 'year' => 2021],
            ['title' => 'Eternals', 'year' => 2021],
            ['title' => 'Fast & Furious 9', 'year' => 2021],
            ['title' => 'No Time to Die', 'year' => 2021],
            ['title' => 'Free Guy', 'year' => 2021],
            ['title' => 'The Suicide Squad', 'year' => 2021],

            // 2020
            ['title' => 'Tenet', 'year' => 2020],
            ['title' => 'Wonder Woman 1984', 'year' => 2020],
            ['title' => 'Mulan', 'year' => 2020],
            ['title' => 'Soul', 'year' => 2020],
            ['title' => 'The Midnight Sky', 'year' => 2020],
            ['title' => 'Enola Holmes', 'year' => 2020],
            ['title' => 'The Trial of the Chicago 7', 'year' => 2020],
            ['title' => 'Borat Subsequent Moviefilm', 'year' => 2020],
        ];

        $totalMovies = count($moviesToSeed);
        $successCount = 0;
        $skipCount = 0;

        foreach ($moviesToSeed as $index => $movieInfo) {
            $this->command->info("Processing [{$index}/{$totalMovies}]: {$movieInfo['title']} ({$movieInfo['year']})");

            try {
                // Check if movie already exists
                $slug = Str::slug($movieInfo['title']);
                $existingMovie = Movie::where('slug', $slug)->first();

                if ($existingMovie) {
                    $this->command->warn("  - Skipped (already exists)");
                    $skipCount++;
                    continue;
                }

                // Search movie on TMDB
                $searchResult = $this->searchMovie($movieInfo['title'], $movieInfo['year']);

                if (!$searchResult) {
                    $this->command->error("  - Not found on TMDB");
                    continue;
                }

                // Get full movie details
                $movieDetails = $this->getMovieDetails($searchResult['id']);

                if (!$movieDetails) {
                    $this->command->error("  - Failed to fetch details");
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
                $this->command->info("  - Created: {$movie->title}");

                // Rate limiting: sleep between requests to avoid hitting TMDB rate limits
                usleep(250000); // 0.25 seconds between requests

            } catch (\Exception $e) {
                $this->command->error("  - Error: {$e->getMessage()}");
                continue;
            }
        }

        $this->command->newLine();
        $this->command->info('=== Seeding Complete ===');
        $this->command->info("Total processed: {$totalMovies}");
        $this->command->info("Successfully created: {$successCount}");
        $this->command->info("Skipped (already exists): {$skipCount}");
        $this->command->info("Failed: " . ($totalMovies - $successCount - $skipCount));
    }

    /**
     * Search for a movie on TMDB
     */
    private function searchMovie(string $title, int $year): ?array
    {
        $response = Http::get("{$this->tmdbBaseUrl}/search/movie", [
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

        return $results[0]; // Return first (most relevant) result
    }

    /**
     * Get full movie details from TMDB
     */
    private function getMovieDetails(int $tmdbId): ?array
    {
        $response = Http::get("{$this->tmdbBaseUrl}/movie/{$tmdbId}", [
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
        $response = Http::get("{$this->tmdbBaseUrl}/movie/{$tmdbId}/videos", [
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
        $response = Http::get("{$this->tmdbBaseUrl}/movie/{$tmdbId}/credits", [
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

        // Determine status based on release date
        $releaseDate = $details['release_date'] ?? null;
        $status = 'released';

        if ($releaseDate) {
            $releaseDateObj = Carbon::parse($releaseDate);
            if ($releaseDateObj->isFuture()) {
                $status = 'upcoming';
            }
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
            'status' => $status,
            'duration' => $details['runtime'] ?? null,
            'country' => null, // Will be set from categories
            'view_count' => 0,
            'published_at' => now(),
            'director' => $director,
            'cast' => $cast,
        ]);

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

        // Extract director for FAQ
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
        // If TMDB overview exists and is substantial, use it
        if (!empty($overview) && strlen($overview) > 100) {
            return $overview;
        }

        // Otherwise, generate generic content
        $genreText = !empty($genres) ? implode(', ', $genres) : 'điện ảnh';

        $content = "{$title} là một trong những tác phẩm {$genreText} được mong chờ nhất. Với bối cảnh được xây dựng công phu và câu chuyện đầy kịch tính, bộ phim hứa hẹn mang đến những trải nghiệm thị giác mãn nhãn cho khán giả. ";

        $content .= "Nhân vật chính sẽ phải đối mặt với những thử thách cam go, nơi mọi quyết định đều ảnh hưởng đến số phận của nhiều người. Xung đột nội tại và ngoại tại được khắc họa sâu sắc qua từng diễn biến của cốt truyện. ";

        $content .= "Đội ngũ sản xuất đã đầu tư mạnh mẽ vào khâu hình ảnh, tạo nên những thước phim tráng lệ và đậm chất điện ảnh. Đây chắc chắn là một tác phẩm đáng xem trong mùa phim năm nay.";

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
            $points[] = "Bộ phim kết hợp yếu tố {$genreText}, tạo nên những phaisSelected căng thẳng và cảm xúc mãnh liệt.";
        }

        if ($releaseDate) {
            $releaseYear = date('Y', strtotime($releaseDate));
            $points[] = "Được khởi chiếu vào năm {$releaseYear}, tác phẩm nhanh chóng trở thành hiện tượng và thu hút lượng lớn khán giả tại rạp.";
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

            Trailer::create([
                'movie_id' => $movie->id,
                'youtube_id' => $video['key'],
                'title' => $video['name'],
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
            'History' => 'lich-su',
            'Horror' => 'kinh-di',
            'Mystery' => 'bi-an',
            'Romance' => 'lang-man',
            'Science Fiction' => 'khoa-hoc-vien-tuong',
            'Thriller' => 'kich-tinh',
            'War' => 'chien-tranh',
            'Western' => 'tay-duong',
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

        // Attach all categories
        $allCategoryIds = array_merge($genreIds, $countryIds);
        if (!empty($allCategoryIds)) {
            $movie->categories()->attach($allCategoryIds);
        }
    }
}
