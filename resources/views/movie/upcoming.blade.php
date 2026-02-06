@extends('layouts.app')

@php
    $canonicalUrl = route('category.upcoming');
@endphp

@section('schemas')
    <!-- Schema.org CollectionPage for Phim Sắp Chiếu -->
    <script type="application/ld+json">
    @if($movies->isNotEmpty())
    {!! \App\Helpers\SeoHelper::collectionSchema(
        'Phim Sắp Chiếu',
        $canonicalUrl,
        $movies->map(fn($m) => [
            'name' => $m->title,
            'url' => route('movie.show', $m->slug),
            'image' => $m->poster_url,
        ])->toArray()
    ) !!}
    @endif
    </script>

    <script type="application/ld+json">
        {!! \App\Helpers\SeoHelper::breadcrumbListSchema([
            'Trang chủ' => route('home'),
            'Phim Sắp Chiếu' => $canonicalUrl
        ]) !!}
    </script>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- H1 Heading -->
    <h1 class="text-3xl font-bold mb-6">Trailer phim sắp chiếu</h1>

    <!-- Intro SEO (200-300 chữ) -->
    <div class="bg-gray-800 rounded-lg p-6 mb-10">
        <p class="text-gray-300 leading-relaxed mb-4">
            Danh mục <strong>Phim Sắp Chiếu</strong> tổng hợp các bộ phim đang được mong chờ nhất hiện nay. Đây là nơi tập hợp những tác phẩm điện ảnh chưa ra mắt nhưng đã tạo được sự quan tâm đặc biệt từ khán giả nhờ vào trailer ấn tượng, dàn diễn viên nổi tiếng và concept thú vị.
        </p>
        <p class="text-gray-300 leading-relaxed mb-4">
            Thông qua <em>trailer phim sắp chiếu</em>, người xem có thể nắm bắt sơ lược về nội dung, phong cách diễn xuất và chất lượng kỹ xảo của phim trước khi quyết định có nên xem khi phim chính thức công chiếu. Việc xem trailer không chỉ giúp tiết kiệm thời gian mà còn giúp bạn lựa chọn những bộ phim phù hợp với sở thích của mình.
        </p>
        <p class="text-gray-300 leading-relaxed">
            Tại TrailerPhim, tất cả trailer đều là video chính thức từ nhà phát hành, đảm bảo chất lượng hình ảnh và âm thanh tốt nhất. Chúng tôi cập nhật liên tục khi có trailer mới, giúp bạn không bỏ lỡ bất kỳ thông tin nào về những bộ phim sắp ra mắt.
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
            <a href="{{ route('category.released') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197 2.132a1 1 0 001.555-.832V9.87a1 1 0 00-1.555-.832z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Xem phim đang chiếu
            </a>
        </div>
    </div>

    <!-- Danh sách phim sắp chiếu -->
    @if($movies->isNotEmpty())
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6 flex items-center">
            <span class="w-2 h-8 bg-red-600 rounded mr-3"></span>
            Danh sách phim sắp chiếu
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
                        @if($movie->release_date)
                        <p class="text-red-500 text-xs mt-2">
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

    <!-- Pagination -->
    <div class="mt-8">
        {{ $movies->appends(request()->query())->links() }}
    </div>
    @else
    <div class="rounded-lg bg-gray-800 p-8 text-center">
        <p class="text-gray-400">Không có phim sắp chiếu nào.</p>
    </div>
    @endif

    <!-- Bottom Internal Links -->
    <nav class="bg-gray-800 rounded-lg p-6" aria-label="Điều hướng">
        <h3 class="font-semibold mb-4">Khám phá thêm</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('movie.hot') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                Phim Hot
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
