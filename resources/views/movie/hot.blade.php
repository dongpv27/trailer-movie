@extends('layouts.app')

@php
    $schemaItems = [];
    foreach($upcomingHot->merge($releasedHot) as $movie) {
        $schemaItems[] = [
            'name' => $movie->title,
            'url' => route('movie.show', $movie->slug),
            'image' => $movie->poster_url,
        ];
    }
    $schemaData = \App\Helpers\SeoHelper::collectionSchema(
        'Phim Hot',
        $canonicalUrl,
        $schemaItems
    );
@endphp

@section('schemas')
    <!-- Schema.org CollectionPage for Phim Hot -->
    <script type="application/ld+json">
        {!! $schemaData !!}
    </script>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- H1 Heading -->
    <h1 class="text-3xl font-bold mb-6">Trailer phim hot nhất hiện nay</h1>

    <!-- Intro SEO (200-300 chữ) -->
    <div class="bg-gray-800 rounded-lg p-6 mb-10">
        <p class="text-gray-300 leading-relaxed mb-4">
            Trang <strong>Phim Hot</strong> trên TrailerPhim tổng hợp các <strong>trailer phim chính thức</strong> đang được quan tâm nhiều nhất hiện nay. Danh sách bao gồm cả <strong>phim sắp chiếu</strong> và <strong>phim đang chiếu tại rạp</strong>, được cập nhật liên tục khi có trailer mới từ nhà phát hành.
        </p>
        <p class="text-gray-300 leading-relaxed mb-4">
            Tại đây, người xem có thể theo dõi nhanh <strong>trailer mới nhất</strong>, nắm được nội dung sơ lược, thể loại và thời gian phát hành của từng bộ phim mà không cần xem phim full, đảm bảo không vi phạm bản quyền.
        </p>
        <p class="text-gray-300 leading-relaxed">
            Các bộ phim trong danh sách Phim Hot được chọn lọc dựa trên mức độ quan tâm của khán giả, lượt tìm kiếm và độ nổi bật trên các nền tảng điện ảnh, giúp người xem dễ dàng cập nhật những bộ phim đáng chú ý nhất trong thời gian hiện tại.
        </p>

        <!-- Internal Links -->
        <div class="flex flex-wrap gap-3 mt-6">
            <a href="{{ route('category.upcoming') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Xem tất cả phim sắp chiếu
            </a>
            <a href="{{ route('category.released') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 001.555-.832V9.87a1 1 0 00-1.555-.832z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Xem phim đang chiếu
            </a>
        </div>
    </div>

    <!-- Section 1: Phim Hot Sắp Chiếu -->
    @if($upcomingHot->isNotEmpty())
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6 flex items-center">
            <span class="w-2 h-8 bg-yellow-500 rounded mr-3"></span>
            Trailer phim hot sắp chiếu
        </h2>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            @foreach($upcomingHot as $movie)
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
                        @if($movie->release_date)
                        <p class="text-yellow-400 text-xs mt-2">
                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $movie->release_date->format('d/m/Y') }}
                        </p>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Section 2: Phim Hot Đang Chiếu -->
    @if($releasedHot->isNotEmpty())
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6 flex items-center">
            <span class="w-2 h-8 bg-yellow-500 rounded mr-3"></span>
            Trailer phim đang chiếu được quan tâm
        </h2>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            @foreach($releasedHot as $movie)
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
    @endif

    <!-- Section 3: Phim Hot Theo Thể Loại -->
    @if($hotGenres->isNotEmpty())
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6 flex items-center">
            <span class="w-2 h-8 bg-yellow-500 rounded mr-3"></span>
            Trailer phim hot theo thể loại
        </h2>

        @foreach($hotGenres as $genre)
        @if($genre->movies->isNotEmpty())
        <div class="mb-8 last:mb-0">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold">{{ $genre->name }}</h3>
                <a href="{{ route('category.genre', $genre->slug) }}" class="text-yellow-400 hover:text-yellow-400 text-sm transition">
                    Xem tất cả &rarr;
                </a>
            </div>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                @foreach($genre->movies as $movie)
                <a href="{{ route('movie.show', $movie->slug) }}" class="group">
                    <div class="relative overflow-hidden rounded-lg bg-gray-800 hover:bg-gray-750 transition">
                        <div class="aspect-[2/3] overflow-hidden">
                            <img src="{{ $movie->poster_url }}"
                                 alt="{{ $movie->title }} - Trailer {{ $genre->name }}"
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <div class="p-3">
                            <h4 class="font-semibold text-sm line-clamp-2 group-hover:text-yellow-400 transition">
                                {{ $movie->title }}
                                @if($movie->release_date && $movie->release_date->year)
                                <span class="text-gray-500 text-xs">({{ $movie->release_date->year }})</span>
                                @endif
                            </h4>
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
        </div>
        @endif
        @endforeach
    </section>
    @endif

    <!-- Bottom Internal Links -->
    <nav class="bg-gray-800 rounded-lg p-6" aria-label="Điều hướng">
        <h3 class="font-semibold mb-4">Khám phá thêm</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('category.upcoming') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                Phim sắp chiếu
            </a>
            <a href="{{ route('category.released') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                Phim đang chiếu
            </a>
            <a href="{{ route('movie.top') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                Top phim xem nhiều
            </a>
            <a href="{{ route('post.index') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                Tin điện ảnh
            </a>
        </div>
    </nav>
</div>
@endsection
