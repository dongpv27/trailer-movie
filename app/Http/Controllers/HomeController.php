<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $cacheKey = 'home-page-data-v3';

        $data = cache()->remember($cacheKey, 1800, function () {
            $hotMovies = Movie::hot()
                ->with(['categories', 'mainTrailer', 'statuses'])
                ->orderByDesc('release_date')
                ->limit(22)
                ->get();

            return [
                'sliderMovies' => $hotMovies->take(10),

                'hotMovies' => $hotMovies,

                'upcomingMovies' => Movie::upcoming()
                    ->with(['categories', 'mainTrailer', 'statuses'])
                    ->orderBy('release_date')
                    ->limit(12)
                    ->get(),

                'releasedMovies' => Movie::released()
                    ->with(['categories', 'mainTrailer', 'statuses'])
                    ->orderByDesc('release_date')
                    ->limit(12)
                    ->get(),

                'topMovies' => Movie::top()
                    ->with(['categories', 'mainTrailer', 'statuses'])
                    ->limit(10)
                    ->get(),

                'posts' => Post::published()
                    ->orderByDesc('published_at')
                    ->limit(6)
                    ->get(),
            ];
        });

        return view('home', $data);
    }
}
