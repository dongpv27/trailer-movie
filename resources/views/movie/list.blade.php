@extends('layouts.app')

@php
    $seoTitle = $seoTitle ?? ($title ?? 'Danh sách phim');
    $seoDescription = $seoDescription ?? ($description ?? 'Danh sách phim tại TrailerPhim');
    $canonicalUrl = request()->url();
@endphp

@section('schemas')
    <!-- Schema.org CollectionPage -->
    <script type="application/ld+json">
    @if($movies->isNotEmpty())
    {!! \App\Helpers\SeoHelper::collectionSchema(
        $title ?? 'Danh sách phim',
        $canonicalUrl,
        $movies->map(fn($m) => [
            'name' => $m->title,
            'url' => route('movie.show', $m->slug),
            'image' => $m->poster_url,
        ])->toArray()
    ) !!}
    @endif
    </script>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- H1 Heading -->
    <h1 class="text-3xl font-bold mb-6">
        @if(isset($query))
            Tìm kiếm: "{{ $query }}"
        @else
            {{ $title ?? 'Danh sách phim' }}
        @endif
    </h1>

    <!-- Search Results Info -->
    @if(isset($query) && $movies->isNotEmpty())
    <p class="text-gray-400 mb-6">
        Tìm thấy {{ $movies->total() }} kết quả cho từ khóa "<strong class="text-white">{{ $query }}</strong>"
    </p>
    @endif

    <!-- Intro SEO (200-300 chữ) -->
    <div class="bg-gray-800 rounded-lg p-6 mb-10">
        <p class="text-gray-300 leading-relaxed mb-4">
            @if(isset($description))
            {{ $description }}
            @else
            Danh sách này tổng hợp các bộ phim có tại TrailerPhim. Tất cả trailer đều là video chính thức từ nhà phát hành, giúp bạn có cái nhìn tổng quan về nội dung phim trước khi quyết định xem.
            @endif
        </p>
        <p class="text-gray-300 leading-relaxed mb-4">
            Việc xem <em>trailer phim</em> trước giúp bạn tiết kiệm thời gian và chọn được những bộ phim phù hợp với sở thích của mình. TrailerPhim cam kết chỉ cung cấp trailer chính thức, đảm bảo chất lượng hình ảnh và âm thanh tốt nhất.
        </p>
        <p class="text-gray-300 leading-relaxed">
            Tất cả video đều được cập nhật liên tục khi có trailer mới từ các nhà phát hành, giúp bạn không bỏ lỡ bất kỳ thông tin nào về những bộ phim đang được quan tâm.
        </p>

        <!-- Internal Links -->
        <div class="flex flex-wrap gap-3 mt-6">
            <a href="{{ route('movie.hot') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Phim Hot
            </a>
            <a href="{{ route('category.upcoming') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Sắp chiếu
            </a>
            <a href="{{ route('category.released') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197 2.132a1 1 0 001.555-.832V9.87a1 1 0 00-1.555-.832z"/>
                </svg>
                Đang chiếu
            </a>
        </div>
    </div>

    <!-- Danh sách phim -->
    @if($movies->isNotEmpty())
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6 flex items-center">
            <span class="w-2 h-8 bg-yellow-500 rounded mr-3"></span>
            {{ $title ?? 'Danh sách phim' }}
        </h2>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            @foreach($movies as $movie)
            <a href="{{ route('movie.show', $movie->slug) }}" class="group">
                <div class="relative overflow-hidden rounded-lg bg-gray-800 hover:bg-gray-750 transition">
                    <!-- Poster -->
                    <div class="aspect-[2/3] overflow-hidden">
                        <img src="{{ $movie->poster_url }}"
                             alt="{{ $movie->title }} - Trailer chính thức"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>

                    <!-- Info -->
                    <div class="p-3">
                        <h3 class="font-semibold text-sm line-clamp-2 group-hover:text-yellow-400 transition">
                            {{ $movie->title }}
                            @if($movie->release_date && $movie->release_date->year)
                            <span class="text-gray-500 text-xs">({{ $movie->release_date->year }})</span>
                            @endif
                        </h3>
                        @if($movie->description)
                        <p class="text-gray-400 text-xs mt-1 line-clamp-2">
                            {{ Str::limit(strip_tags($movie->description), 80) }}
                        </p>
                        @endif
                        <p class="text-gray-500 text-xs mt-2">
                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ number_format($movie->view_count) }} lượt xem
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $movies->appends(request()->query())->links() }}
    </div>
    @else
    <div class="rounded-lg bg-gray-800 p-8 text-center">
        @if(isset($query))
        <svg class="w-16 h-16 mx-auto mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <h3 class="text-xl font-semibold mb-2">Không tìm thấy kết quả nào</h3>
        <p class="text-gray-400 mb-4">
            Không tìm thấy phim nào với từ khóa "<strong class="text-white">{{ $query }}</strong>"
        </p>
        <p class="text-gray-500 text-sm mb-6">Gợi ý: Thử tìm kiếm với tên phim khác, tên diễn viên, đạo diễn, thể loại hoặc năm phát hành.</p>

        {{-- Suggestions when no results found --}}
        @if(isset($suggestions))
            {{-- Hot Movies Suggestions --}}
            @if($suggestions['hotMovies']->isNotEmpty())
            <div class="mt-8 text-left">
                <h4 class="text-lg font-semibold mb-4 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    Phim Hot đang được quan tâm
                </h4>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-6">
                    @foreach($suggestions['hotMovies'] as $movie)
                    <a href="{{ route('movie.show', $movie->slug) }}" class="group">
                        <div class="relative overflow-hidden rounded-lg bg-gray-700 hover:bg-gray-600 transition">
                            <div class="aspect-[2/3] overflow-hidden">
                                <img src="{{ $movie->poster_url }}"
                                     alt="{{ $movie->title }}"
                                     loading="lazy"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </div>
                            <div class="p-2">
                                <h5 class="font-medium text-xs line-clamp-2 group-hover:text-yellow-400 transition">
                                    {{ $movie->title }}
                                </h5>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Popular Genres Suggestions --}}
            @if($suggestions['popularGenres']->isNotEmpty())
            <div class="mt-8 text-left">
                <h4 class="text-lg font-semibold mb-4 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Thể loại phổ biến
                </h4>
                <div class="flex flex-wrap justify-center gap-2">
                    @foreach($suggestions['popularGenres'] as $genre)
                    <a href="{{ route('category.genre', $genre->slug) }}"
                       class="inline-flex items-center px-3 py-1.5 bg-gray-700 hover:bg-yellow-600 rounded-lg transition text-sm">
                        {{ $genre->name }}
                        <span class="ml-1.5 text-xs text-gray-400">({{ number_format($genre->movies_count) }})</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        @endif
        @else
        <p class="text-gray-400">Không có phim nào.</p>
        @endif
    </div>
    @endif

    <!-- Bottom Internal Links -->
    <nav class="bg-gray-800 rounded-lg p-6" aria-label="Điều hướng">
        <h3 class="font-semibold mb-4">Khám phá thêm</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('movie.hot') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                Phim Hot
            </a>
            <a href="{{ route('category.upcoming') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                Phim sắp chiếu
            </a>
            <a href="{{ route('category.released') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                Phim đang chiếu
            </a>
            <a href="{{ route('post.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                Tin điện ảnh
            </a>
        </div>
    </nav>
</div>
@endsection
