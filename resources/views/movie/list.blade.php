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
    <h1 class="text-3xl font-bold mb-6">{{ $title ?? 'Danh sách phim' }}</h1>

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
            <a href="{{ route('movie.hot') }}" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg transition">
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
            <span class="w-2 h-8 bg-red-600 rounded mr-3"></span>
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
                        <h3 class="font-semibold text-sm line-clamp-2 group-hover:text-red-500 transition">
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
        <p class="text-gray-400">Không có phim nào.</p>
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
