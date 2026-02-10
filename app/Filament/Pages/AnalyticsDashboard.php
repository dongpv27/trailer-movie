<?php

namespace App\Filament\Pages;

use App\Models\Category;
use App\Models\Movie;
use App\Models\PageVisit;
use App\Models\Post;
use App\Models\Trailer;
use App\Models\TrailerPlay;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class AnalyticsDashboard extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Thống kê';
    protected static ?int $navigationSort = -1;

    protected static ?string $title = 'Thống kê';

    public function getView(): string
    {
        return 'filament.pages.analytics-dashboard';
    }

    public ?array $stats = [];
    public ?array $chartData = [];
    public ?array $topMovies = [];
    public ?array $topTrailers = [];
    public ?array $categoryStats = [];
    public string $dateRange = '30';

    public function mount(): void
    {
        $this->loadData();
    }

    public function setDateRange(string $days): void
    {
        $this->dateRange = $days;
        $this->loadData();
    }

    protected function loadData(): void
    {
        $startDate = now()->subDays((int) $this->dateRange)->startOfDay();
        $endDate = now()->endOfDay();

        $this->stats = [
            'pageViews' => PageVisit::whereBetween('visited_at', [$startDate, $endDate])->count(),
            'uniqueVisitors' => PageVisit::whereBetween('visited_at', [$startDate, $endDate])
                ->distinct('session_id')
                ->count('session_id'),
            'trailerPlays' => TrailerPlay::whereBetween('played_at', [$startDate, $endDate])->count(),
            'avgViewsPerDay' => round(PageVisit::whereBetween('visited_at', [$startDate, $endDate])->count() / max(1, (int) $this->dateRange), 0),
        ];

        $this->chartData = $this->getChartData($startDate, $endDate);

        $this->topMovies = Movie::select(['movies.id', 'movies.title', 'movies.slug', 'movies.poster', 'movies.view_count'])
            ->whereHas('pageVisits', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('visited_at', [$startDate, $endDate]);
            })
            ->withCount(['pageVisits as visit_count' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('visited_at', [$startDate, $endDate]);
            }])
            ->orderByDesc('visit_count')
            ->limit(10)
            ->get()
            ->toArray();

        $this->topTrailers = Trailer::select(['trailers.id', 'trailers.title', 'trailers.youtube_id', 'trailers.play_count', 'movies.title as movie_title'])
            ->leftJoin('movies', 'trailers.movie_id', '=', 'movies.id')
            ->whereHas('plays', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('played_at', [$startDate, $endDate]);
            })
            ->withCount(['plays as play_count_period' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('played_at', [$startDate, $endDate]);
            }])
            ->orderByDesc('play_count_period')
            ->limit(10)
            ->get()
            ->toArray();

        // Calculate category stats for pie chart
        $totalVisits = PageVisit::whereBetween('visited_at', [$startDate, $endDate])->count();
        if ($totalVisits > 0) {
            $movieVisits = PageVisit::whereBetween('visited_at', [$startDate, $endDate])
                ->where('visitable_type', (new Movie())->getMorphClass())
                ->count();
            $postVisits = PageVisit::whereBetween('visited_at', [$startDate, $endDate])
                ->where('visitable_type', (new Post())->getMorphClass())
                ->count();
            $categoryVisits = PageVisit::whereBetween('visited_at', [$startDate, $endDate])
                ->where('visitable_type', (new Category())->getMorphClass())
                ->count();
            $otherVisits = $totalVisits - $movieVisits - $postVisits - $categoryVisits;

            $this->categoryStats = [
                'movies' => round($movieVisits / $totalVisits * 100),
                'posts' => round($postVisits / $totalVisits * 100),
                'categories' => round($categoryVisits / $totalVisits * 100),
                'other' => round($otherVisits / $totalVisits * 100),
            ];
        } else {
            $this->categoryStats = ['movies' => 0, 'posts' => 0, 'categories' => 0, 'other' => 0];
        }
    }

    protected function getChartData($startDate, $endDate): array
    {
        $days = [];
        $pageViewsData = [];
        $trailerPlaysData = [];

        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $date) {
            $days[] = $date->format('d/m');
            $pageViewsData[] = PageVisit::whereDate('visited_at', $date)->count();
            $trailerPlaysData[] = TrailerPlay::whereDate('played_at', $date)->count();
        }

        return [
            'labels' => $days,
            'pageViews' => $pageViewsData,
            'trailerPlays' => $trailerPlaysData,
        ];
    }

    public function getTopCategoriesProperty(): array
    {
        $startDate = now()->subDays((int) $this->dateRange)->startOfDay();

        return Category::select(['categories.id', 'categories.name', 'categories.slug', 'categories.type'])
            ->withCount(['pageVisits as visit_count' => function ($query) use ($startDate) {
                $query->whereBetween('visited_at', [$startDate, now()]);
            }])
            ->orderByDesc('visit_count')
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function getTopPostsProperty(): array
    {
        $startDate = now()->subDays((int) $this->dateRange)->startOfDay();

        return Post::select(['posts.id', 'posts.title', 'posts.slug', 'posts.view_count'])
            ->withCount(['pageVisits as visit_count' => function ($query) use ($startDate) {
                $query->whereBetween('visited_at', [$startDate, now()]);
            }])
            ->orderByDesc('visit_count')
            ->limit(5)
            ->get()
            ->toArray();
    }
}
