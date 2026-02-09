@extends('layouts.app')

@php
    $categoryType = $category->type ?? 'genre';
    $categoryName = $category->name;

    // SEO Title đầy đủ theo template
    $seoTitle = "Trailer phim {$categoryName} – Trailer chính thức mới nhất";
    $seoDescription = "Tổng hợp trailer phim {$categoryName} mới nhất, gồm phim sắp chiếu và đang chiếu. Cập nhật trailer chính thức nhanh chóng.";

    // Intro SEO 200-300 chữ theo template
    if ($categoryType === 'genre') {
        $seoIntro = "Danh mục <strong>trailer phim {$categoryName}</strong> tổng hợp các video giới thiệu chính thức thuộc dòng phim {$categoryName}. Phim {$categoryName} là một trong những thể loại được yêu thích nhất, với những đặc trưng riêng biệt mang lại trải nghiệm thú vị cho khán giả.";
        $seoIntro2 = "Tại đây, bạn có thể theo dõi <em>trailer phim {$categoryName}</em> mới nhất, từ những bom tấn sắp công chiếu đến các bộ phim đang hot. Việc xem trailer trước giúp bạn có cái nhìn tổng quan về nội dung, chất lượng phim trước khi quyết định xem phim đầy đủ.";
        $seoIntro3 = "TrailerPhim cam kết chỉ cung cấp trailer chính thức từ nhà phát hành, đảm bảo chất lượng hình ảnh và âm thanh tốt nhất. Tất cả video đều được cập nhật liên tục khi có trailer mới.";
    } elseif ($categoryType === 'country') {
        $seoIntro = "Danh mục <strong>trailer phim {$categoryName}</strong> tổng hợp các bộ phim sản xuất từ {$categoryName}, từ những bom tấn điện ảnh đến các tác phẩm độc lập đột phá. Phim {$categoryName} ngày càng khẳng định vị thế trên bản đồ điện ảnh thế giới với nhiều tác phẩm chất lượng.";
        $seoIntro2 = "Tại đây, bạn có thể theo dõi <em>trailer phim {$categoryName}</em> mới nhất, nắm bắt thông tin về các bộ phim sắp ra mắt và đang gây sốt. Việc xem trailer trước giúp bạn chọn được những bộ phim phù hợp với gu thẩm mỹ của mình.";
        $seoIntro3 = "TrailerPhim cập nhật liên tục các trailer chính thức từ {$categoryName}, giúp khán giả Việt Nam tiếp cận nhanh chóng với những tác phẩm điện ảnh nổi tiếng.";
    } elseif ($categoryType === 'year') {
        $seoIntro = "Danh sách <strong>trailer phim năm {$categoryName}</strong>, tổng hợp những bộ phim đáng chú ý đã ra mắt trong năm. Đây là nơi tập hợp các trailer chính thức của những tác phẩm điện ảnh đã tạo được tiếng vang lớn.";
        $seoIntro2 = "Tại đây, bạn có thể xem lại <em>trailer phim {$categoryName}</em> và nắm bắt thông tin về những cột mốc điện ảnh quan trọng. Năm {$categoryName} đã mang đến cho khán giả nhiều bộ phim đáng nhớ với nội dung phong phú và phong cách diễn xuất ấn tượng.";
        $seoIntro3 = "TrailerPhim tổng hợp đầy đủ các trailer chính thức, giúp bạn dễ dàng lựa chọn và theo dõi những bộ phim yêu thích trong năm {$categoryName}.";
    } else {
        $seoIntro = "Danh mục <strong>trailer phim {$categoryName}</strong> tổng hợp các video giới thiệu chính thức. Đây là nơi tập hợp những trailer chất lượng cao thuộc danh mục này.";
        $seoIntro2 = "Tại đây, bạn có thể theo dõi <em>trailer phim {$categoryName}</em> mới nhất, nắm bắt thông tin về các bộ phim sắp ra mắt và đang hot.";
        $seoIntro3 = "TrailerPhim cam kết chỉ cung cấp trailer chính thức từ nhà phát hành, đảm bảo chất lượng tốt nhất.";
    }

    $canonicalUrl = $category->url;
@endphp

@section('schemas')
    <!-- Schema.org CollectionPage for Category -->
    <script type="application/ld+json">
    @if($movies->isNotEmpty())
    {!! \App\Helpers\SeoHelper::collectionSchema(
        'Trailer phim ' . $categoryName,
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
            $category->name => $canonicalUrl
        ]) !!}
    </script>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- H1 Heading -->
    <h1 class="text-3xl font-bold mb-6">Trailer phim {{ $categoryName }}</h1>

    <!-- Intro SEO (200-300 chữ) -->
    <div class="bg-gray-800 rounded-lg p-6 mb-10">
        <p class="text-gray-300 leading-relaxed mb-4">
            {!! $seoIntro !!}
        </p>
        <p class="text-gray-300 leading-relaxed mb-4">
            {!! $seoIntro2 !!}
        </p>
        <p class="text-gray-300 leading-relaxed">
            {!! $seoIntro3 !!}
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

    <!-- Danh sách phim theo danh mục -->
    @if($movies->isNotEmpty())
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6 flex items-center">
            <span class="w-2 h-8 bg-yellow-500 rounded mr-3"></span>
            Danh sách phim {{ $categoryName }}
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

    <!-- Pagination -->
    <div class="mt-8">
        {{ $movies->appends(request()->query())->links() }}
    </div>
    @else
    <div class="rounded-lg bg-gray-800 p-8 text-center">
        <p class="text-gray-400">Không có phim nào trong danh mục này.</p>
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
