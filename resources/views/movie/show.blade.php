@extends('layouts.app')

@php
    $releaseYear = $movie->release_date ? $movie->release_date->format('Y') : ($movie->year ?? '');
    $seoTitle = "Trailer phim {$movie->title}" . ($releaseYear ? " ({$releaseYear})" : '') . " – Trailer chính thức";
    $seoDescription = "Xem trailer phim {$movie->title}" . ($releaseYear ? " ({$releaseYear})" : '') . " chính thức. Cập nhật nội dung, thể loại, thời gian chiếu và thông tin mới nhất.";
    $canonicalUrl = $movie->url;
    $ogImage = $movie->backdrop_url ?: $movie->poster_url;
@endphp

@push('schemas')
<script type="application/ld+json">
    {!! \App\Helpers\SeoHelper::movieSchema($movie) !!}
</script>

<script type="application/ld+json">
    {!! \App\Helpers\SeoHelper::breadcrumbListSchema([
        'Trang chủ' => route('home'),
        $movie->title => $movie->url
    ]) !!}
</script>
@endpush

@section('content')
<!-- Breadcrumb -->
<nav class="container mx-auto px-4 py-4 text-sm text-gray-400">
    <ol class="flex items-center gap-2" itemscope itemtype="https://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="{{ route('home') }}" class="hover:text-white transition" itemprop="item">
                <span itemprop="name">Trang chủ</span>
            </a>
            <meta itemprop="position" content="1" />
        </li>
        <li class="text-gray-600">/</li>
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <span class="text-white" itemprop="name">{{ $movie->title }}</span>
            <meta itemprop="position" content="2" />
        </li>
    </ol>
</nav>

<!-- Movie Detail -->
<div class="container mx-auto px-4 py-8">
    <!-- H1 -->
    <h1 class="mb-6 text-3xl font-bold">Trailer phim {{ $movie->title }}{{ $releaseYear ? " ({$releaseYear})" : '' }}</h1>

    <div class="grid gap-8 lg:grid-cols-3">
        <!-- Left Column - Trailer & Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Official Trailer Section -->
            @if($movie->trailers->isNotEmpty())
            <section>
                <h2 class="mb-4 text-2xl font-bold flex items-center">
                    <span class="w-2 h-8 bg-yellow-500 rounded mr-3"></span>
                    Official Trailer
                </h2>
                <div class="space-y-4">
                    @foreach($movie->trailers as $trailer)
                    <div class="rounded-lg overflow-hidden bg-gray-800">
                        <x-youtube-embed :trailer="$trailer" />
                        @if($trailer->title && $trailer->title !== 'Official Trailer')
                        <p class="p-3 text-gray-300">{{ $trailer->title }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Info Box -->
            <section class="rounded-lg bg-gray-800 p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-400">Năm phát hành</span>
                        <p class="font-semibold">{{ $releaseYear ?: 'Đang cập nhật' }}</p>
                    </div>
                    @if($movie->duration)
                    <div>
                        <span class="text-gray-400">Thời lượng</span>
                        <p class="font-semibold">{{ $movie->duration }} phút</p>
                    </div>
                    @endif
                    @if($movie->country)
                    <div>
                        <span class="text-gray-400">Quốc gia</span>
                        <p class="font-semibold">{{ $movie->country }}</p>
                    </div>
                    @endif
                    <div>
                        <span class="text-gray-400">Lượt xem</span>
                        <p class="font-semibold">{{ number_format($movie->view_count) }}</p>
                    </div>
                </div>

                <!-- Director & Cast -->
                @if($movie->director || $movie->cast)
                <div class="mt-4 grid md:grid-cols-2 gap-4 text-sm">
                    @if($movie->director)
                    <div>
                        <span class="text-gray-400">Đạo diễn</span>
                        <p class="font-semibold">{{ $movie->director }}</p>
                    </div>
                    @endif
                    @if($movie->cast)
                    <div>
                        <span class="text-gray-400">Diễn viên</span>
                        <p class="font-semibold">{{ $movie->cast }}</p>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Genres -->
                @if($movie->genres->isNotEmpty())
                <div class="mt-4">
                    <span class="text-gray-400 text-sm">Thể loại: </span>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($movie->genres as $genre)
                        <a href="{{ route('category.genre', $genre->slug) }}" class="rounded bg-yellow-500/20 px-3 py-1 text-sm text-yellow-400 hover:bg-yellow-500/30 transition">
                            {{ $genre->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Countries -->
                @if($movie->countries->isNotEmpty())
                <div class="mt-4">
                    <span class="text-gray-400 text-sm">Quốc gia: </span>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($movie->countries as $country)
                        <a href="{{ route('category.country', $country->slug) }}" class="rounded bg-gray-700 px-3 py-1 text-sm hover:bg-gray-600 transition">
                            {{ $country->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </section>

            <!-- H2: Nội dung phim -->
            <section class="rounded-lg bg-gray-800 p-6">
                <h2 class="mb-4 text-xl font-bold">Nội dung phim {{ $movie->title }}</h2>
                @if($movie->content)
                <p class="text-gray-300 leading-relaxed">{!! $movie->content !!}</p>
                @elseif($movie->description)
                <p class="text-gray-300 leading-relaxed">{{ $movie->description }}</p>
                @else
                <p class="text-gray-300 leading-relaxed">
                    {{ $movie->title }}{{ $movie->original_title ? " ({$movie->original_title})" : '' }} là một bộ phim{{ $movie->country ? " sản xuất từ {$movie->country}" : '' }}{{ $movie->genres->isNotEmpty() ? " thuộc thể loại " . $movie->genres->pluck('name')->join(', ') : '' }}. Phim mang đến những trải nghiệm thú vị cho khán giả với nội dung hấp dẫn và dàn diễn viên tài năng.
                </p>
                @endif
            </section>

            <!-- H2: Thông tin phát hành -->
            <section class="rounded-lg bg-gray-800 p-6">
                <h2 class="mb-4 text-xl font-bold">Thông tin phát hành phim {{ $movie->title }}</h2>
                <div class="space-y-3 text-gray-300">
                    @if($movie->release_date)
                    <p><strong>Thời gian khởi chiếu:</strong> {{ $movie->release_date->format('d/m/Y') }}</p>
                    @endif
                    <p>
                        <strong>Trạng thái:</strong>
                        @if($movie->status === 'upcoming')
                            <span class="ml-2 rounded bg-yellow-600/20 px-2 py-1 text-yellow-400 text-sm">Sắp chiếu</span>
                        @elseif($movie->status === 'released')
                            <span class="ml-2 rounded bg-green-600/20 px-2 py-1 text-green-400 text-sm">Đang chiếu</span>
                        @elseif($movie->status === 'hot')
                            <span class="ml-2 rounded bg-red-600/20 px-2 py-1 text-red-400 text-sm">Hot</span>
                        @endif
                    </p>
                    @if($movie->country)
                    <p><strong>Phát hành tại:</strong> {{ $movie->country }}</p>
                    @endif
                </div>
            </section>

            <!-- H2: Có gì đáng chú ý -->
            <section class="rounded-lg bg-gray-800 p-6">
                <h2 class="mb-4 text-xl font-bold">Phim {{ $movie->title }} có gì đáng chú ý?</h2>
                @if($movie->notable_points)
                <p class="text-gray-300 leading-relaxed">{!! $movie->notable_points !!}</p>
                @else
                <p class="text-gray-300 leading-relaxed">
                    @if($movie->status === 'hot')
                        {{ $movie->title }} là một trong những bộ phim được mong chờ nhất{{ $releaseYear ? " năm {$releaseYear}" : '' }}. Phim thu hút sự quan tâm đặc biệt từ khán giả nhờ vào nội dung hấp dẫn và yếu tố đổi mới.
                    @elseif($movie->status === 'upcoming')
                        {{ $movie->title }} đang được khán giả vô cùng mong chờ. Trailer chính thức đã được công bố, cho thấy những hình ảnh ấn tượng về bộ phim.
                    @else
                        {{ $movie->title }} đã và đang tạo được sức hút lớn{{ $movie->country ? " tại {$movie->country}" : '' }}. Đây là tác phẩm nằm trong danh sách những phim đáng xem{{ $releaseYear ? " năm {$releaseYear}" : '' }}.
                    @endif
                </p>
                @endif
            </section>

            <!-- H2: FAQ -->
            <section class="rounded-lg bg-gray-800 p-6">
                <h2 class="mb-4 text-xl font-bold">Câu hỏi thường gặp về phim {{ $movie->title }}</h2>
                <div class="space-y-4">
                    @if($movie->faq && is_array($movie->faq) && count($movie->faq) > 0)
                        @foreach($movie->faq as $item)
                        <div>
                            <h3 class="font-semibold text-white mb-2">{{ $item['question'] ?? '' }}</h3>
                            <p class="text-gray-300">{{ $item['answer'] ?? '' }}</p>
                        </div>
                        @endforeach
                    @else
                    <div>
                        <h3 class="font-semibold text-white mb-2">Phim {{ $movie->title }} khi nào chiếu?</h3>
                        <p class="text-gray-300">
                        @if($movie->release_date)
                            Phim khởi chiếu vào {{ $movie->release_date->format('d/m/Y') }}.
                        @else
                            Thời gian chiếu cụ thể sẽ được cập nhật khi có thông tin chính thức từ nhà phát hành.
                        @endif
                    </p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-white mb-2">Trailer phim {{ $movie->title }} đã ra chưa?</h3>
                        <p class="text-gray-300">
                        @if($movie->trailers->isNotEmpty())
                            Có, trailer chính thức của {{ $movie->title }} đã được công bố. Bạn có thể xem trailer ngay trên trang này.
                        @else
                            Trailer chính thức sẽ được cập nhật ngay khi nhà phát hành công bố.
                        @endif
                    </p>
                    </div>
                    @if($movie->genres->isNotEmpty())
                    <div>
                        <h3 class="font-semibold text-white mb-2">Phim {{ $movie->title }} thuộc thể loại gì?</h3>
                        <p class="text-gray-300">{{ $movie->title }} thuộc thể loại: {{ $movie->genres->pluck('name')->join(', ') }}.</p>
                    </div>
                    @endif
                    @endif
                </div>
            </section>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="space-y-6">
            <!-- Poster -->
            <div class="rounded-lg bg-gray-800 overflow-hidden">
                <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }} - Poster"
                     class="w-full h-auto">
            </div>

            <!-- Streaming Info -->
            <x-streaming-info :movie="$movie" />

            <!-- Internal Links -->
            <nav class="rounded-lg bg-gray-800 p-4" aria-label="Điều hướng">
                <h3 class="mb-3 font-semibold">Khám phá thêm</h3>
                <div class="space-y-2">
                    <a href="{{ route('movie.hot') }}" class="block px-3 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                        🎬 Phim Hot
                    </a>
                    @if($movie->status === 'upcoming')
                    <a href="{{ route('category.upcoming') }}" class="block px-3 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                        ⏰ Phim Sắp Chiếu
                    </a>
                    @else
                    <a href="{{ route('category.released') }}" class="block px-3 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                        🎞️ Phim Đang Chiếu
                    </a>
                    @endif
                    @if($movie->genres->isNotEmpty())
                    <a href="{{ route('category.genre', $movie->genres->first()->slug) }}" class="block px-3 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                        🎭 {{ $movie->genres->first()->name }}
                    </a>
                    @endif
                </div>
            </nav>

            <!-- Share -->
            <div class="rounded-lg bg-gray-800 p-4">
                <h3 class="mb-3 font-semibold">Chia sẻ:</h3>
                <div class="flex gap-2">
                    <button onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={{ urlencode($movie->url) }}', '_blank')"
                            class="flex h-10 w-10 items-center justify-center rounded bg-blue-600 hover:bg-blue-700 transition"
                            aria-label="Chia sẻ Facebook">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </button>
                    <button onclick="window.open('https://twitter.com/intent/tweet?url={{ urlencode($movie->url) }}&text={{ urlencode("Trailer {$movie->title} - Xem trailer chính thức") }}', '_blank')"
                            class="flex h-10 w-10 items-center justify-center rounded bg-sky-500 hover:bg-sky-600 transition"
                            aria-label="Chia sẻ Twitter">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Movies -->
    @if(isset($relatedMovies) && $relatedMovies->isNotEmpty())
    <section class="mt-12">
        <h2 class="mb-6 text-2xl font-bold flex items-center">
            <span class="w-2 h-8 bg-yellow-500 rounded mr-3"></span>
            Phim liên quan
        </h2>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            @foreach($relatedMovies as $relatedMovie)
            <x-movie-card :movie="$relatedMovie" />
            @endforeach
        </div>
        <div class="mt-4">
            <a href="{{ route('movie.hot') }}" class="inline-flex items-center text-yellow-400 hover:text-yellow-400 transition">
                Xem thêm phim hot &rarr;
            </a>
        </div>
    </section>
    @endif
</div>
@endsection
