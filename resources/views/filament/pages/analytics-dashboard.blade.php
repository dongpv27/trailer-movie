<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header with Date Range Selector -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    Thống kê truy cập
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    @if($dateRange == '7')
                        7 ngày gần nhất
                    @elseif($dateRange == '30')
                        30 ngày gần nhất
                    @else
                        90 ngày gần nhất
                    @endif
                </p>
            </div>
            <div class="flex gap-2">
                @foreach([7, 30, 90] as $days)
                    <button
                        wire:click="setDateRange('{{ $days }}')"
                        @class($dateRange == $days
                            ? 'bg-amber-600 text-white ring-2 ring-amber-600 ring-offset-2 dark:ring-offset-gray-900'
                            : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700')
                        class="px-4 py-2 rounded-lg text-sm font-medium transition"
                    >
                        {{ $days }} ngày
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Page Views -->
            <div class="relative bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 shadow-lg overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <span class="text-blue-100 text-sm font-medium">Lượt truy cập</span>
                    </div>
                    <p class="text-3xl font-bold text-white">{{ number_format($stats['pageViews'] ?? 0) }}</p>
                    <p class="text-blue-100 text-sm mt-1">Tổng số lượt xem</p>
                </div>
            </div>

            <!-- Unique Visitors -->
            <div class="relative bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-6 shadow-lg overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="text-emerald-100 text-sm font-medium">Khách truy cập</span>
                    </div>
                    <p class="text-3xl font-bold text-white">{{ number_format($stats['uniqueVisitors'] ?? 0) }}</p>
                    <p class="text-emerald-100 text-sm mt-1">Lượt duy nhất</p>
                </div>
            </div>

            <!-- Trailer Plays -->
            <div class="relative bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 shadow-lg overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-red-100 text-sm font-medium">Trailer plays</span>
                    </div>
                    <p class="text-3xl font-bold text-white">{{ number_format($stats['trailerPlays'] ?? 0) }}</p>
                    <p class="text-red-100 text-sm mt-1">Lượt xem trailer</p>
                </div>
            </div>

            <!-- Avg Per Day -->
            <div class="relative bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-6 shadow-lg overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <span class="text-amber-100 text-sm font-medium">Trung bình</span>
                    </div>
                    <p class="text-3xl font-bold text-white">{{ number_format($stats['avgViewsPerDay'] ?? 0) }}</p>
                    <p class="text-amber-100 text-sm mt-1">Lượt/ngày</p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Page Views Chart (Main) -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Xu hướng truy cập</h3>
                    <div class="flex items-center gap-4 text-sm">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">Truy cập</span>
                        </span>
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">Trailer</span>
                        </span>
                    </div>
                </div>
                <div class="h-72">
                    <canvas id="combinedChart"></canvas>
                </div>
            </div>

            <!-- Category Distribution Pie Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Phân loại truy cập</h3>
                <div class="h-56">
                    <canvas id="categoryChart"></canvas>
                </div>
                <div class="mt-4 space-y-2 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">Phim</span>
                        </span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $categoryStats['movies'] ?? 0 }}%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">Bài viết</span>
                        </span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $categoryStats['posts'] ?? 0 }}%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">Danh mục</span>
                        </span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $categoryStats['categories'] ?? 0 }}%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-gray-400"></span>
                            <span class="text-gray-600 dark:text-gray-400">Khác</span>
                        </span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $categoryStats['other'] ?? 0 }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Content Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Nội dung phổ biến nhất</h3>
                    <div class="flex gap-2">
                        <button onclick="showTab('movies')" id="tab-movies" class="tab-btn px-3 py-1.5 rounded-lg text-sm font-medium bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                            Top Phim
                        </button>
                        <button onclick="showTab('trailers')" id="tab-trailers" class="tab-btn px-3 py-1.5 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Top Trailer
                        </button>
                        <button onclick="showTab('posts')" id="tab-posts" class="tab-btn px-3 py-1.5 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Top Bài viết
                        </button>
                    </div>
                </div>
            </div>

            <!-- Movies Table -->
            <div id="content-movies" class="content-tab">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/50">
                                <th class="px-6 py-3 font-medium">#</th>
                                <th class="px-6 py-3 font-medium">Phim</th>
                                <th class="px-6 py-3 font-medium">Lượt xem</th>
                                <th class="px-6 py-3 font-medium text-right">Truy cập</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($topMovies as $index => $movie)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4">
                                        <span class="flex items-center justify-center w-8 h-8 rounded-full @if($index < 3) bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 @endif font-semibold">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            @if($movie['poster'])
                                                <img src="{{ $movie['poster'] }}" alt="{{ $movie['title'] }}" class="w-12 h-16 object-cover rounded-lg shadow-sm">
                                            @else
                                                <div class="w-12 h-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $movie['title'] }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $movie['slug'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span class="text-gray-700 dark:text-gray-300">{{ number_format($movie['view_count'] ?? 0) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ number_format($movie['visit_count'] ?? 0) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                            </svg>
                                            <p class="text-gray-500 dark:text-gray-400">Chưa có dữ liệu</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Trailers Table -->
            <div id="content-trailers" class="content-tab hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/50">
                                <th class="px-6 py-3 font-medium">#</th>
                                <th class="px-6 py-3 font-medium">Trailer</th>
                                <th class="px-6 py-3 font-medium">Phim</th>
                                <th class="px-6 py-3 font-medium text-right">Lượt xem</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($topTrailers as $index => $trailer)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4">
                                        <span class="flex items-center justify-center w-8 h-8 rounded-full @if($index < 3) bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 @endif font-semibold">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $trailer['title'] ?? 'Trailer' }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">YouTube ID: {{ $trailer['youtube_id'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $trailer['movie_title'] ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                            {{ number_format($trailer['play_count_period'] ?? 0) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-gray-500 dark:text-gray-400">Chưa có dữ liệu</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Posts Table -->
            <div id="content-posts" class="content-tab hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/50">
                                <th class="px-6 py-3 font-medium">#</th>
                                <th class="px-6 py-3 font-medium">Bài viết</th>
                                <th class="px-6 py-3 font-medium">Lượt xem</th>
                                <th class="px-6 py-3 font-medium text-right">Truy cập</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($this->topPosts as $index => $post)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4">
                                        <span class="flex items-center justify-center w-8 h-8 rounded-full @if($index < 3) bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 @endif font-semibold">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $post['title'] }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $post['slug'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ number_format($post['view_count'] ?? 0) }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                            {{ number_format($post['visit_count'] ?? 0) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                            </svg>
                                            <p class="text-gray-500 dark:text-gray-400">Chưa có dữ liệu</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bottom Stats Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Categories -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Top danh mục
                </h3>
                <div class="space-y-3">
                    @forelse($this->topCategories as $index => $category)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition">
                            <div class="flex items-center gap-3">
                                <span class="flex items-center justify-center w-7 h-7 rounded-full @if($index < 3) bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 @else bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-400 @endif text-xs font-bold">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $category['name'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $category['type'] == 'genre' ? 'Thể loại' : ($category['type'] == 'country' ? 'Quốc gia' : 'Năm') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-20 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-500 rounded-full" style="width: {{ min(100, ($category['visit_count'] ?? 0) * 100 / max(1, $this->topCategories[0]['visit_count'] ?? 1)) }}%"></div>
                                </div>
                                <span class="font-semibold text-amber-600 dark:text-amber-400 w-12 text-right">{{ number_format($category['visit_count'] ?? 0) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">Chưa có dữ liệu</p>
                    @endforelse
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Thống kê nhanh
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20">
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ \App\Models\Movie::count() }}</p>
                        <p class="text-sm text-blue-600/70 dark:text-blue-400/70">Tổng phim</p>
                    </div>
                    <div class="p-4 rounded-xl bg-red-50 dark:bg-red-900/20">
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ \App\Models\Trailer::count() }}</p>
                        <p class="text-sm text-red-600/70 dark:text-red-400/70">Tổng trailer</p>
                    </div>
                    <div class="p-4 rounded-xl bg-green-50 dark:bg-green-900/20">
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ \App\Models\Post::count() }}</p>
                        <p class="text-sm text-green-600/70 dark:text-green-400/70">Bài viết</p>
                    </div>
                    <div class="p-4 rounded-xl bg-purple-50 dark:bg-purple-900/20">
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ \App\Models\Category::count() }}</p>
                        <p class="text-sm text-purple-600/70 dark:text-purple-400/70">Danh mục</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#9ca3af' : '#6b7280';
            const gridColor = isDark ? 'rgba(156, 163, 175, 0.1)' : 'rgba(107, 114, 128, 0.1)';

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: textColor },
                        grid: { color: gridColor }
                    },
                    x: {
                        ticks: { color: textColor, maxTicksLimit: 10 },
                        grid: { display: false }
                    }
                }
            };

            const labels = @js($chartData['labels'] ?? []);

            // Combined Chart
            new Chart(document.getElementById('combinedChart'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Truy cập',
                            data: @js($chartData['pageViews'] ?? []),
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Trailer',
                            data: @js($chartData['trailerPlays'] ?? []),
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    ...chartOptions,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // Category Pie Chart
            const categoryData = @js($categoryStats ?? ['movies' => 40, 'posts' => 20, 'categories' => 25, 'other' => 15]);
            new Chart(document.getElementById('categoryChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Phim', 'Bài viết', 'Danh mục', 'Khác'],
                    datasets: [{
                        data: [categoryData.movies, categoryData.posts, categoryData.categories, categoryData.other],
                        backgroundColor: ['#3b82f6', '#22c55e', '#f59e0b', '#9ca3af'],
                        borderWidth: 0,
                        spacing: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });

        // Tab switching
        function showTab(tab) {
            // Hide all tabs
            document.querySelectorAll('.content-tab').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('bg-amber-100', 'text-amber-700', 'dark:bg-amber-900/30', 'dark:text-amber-400');
                el.classList.add('text-gray-600', 'dark:text-gray-400');
            });

            // Show selected tab
            document.getElementById('content-' + tab).classList.remove('hidden');
            const btn = document.getElementById('tab-' + tab);
            btn.classList.remove('text-gray-600', 'dark:text-gray-400');
            btn.classList.add('bg-amber-100', 'text-amber-700', 'dark:bg-amber-900/30', 'dark:text-amber-400');
        }
    </script>
</x-filament-panels::page>
