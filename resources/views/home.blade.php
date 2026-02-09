@extends('layouts.app')

@section('title', 'Trang chủ')
@section('description', 'TrailerPhim - Xem trailer phim mới nhất, hot nhất, cập nhật liên tục. Tổng hợp trailer phim chiếu rạp, phim Netflix, phim HBO.')

@push('schemas')
@endpush

@section('content')
<!-- Trailer Slider -->
@if(isset($sliderMovies) && $sliderMovies->isNotEmpty())
<x-trailer-slider :movies="$sliderMovies" />
@endif

<!-- Hot Movies -->
@if(isset($hotMovies) && $hotMovies->isNotEmpty())
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold">Phim Hot</h2>
            <a href="{{ route('movie.hot') }}" class="text-yellow-400 hover:text-yellow-400 transition">Xem tất cả &rarr;</a>
        </div>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            @foreach($hotMovies->take(12) as $movie)
            <x-movie-card :movie="$movie" />
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Upcoming Movies -->
@if(isset($upcomingMovies) && $upcomingMovies->isNotEmpty())
<section class="bg-gray-800/50 py-12">
    <div class="container mx-auto px-4">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold">Phim Sắp Chiếu</h2>
            <a href="{{ route('movie.upcoming') }}" class="text-yellow-400 hover:text-yellow-400 transition">Xem tất cả &rarr;</a>
        </div>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            @foreach($upcomingMovies->take(12) as $movie)
            <x-movie-card :movie="$movie" />
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Released Movies -->
@if(isset($releasedMovies) && $releasedMovies->isNotEmpty())
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold">Phim Đang Chiếu</h2>
            <a href="{{ route('movie.released') }}" class="text-yellow-400 hover:text-yellow-400 transition">Xem tất cả &rarr;</a>
        </div>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            @foreach($releasedMovies->take(12) as $movie)
            <x-movie-card :movie="$movie" />
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Top Movies -->
@if(isset($topMovies) && $topMovies->isNotEmpty())
<section class="bg-gray-800/50 py-12">
    <div class="container mx-auto px-4">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold">Top Phim Xem Nhiều</h2>
            <a href="{{ route('movie.top') }}" class="text-yellow-400 hover:text-yellow-400 transition">Xem tất cả &rarr;</a>
        </div>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            @foreach($topMovies->take(10) as $movie)
            <x-movie-card :movie="$movie" />
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Latest Posts -->
@if(isset($posts) && $posts->isNotEmpty())
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold">Tin Điện Ảnh Mới</h2>
            <a href="{{ route('post.index') }}" class="text-yellow-400 hover:text-yellow-400 transition">Xem tất cả &rarr;</a>
        </div>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($posts->take(3) as $post)
            <article class="overflow-hidden rounded-lg bg-gray-800 transition hover:bg-gray-750">
                @if($post->thumbnail)
                <a href="{{ $post->url }}" class="block aspect-video overflow-hidden">
                    <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}"
                         loading="lazy" class="h-full w-full object-cover transition hover:scale-105">
                </a>
                @endif
                <div class="p-4">
                    <h3 class="mb-2 text-lg font-semibold hover:text-yellow-400 transition">
                        <a href="{{ $post->url }}">{{ $post->title }}</a>
                    </h3>
                    @if($post->excerpt)
                    <p class="mb-3 text-sm text-gray-400 line-clamp-2">{{ $post->excerpt }}</p>
                    @endif
                    <div class="text-xs text-gray-500">
                        {{ $post->published_at?->format('d/m/Y') }}
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
