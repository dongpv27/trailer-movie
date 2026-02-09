<?php

use App\Models\Movie;
use Illuminate\Support\Facades\Route;

Route::get("/debug-movie/{slug}", function ($slug) {
    $movie = Movie::where("slug", $slug)->first();

    if (!$movie) {
        return "Movie not found: {$slug}";
    }

    return response()->json([
        "id" => $movie->id,
        "title" => $movie->title,
        "slug" => $movie->slug,
        "director" => $movie->director,
        "cast" => $movie->cast,
    ]);
});
