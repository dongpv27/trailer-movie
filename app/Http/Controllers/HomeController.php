<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $cacheKey = 'home-page-data';

        $data = cache()->remember($cacheKey, 1800, function () {
            return [
                'hotMovies' => Movie::hot()
                    ->with(['categories', 'mainTrailer'])
                    ->orderByDesc('release_date')
                    ->limit(12)
                    ->get(),

                'upcomingMovies' => Movie::upcoming()
                    ->with(['categories', 'mainTrailer'])
                    ->orderBy('release_date')
                    ->limit(12)
                    ->get(),

                'releasedMovies' => Movie::released()
                    ->with(['categories', 'mainTrailer'])
                    ->orderByDesc('release_date')
                    ->limit(12)
                    ->get(),

                'topMovies' => Movie::top()
                    ->with(['categories', 'mainTrailer'])
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
