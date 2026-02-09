<?php

use App\Models\Movie;
use Illuminate\Support\Facades\Route;

Route::get('/check-movie/{id}', function ($id) {
    $movie = Movie::find($id);

    if (!$movie) {
        return "Movie not found: ID {$id}";
    }

    return response()->json([
        'id' => $movie->id,
        'title' => $movie->title,
        'slug' => $movie->slug,
        'director' => $movie->director,
        'cast' => $movie->cast,
        'director_is_null' => is_null($movie->director),
        'cast_is_null' => is_null($movie->cast),
    ]);
});
