<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function genre(string $slug)
    {
        $category = Category::where('slug', $slug)->where('type', 'genre')->firstOrFail();

        $movies = Movie::published()
            ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id))
            ->with(['categories', 'mainTrailer'])
            ->orderByDesc('release_date')
            ->paginate(24);

        $title = $category->name;
        $description = "Tổng hợp các phim thuộc thể loại {$category->name}.";
        $categoryType = 'genre';
        $categoryName = $category->name;

        return view('category.show', compact('category', 'movies', 'title', 'description', 'categoryType', 'categoryName'));
    }

    public function country(string $slug)
    {
        $category = Category::where('slug', $slug)->where('type', 'country')->firstOrFail();

        $movies = Movie::published()
            ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id))
            ->with(['categories', 'mainTrailer'])
            ->orderByDesc('release_date')
            ->paginate(24);

        $title = "Phim {$category->name}";
        $description = "Tổng hợp các phim sản xuất từ {$category->name}.";
        $categoryType = 'country';
        $categoryName = $category->name;

        return view('category.show', compact('category', 'movies', 'title', 'description', 'categoryType', 'categoryName'));
    }

    public function year(string $slug)
    {
        $category = Category::where('slug', $slug)->where('type', 'year')->firstOrFail();

        $movies = Movie::published()
            ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id))
            ->with(['categories', 'mainTrailer'])
            ->orderByDesc('view_count')
            ->paginate(24);

        $title = "Phim năm {$category->name}";
        $description = "Tổng hợp các phim ra mắt năm {$category->name}.";
        $categoryType = 'year';
        $categoryName = $category->name;

        return view('category.show', compact('category', 'movies', 'title', 'description', 'categoryType', 'categoryName'));
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
}
