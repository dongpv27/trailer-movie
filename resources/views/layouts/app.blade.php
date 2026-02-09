<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @if(isset($seoTitle))
    <title>{{ $seoTitle }} - TrailerPhim</title>
    @else
    <title>@yield('title', 'TrailerPhim') - Xem Trailer Phim Mới Nhất</title>
    @endif

    @if(isset($seoDescription))
    <meta name="description" content="{{ $seoDescription }}">
    @else
    <meta name="description" content="@yield('description', 'TrailerPhim - Xem trailer phim mới nhất, hot nhất, cập nhật liên tục. Tổng hợp trailer phim chiếu rạp, phim Netflix, phim HBO.')">
    @endif

    <link rel="canonical" href="{{ isset($canonicalUrl) ? $canonicalUrl : request()->url() }}">

    <!-- OpenGraph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ isset($canonicalUrl) ? $canonicalUrl : request()->url() }}">
    @isset($seoTitle)
    <meta property="og:title" content="{{ $seoTitle }}">
    @else
    <meta property="og:title" content="@yield('title', 'TrailerPhim')">
    @endisset
    @isset($seoDescription)
    <meta property="og:description" content="{{ $seoDescription }}">
    @else
    <meta property="og:description" content="@yield('description', 'TrailerPhim - Xem trailer phim mới nhất')">
    @endisset
    @isset($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
    @else
    <meta property="og:image" content="https://placehold.co/1200x630/1f2937/dc2626?text=TrailerPhim">
    @endisset
    <meta property="og:locale" content="vi_VN">
    <meta property="og:site_name" content="TrailerPhim">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    @isset($seoTitle)
    <meta name="twitter:title" content="{{ $seoTitle }}">
    @else
    <meta name="twitter:title" content="@yield('title', 'TrailerPhim')">
    @endisset
    @isset($seoDescription)
    <meta name="twitter:description" content="{{ $seoDescription }}">
    @else
    <meta name="twitter:description" content="@yield('description', 'TrailerPhim - Xem trailer phim mới nhất')">
    @endisset
    @isset($twitterImage)
    <meta name="twitter:image" content="{{ $twitterImage }}">
    @elseif(isset($ogImage))
    <meta name="twitter:image" content="{{ $ogImage }}">
    @else
    <meta name="twitter:image" content="https://placehold.co/1200x630/1f2937/dc2626?text=TrailerPhim">
    @endisset

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Schema.org WebSite -->
    <script type="application/ld+json">
        {!! \App\Helpers\SeoHelper::webSiteSchema() !!}
    </script>

    <!-- Schema.org Organization -->
    <script type="application/ld+json">
        {!! \App\Helpers\SeoHelper::organizationSchema() !!}
    </script>

    @stack('schemas')

    <!-- Additional scripts -->
    @stack('scripts')
</head>
<body class="bg-gray-900 text-gray-100 font-sans antialiased">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-gray-900/95 backdrop-blur border-b border-gray-800">
        <nav class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between gap-4">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
                    <svg class="w-10 h-10 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                    <span class="text-xl font-bold hidden sm:block">Trailer<span class="text-yellow-400">Phim</span></span>
                </a>

                <!-- Search Bar -->
                <div x-data="{
                    open: false,
                    searchQuery: '',
                    submitSearch() {
                        if (this.searchQuery.trim()) {
                            window.location.href = '{{ route('movie.search') }}?q=' + encodeURIComponent(this.searchQuery);
                        }
                    }
                }" class="flex-1 max-w-2xl">
                    <form @submit.prevent="submitSearch()" class="relative">
                        <input
                            type="text"
                            x-model="searchQuery"
                            placeholder="Tìm phim, diễn viên, đạo diễn, năm phát hành..."
                            class="w-full px-4 py-2 pl-10 pr-10 bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-400 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition"
                        >
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <button
                            type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 p-1 text-gray-400 hover:text-yellow-400 transition"
                            aria-label="Tìm kiếm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center gap-4 flex-shrink-0">
                    <a href="{{ route('home') }}" class="hover:text-yellow-400 transition text-sm">Trang chủ</a>
                    <a href="{{ route('movie.hot') }}" class="hover:text-yellow-400 transition text-sm">Phim Hot</a>
                    <a href="{{ route('category.upcoming') }}" class="hover:text-yellow-400 transition text-sm">Sắp chiếu</a>
                    <a href="{{ route('category.released') }}" class="hover:text-yellow-400 transition text-sm">Đang chiếu</a>
                    <a href="{{ route('post.index') }}" class="hover:text-yellow-400 transition text-sm">Tin điện ảnh</a>
                </div>

                <!-- Mobile Menu Button -->
                <button type="button" x-data="{ open: false }" @click="open = !open"
                    class="lg:hidden p-2 hover:bg-gray-800 rounded flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div x-data="{ open: false }" x-show="open" @click.away="open = false"
                class="lg:hidden mt-4 pb-4 border-t border-gray-800 pt-4 hidden">
                <div class="flex flex-col gap-3">
                    <a href="{{ route('home') }}" class="hover:text-yellow-400 transition">Trang chủ</a>
                    <a href="{{ route('movie.hot') }}" class="hover:text-yellow-400 transition">Phim Hot</a>
                    <a href="{{ route('category.upcoming') }}" class="hover:text-yellow-400 transition">Sắp chiếu</a>
                    <a href="{{ route('category.released') }}" class="hover:text-yellow-400 transition">Đang chiếu</a>
                    <a href="{{ route('post.index') }}" class="hover:text-yellow-400 transition">Tin điện ảnh</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Go to Top Button -->
    <button
        x-data="{
            show: false,
            scrollToTop() {
                window.scrollTo({ top: 0, behavior: 'smooth' })
            }
        }"
        x-show="show"
        @scroll.window="show = (window.pageYOffset > 300)"
        @click="scrollToTop()"
        class="fixed bottom-6 right-6 z-50 p-3 bg-yellow-500 hover:bg-yellow-600 text-gray-900 rounded-full shadow-lg transition-all duration-300"
        aria-label="Lên đầu trang"
        style="display: none;">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    <!-- Footer -->
    <footer class="bg-gray-800 mt-16 py-12 border-t border-gray-700">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        <span class="text-lg font-bold">Trailer<span class="text-yellow-400">Phim</span></span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Website xem trailer phim mới nhất, cập nhật liên tục. Tổng hợp trailer phim chiếu rạp, phim Netflix, HBO...
                    </p>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="font-semibold mb-4">Danh mục</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('movie.hot') }}" class="hover:text-white transition">Phim Hot</a></li>
                        <li><a href="{{ route('category.upcoming') }}" class="hover:text-white transition">Phim Sắp Chiếu</a></li>
                        <li><a href="{{ route('category.released') }}" class="hover:text-white transition">Phim Đang Chiếu</a></li>
                        <li><a href="{{ route('movie.top') }}" class="hover:text-white transition">Top Phim</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="font-semibold mb-4">Thể loại</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Hành động</a></li>
                        <li><a href="#" class="hover:text-white transition">Kinh dị</a></li>
                        <li><a href="#" class="hover:text-white transition">Hài hước</a></li>
                        <li><a href="#" class="hover:text-white transition">Tình cảm</a></li>
                    </ul>
                </div>

                <!-- Connect -->
                <div>
                    <h4 class="font-semibold mb-4">Liên kết</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('post.index') }}" class="hover:text-white transition">Tin điện ảnh</a></li>
                        <li><a href="/sitemap.xml" class="hover:text-white transition">Sitemap</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} TrailerPhim. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
