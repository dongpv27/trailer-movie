<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function show(string $slug)
    {
        $movie = Movie::select('*')
            ->where('slug', $slug)
            ->with(['trailers', 'categories', 'genres', 'countries', 'streamings'])
            ->firstOrFail();

        // Increment view count
        $movie->incrementView();

        // Related movies: same genres, released
        $relatedMovies = cache()->remember(
            "movie:{$movie->id}:related",
            1800,
            fn() => Movie::released()
                ->where('id', '!=', $movie->id)
                ->whereHas('genres', fn($q) => $q->whereIn('categories.id', $movie->genres->pluck('id')))
                ->with(['categories', 'mainTrailer'])
                ->inRandomOrder()
                ->limit(8)
                ->get()
        );

        return view('movie.show', compact('movie', 'relatedMovies'));
    }

    public function hot(Request $request)
    {
        // Phim hot sắp chiếu (8-12 phim)
        $upcomingHot = Movie::hot()
            ->upcoming()
            ->with(['categories', 'mainTrailer'])
            ->orderByDesc('release_date')
            ->limit(12)
            ->get();

        // Phim hot đang chiếu được quan tâm
        $releasedHot = Movie::hot()
            ->released()
            ->with(['categories', 'mainTrailer'])
            ->orderByDesc('view_count')
            ->orderByDesc('release_date')
            ->limit(12)
            ->get();

        // Lấy các thể loại chính để hiển thị section
        $hotGenres = Category::where('type', 'genre')
            ->with(['movies' => fn($q) => $q->hot()->published()->take(4)])
            ->limit(4)
            ->get();

        // SEO Data
        $seoTitle = 'Trailer phim hot nhất hiện nay – Cập nhật trailer mới';
        $seoDescription = 'Tổng hợp trailer phim hot nhất hiện nay, gồm phim sắp chiếu và đang chiếu. Cập nhật trailer chính thức nhanh và đầy đủ.';
        $canonicalUrl = route('movie.hot');

        return view('movie.hot', compact(
            'upcomingHot',
            'releasedHot',
            'hotGenres',
            'seoTitle',
            'seoDescription',
            'canonicalUrl'
        ));
    }

    public function upcoming(Request $request)
    {
        $movies = Movie::upcoming()
            ->with(['categories', 'mainTrailer'])
            ->orderBy('release_date')
            ->paginate(24);

        $seoTitle = 'Trailer phim sắp chiếu - Phim sắp ra rạp mới nhất';
        $seoDescription = 'Tổng hợp trailer phim sắp chiếu mới nhất, giúp người xem nắm bắt thông tin các bộ phim chuẩn bị ra mắt trong thời gian tới.';

        return view('movie.upcoming', compact('movies', 'seoTitle', 'seoDescription'));
    }

    public function released(Request $request)
    {
        $movies = Movie::released()
            ->with(['categories', 'mainTrailer'])
            ->orderByDesc('release_date')
            ->paginate(24);

        $seoTitle = 'Trailer phim đang chiếu - Phim chiếu rạp mới nhất';
        $seoDescription = 'Trang Phim Đang Chiếu tổng hợp trailer phim đang chiếu tại rạp, cập nhật những bộ phim hiện đang được khán giả quan tâm.';

        return view('movie.released', compact('movies', 'seoTitle', 'seoDescription'));
    }

    public function top(Request $request)
    {
        $movies = Movie::top()
            ->with(['categories', 'mainTrailer'])
            ->paginate(24);

        $seoTitle = 'Top phim xem nhiều - Trailer phim hot nhất';
        $seoDescription = 'Top các bộ phim được xem nhiều nhất trên TrailerPhim. Tổng hợp trailer phim hot nhất hiện nay.';

        return view('movie.list', compact('movies', 'seoTitle', 'seoDescription'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return redirect()->route('home');
        }

        // Trim query
        $query = trim($query);

        // Handle very short queries
        if (strlen($query) < 2) {
            $movies = Movie::query()->whereRaw('1 = 0')->paginate(24);
            $movies->appends(['q' => $query]);

            $seoTitle = "Tìm kiếm: {$query} - Từ khóa quá ngắn";
            $seoDescription = "Từ khóa tìm kiếm quá ngắn. Vui lòng nhập ít nhất 2 ký tự.";

            return view('movie.list', compact('movies', 'seoTitle', 'seoDescription', 'query'));
        }

        // Use full-text search with relevance scoring
        $movies = Movie::published()
            ->with(['categories', 'mainTrailer'])
            ->fullSearch($query)
            ->paginate(24);

        // Preserve query string for pagination
        $movies->appends(['q' => $query]);

        $seoTitle = "Tìm kiếm: {$query} - Kết quả tìm kiếm phim";
        $seoDescription = "Kết quả tìm kiếm phim với từ khóa: {$query}. Tìm phim theo tên, diễn viên, đạo diễn, năm phát hành, thể loại, quốc gia.";

        // Get suggestions if no results found
        $suggestions = null;
        if ($movies->isEmpty()) {
            $suggestions = [
                'hotMovies' => Movie::hot()
                    ->with(['categories', 'mainTrailer'])
                    ->orderByDesc('view_count')
                    ->limit(6)
                    ->get(),
                'popularGenres' => Category::where('type', 'genre')
                    ->withCount('movies')
                    ->orderByDesc('movies_count')
                    ->limit(8)
                    ->get(),
            ];
        }

        return view('movie.list', compact('movies', 'seoTitle', 'seoDescription', 'query', 'suggestions'));
    }
}
