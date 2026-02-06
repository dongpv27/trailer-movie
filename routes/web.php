<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Movie routes
Route::get('/phim-hot', [MovieController::class, 'hot'])->name('movie.hot');
Route::get('/trailer-sap-chieu', [MovieController::class, 'upcoming'])->name('movie.upcoming');
Route::get('/trailer-dang-chieu', [MovieController::class, 'released'])->name('movie.released');
Route::get('/top-phim', [MovieController::class, 'top'])->name('movie.top');
Route::get('/phim/{slug}', [MovieController::class, 'show'])->name('movie.show');

// Category routes
Route::get('/sap-chieu', [CategoryController::class, 'upcoming'])->name('category.upcoming');
Route::get('/dang-chieu', [CategoryController::class, 'released'])->name('category.released');
Route::get('/the-loai/{slug}', [CategoryController::class, 'genre'])->name('category.genre');
Route::get('/quoc-gia/{slug}', [CategoryController::class, 'country'])->name('category.country');
Route::get('/nam-pham/{slug}', [CategoryController::class, 'year'])->name('category.year');

// Post routes
Route::get('/tin-dien-anh', [PostController::class, 'index'])->name('post.index');
Route::get('/tin-dien-anh/{slug}', [PostController::class, 'show'])->name('post.show');

// Sitemap
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
