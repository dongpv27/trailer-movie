@props(['movies' => []])

@if($movies->isNotEmpty())
<section class="relative overflow-hidden bg-gray-950">
    <div x-data="heroSlider({{ $movies->pluck('id')->toJson() }})" class="relative">
        <!-- Slides -->
        <template x-for="(movie, index) in movies" :key="movie.id">
            <div x-show="currentSlide === index"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0 hidden">
                <!-- Backdrop -->
                <img :src="movie.backdrop_url" :alt="movie.title" class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-transparent to-transparent"></div>

                <!-- Content -->
                <div class="absolute bottom-0 left-0 right-0 px-4 pb-16 pt-32 md:px-8 md:pb-24 md:pt-48">
                    <div class="container mx-auto">
                        <span class="mb-2 inline-block rounded bg-red-600 px-3 py-1 text-sm font-semibold"
                              x-text="movie.status === 'hot' ? 'HOT' : 'MỚI'"></span>
                        <h2 class="mb-3 text-3xl font-bold md:text-5xl lg:text-6xl" x-text="movie.title"></h2>
                        <p class="mb-4 max-w-2xl text-gray-300 line-clamp-2 md:line-clamp-3" x-text="movie.description"></p>
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400 md:gap-6">
                            <span x-text="movie.year"></span>
                            <span x-text="movie.duration + ' phút'"></span>
                        </div>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a :href="movie.url"
                               class="inline-flex items-center gap-2 rounded bg-red-600 px-6 py-3 font-semibold hover:bg-red-700 transition">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                                Xem Trailer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Navigation Arrows -->
        <button @click="previousSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-black/50 p-2 hover:bg-red-600 transition md:left-8">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button @click="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-black/50 p-2 hover:bg-red-600 transition md:right-8">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Dots -->
        <div class="absolute bottom-4 left-1/2 flex -translate-x-1/2 gap-2">
            <template x-for="(movie, index) in movies" :key="index">
                <button @click="goToSlide(index)"
                        :class="currentSlide === index ? 'bg-red-600 w-8' : 'bg-gray-500 w-2'"
                        class="h-2 rounded-full transition">
                </button>
            </template>
        </div>
    </div>

    <!-- Initial data for Alpine.js -->
    <script>
        function heroSlider(movieIds) {
            return {
                movies: @js($movies->map(function($m) {
                    return [
                        'id' => $m->id,
                        'title' => $m->title,
                        'description' => $m->description ?? 'Xem trailer ' . $m->title,
                        'backdrop_url' => $m->backdrop_url,
                        'url' => $m->url,
                        'year' => $m->year,
                        'duration' => $m->duration ?? 0,
                        'status' => $m->status,
                    ];
                })->values()),
                currentSlide: 0,
                init() {
                    setInterval(() => {
                        this.nextSlide();
                    }, 5000);
                },
                nextSlide() {
                    this.currentSlide = (this.currentSlide + 1) % this.movies.length;
                },
                previousSlide() {
                    this.currentSlide = this.currentSlide === 0 ? this.movies.length - 1 : this.currentSlide - 1;
                },
                goToSlide(index) {
                    this.currentSlide = index;
                }
            }
        }
    </script>
</section>
@endif
