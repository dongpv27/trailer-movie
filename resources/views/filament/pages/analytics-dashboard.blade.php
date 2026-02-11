<x-filament-panels::page>
    <div class="space-y-4">
        <!-- Header with Date Range Selector -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                    Thống kê truy cập
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    @if($dateRange == '7')
                        7 ngày gần nhất
                    @elseif($dateRange == '30')
                        30 ngày gần nhất
                    @else
                        90 ngày gần nhất
                    @endif
                </p>
            </div>
            <div class="flex gap-1.5">
                @foreach([7, 30, 90] as $days)
                    <button
                        wire:click="setDateRange('{{ $days }}')"
                        @class($dateRange == $days
                            ? 'bg-amber-600 text-white ring-2 ring-amber-600 ring-offset-2 dark:ring-offset-gray-900'
                            : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700')
                        class="px-3 py-1.5 rounded-lg text-xs font-medium transition whitespace-nowrap"
                    >
                        {{ $days }} ngày
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Stats Overview - 6 Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2">
            <!-- Page Views -->
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-2.5 border border-blue-100 dark:border-blue-900/30">
                <p class="text-lg font-bold text-blue-600 dark:text-blue-400 leading-tight">{{ number_format($stats['pageViews'] ?? 0) }}</p>
                <p class="text-[9px] text-blue-600/70 dark:text-blue-400/70 mt-0.5">Lượt truy cập</p>
            </div>

            <!-- Unique Visitors -->
            <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-lg p-2.5 border border-emerald-100 dark:border-emerald-900/30">
                <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400 leading-tight">{{ number_format($stats['uniqueVisitors'] ?? 0) }}</p>
                <p class="text-[9px] text-emerald-600/70 dark:text-emerald-400/70 mt-0.5">Khách truy cập</p>
            </div>

            <!-- Trailer Plays -->
            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-2.5 border border-red-100 dark:border-red-900/30">
                <p class="text-lg font-bold text-red-600 dark:text-red-400 leading-tight">{{ number_format($stats['trailerPlays'] ?? 0) }}</p>
                <p class="text-[9px] text-red-600/70 dark:text-red-400/70 mt-0.5">Trailer plays</p>
            </div>

            <!-- Avg Per Day -->
            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-2.5 border border-amber-100 dark:border-amber-900/30">
                <p class="text-lg font-bold text-amber-600 dark:text-amber-400 leading-tight">{{ number_format($stats['avgViewsPerDay'] ?? 0) }}</p>
                <p class="text-[9px] text-amber-600/70 dark:text-amber-400/70 mt-0.5">Lượt/ngày</p>
            </div>

            <!-- Total Movies -->
            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-2.5 border border-purple-100 dark:border-purple-900/30">
                <p class="text-lg font-bold text-purple-600 dark:text-purple-400 leading-tight">{{ \App\Models\Movie::count() }}</p>
                <p class="text-[9px] text-purple-600/70 dark:text-purple-400/70 mt-0.5">Tổng phim</p>
            </div>

            <!-- Total Trailers -->
            <div class="bg-cyan-50 dark:bg-cyan-900/20 rounded-lg p-2.5 border border-cyan-100 dark:border-cyan-900/30">
                <p class="text-lg font-bold text-cyan-600 dark:text-cyan-400 leading-tight">{{ \App\Models\Trailer::count() }}</p>
                <p class="text-[9px] text-cyan-600/70 dark:text-cyan-400/70 mt-0.5">Tổng trailer</p>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
            <!-- Line Chart -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-xs font-semibold text-gray-900 dark:text-white">Xu hướng truy cập</h3>
                    <div class="flex items-center gap-3 text-[9px]">
                        <span class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">Truy cập</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">Trailer</span>
                        </span>
                    </div>
                </div>
                <div class="h-44">
                    <canvas id="combinedChart"></canvas>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-200 dark:border-gray-700">
                <h3 class="text-xs font-semibold text-gray-900 dark:text-white mb-2">Phân loại truy cập</h3>
                <div class="h-32">
                    <canvas id="categoryChart"></canvas>
                </div>
                <div class="mt-2 space-y-1 text-[9px]">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">Phim</span>
                        </span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $categoryStats['movies'] ?? 0 }}%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">Bài viết</span>
                        </span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $categoryStats['posts'] ?? 0 }}%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            <span class="text-gray-600 dark:text-gray-400">Danh mục</span>
                        </span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $categoryStats['categories'] ?? 0 }}%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                            <span class="text-gray-600 dark:text-gray-400">Khác</span>
                        </span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $categoryStats['other'] ?? 0 }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Tables Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <!-- Top Movies -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-3 py-2 border-b border-gray-200 dark:border-gray-700 bg-blue-50 dark:bg-blue-900/20">
                    <h3 class="text-xs font-semibold text-blue-700 dark:text-blue-400 flex items-center gap-1.5">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                        </svg>
                        Top Phim
                    </h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-64 overflow-y-auto">
                    @forelse($topMovies as $index => $movie)
                        <div class="p-2 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <div class="flex items-start gap-2">
                                <span class="flex items-center justify-center w-5 h-5 rounded-full flex-shrink-0 @if($index < 3) bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 @endif text-[10px] font-bold mt-0.5">
                                    {{ $index + 1 }}
                                </span>
                                @if($movie['poster'])
                                    <img src="{{ $movie['poster'] }}" alt="{{ $movie['title'] }}" class="w-8 h-12 object-cover rounded flex-shrink-0">
                                @else
                                    <div class="w-8 h-12 bg-gray-200 dark:bg-gray-700 rounded flex-shrink-0 flex items-center justify-center">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <p class="font-medium text-gray-900 dark:text-white text-[10px] leading-tight line-clamp-2">{{ $movie['title'] }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[9px] text-gray-500 dark:text-gray-400">{{ number_format($movie['visit_count'] ?? 0) }} truy cập</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center">
                            <p class="text-[10px] text-gray-500 dark:text-gray-400">Chưa có dữ liệu</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Top Trailers -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-3 py-2 border-b border-gray-200 dark:border-gray-700 bg-red-50 dark:bg-red-900/20">
                    <h3 class="text-xs font-semibold text-red-700 dark:text-red-400 flex items-center gap-1.5">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        Top Trailers
                    </h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-64 overflow-y-auto">
                    @forelse($topTrailers as $index => $trailer)
                        <div class="p-2 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <div class="flex items-start gap-2">
                                <span class="flex items-center justify-center w-5 h-5 rounded-full flex-shrink-0 @if($index < 3) bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 @endif text-[10px] font-bold mt-0.5">
                                    {{ $index + 1 }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="font-medium text-gray-900 dark:text-white text-[10px] leading-tight line-clamp-2">{{ $trailer['title'] ?? 'Trailer' }}</p>
                                    <p class="text-[9px] text-gray-500 dark:text-gray-400 mt-0.5 truncate">{{ $trailer['movie_title'] ?? '-' }}</p>
                                    <span class="text-[9px] text-gray-500 dark:text-gray-400">{{ number_format($trailer['play_count_period'] ?? 0) }} xem</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center">
                            <p class="text-[10px] text-gray-500 dark:text-gray-400">Chưa có dữ liệu</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Top Posts -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-3 py-2 border-b border-gray-200 dark:border-gray-700 bg-green-50 dark:bg-green-900/20">
                    <h3 class="text-xs font-semibold text-green-700 dark:text-green-400 flex items-center gap-1.5">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        Top Bài viết
                    </h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-64 overflow-y-auto">
                    @forelse($this->topPosts as $index => $post)
                        <div class="p-2 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <div class="flex items-start gap-2">
                                <span class="flex items-center justify-center w-5 h-5 rounded-full flex-shrink-0 @if($index < 3) bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 @endif text-[10px] font-bold mt-0.5">
                                    {{ $index + 1 }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="font-medium text-gray-900 dark:text-white text-[10px] leading-tight line-clamp-2">{{ $post['title'] }}</p>
                                    <span class="text-[9px] text-gray-500 dark:text-gray-400">{{ number_format($post['visit_count'] ?? 0) }} truy cập</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center">
                            <p class="text-[10px] text-gray-500 dark:text-gray-400">Chưa có dữ liệu</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Bottom Row: Categories + Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <!-- Top Categories -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-200 dark:border-gray-700">
                <h3 class="text-xs font-semibold text-gray-900 dark:text-white mb-2 flex items-center gap-1.5">
                    <svg width="20" height="20" class="text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Top danh mục
                </h3>
                <div class="space-y-1.5 max-h-40 overflow-y-auto">
                    @forelse($this->topCategories as $index => $category)
                        <div class="flex items-center justify-between p-1.5 rounded bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition">
                            <div class="flex items-center gap-1.5">
                                <span class="flex items-center justify-center w-4 h-4 rounded-full @if($index < 3) bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 @else bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-400 @endif text-[8px] font-bold">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white text-[10px]">{{ $category['name'] }}</p>
                                    <p class="text-[8px] text-gray-500 dark:text-gray-400">
                                        {{ $category['type'] == 'genre' ? 'Thể loại' : ($category['type'] == 'country' ? 'Quốc gia' : 'Năm') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-12 h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-500 rounded-full" style="width: {{ min(100, ($category['visit_count'] ?? 0) * 100 / max(1, $this->topCategories[0]['visit_count'] ?? 1)) }}%"></div>
                                </div>
                                <span class="font-semibold text-amber-600 dark:text-amber-400 w-8 text-right text-[9px]">{{ number_format($category['visit_count'] ?? 0) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 dark:text-gray-400 py-3 text-[10px]">Chưa có dữ liệu</p>
                    @endforelse
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-200 dark:border-gray-700">
                <h3 class="text-xs font-semibold text-gray-900 dark:text-white mb-2 flex items-center gap-1.5">
                    <svg width="20" height="20" class="text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Thống kê nhanh
                </h3>
                <div class="grid grid-cols-4 gap-2">
                    <div class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-center">
                        <p class="text-lg font-bold text-blue-600 dark:text-blue-400 leading-tight">{{ \App\Models\Movie::count() }}</p>
                        <p class="text-[9px] text-blue-600/70 dark:text-blue-400/70 mt-0.5">Phim</p>
                    </div>
                    <div class="p-2 rounded-lg bg-red-50 dark:bg-red-900/20 text-center">
                        <p class="text-lg font-bold text-red-600 dark:text-red-400 leading-tight">{{ \App\Models\Trailer::count() }}</p>
                        <p class="text-[9px] text-red-600/70 dark:text-red-400/70 mt-0.5">Trailer</p>
                    </div>
                    <div class="p-2 rounded-lg bg-green-50 dark:bg-green-900/20 text-center">
                        <p class="text-lg font-bold text-green-600 dark:text-green-400 leading-tight">{{ \App\Models\Post::count() }}</p>
                        <p class="text-[9px] text-green-600/70 dark:text-green-400/70 mt-0.5">Bài viết</p>
                    </div>
                    <div class="p-2 rounded-lg bg-purple-50 dark:bg-purple-900/20 text-center">
                        <p class="text-lg font-bold text-purple-600 dark:text-purple-400 leading-tight">{{ \App\Models\Category::count() }}</p>
                        <p class="text-[9px] text-purple-600/70 dark:text-purple-400/70 mt-0.5">Danh mục</p>
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

            const labels = @js($chartData['labels'] ?? []);

            // Line Chart
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
                            pointRadius: 2,
                            pointHoverRadius: 4
                        },
                        {
                            label: 'Trailer',
                            data: @js($chartData['trailerPlays'] ?? []),
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            fill: true,
                            tension: 0.4,
                            pointRadius: 2,
                            pointHoverRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: textColor,
                                font: { size: 10 }
                            },
                            grid: { color: gridColor }
                        },
                        x: {
                            ticks: {
                                color: textColor,
                                maxTicksLimit: 10,
                                font: { size: 10 }
                            },
                            grid: { display: false }
                        }
                    },
                    elements: {
                        point: {
                            radius: 1.5,
                            hoverRadius: 3
                        }
                    }
                }
            });

            // Pie Chart
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
    </script>
</x-filament-panels::page>
