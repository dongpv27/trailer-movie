@extends('layouts.app')

@php
    $canonicalUrl = route('category.released');
@endphp

@section('schemas')
    <!-- Schema.org CollectionPage for Phim Đang Chiếu -->
    <script type="application/ld+json">
    @if($movies->isNotEmpty())
    {!! \App\Helpers\SeoHelper::collectionSchema(
        'Phim Đang Chiếu',
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
            'Phim Đang Chiếu' => $canonicalUrl
        ]) !!}
    </script>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- H1 Heading -->
    <h1 class="text-3xl font-bold mb-6">Trailer phim đang chiếu</h1>

    <!-- Intro SEO (200-300 chữ) -->
    <div class="bg-gray-800 rounded-lg p-6 mb-10">
        <p class="text-gray-300 leading-relaxed mb-4">
            Trang <strong>Phim Đang Chiếu</strong> tổng hợp những bộ phim đang có mặt tại các rạp chiếu, được khán giả quan tâm và thảo luận sôi nổi. Đây là nơi tập hợp các trailer chính thức của những tác phẩm điện ảnh đang tạo được sức hút lớn trên màn ảnh rộng.
        </p>
        <p class="text-gray-300 leading-relaxed mb-4">
            Thông qua <em>trailer phim đang chiếu</em>, người xem có thể nhanh chóng đánh giá về nội dung, chất lượng phim trước khi quyết định mua vé. Việc xem trailer giúp bạn có cái nhìn khách quan, tránh lãng phí thời gian và tiền bạc cho những bộ phim không phù hợp với sở thích của mình.
        </p>
        <p class="text-gray-300 leading-relaxed">
            Tại TrailerPhim, tất cả trailer đều là video chính thức từ nhà phát hành, đảm bảo chất lượng hình ảnh và âm thanh tốt nhất. Chúng tôi cam kết chỉ cung cấp trailer giới thiệu, không cung cấp phim full, đảm bảo tuân thủ quy định bản quyền.
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
                Xem phim sắp chiếu
            </a>
        </div>
    </div>

    <!-- Danh sách phim đang chiếu -->
    @if($movies->isNotEmpty())
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6 flex items-center">
            <span class="w-2 h-8 bg-red-600 rounded mr-3"></span>
            Danh sách phim đang chiếu
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
        <p class="text-gray-400">Không có phim đang chiếu nào.</p>
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
