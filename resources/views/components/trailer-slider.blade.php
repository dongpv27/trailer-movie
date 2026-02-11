@props(['movies' => []])

@if($movies->isNotEmpty())
<section class="relative overflow-hidden bg-gray-950">
    <div x-data="trailerSlider()" class="relative aspect-[16/9] md:aspect-[21/9]"
         @mouseenter="stopAutoPlay()"
         @mouseleave="startAutoPlay()">>

        <!-- Slides -->
        <template x-for="(movie, index) in movies" :key="movie.id">
            <div x-show="currentSlide === index"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0"
                 role="group"
                 :aria-label="`Slide ${index + 1}: ${movie.title}`">

                <!-- Backdrop Background -->
                <a :href="movie.url" class="block h-full w-full">
                    <img :src="movie.backdrop_url" :alt="movie.title" class="h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-gray-900/40 to-transparent"></div>
                </a>

                <!-- Content Container -->
                <div class="absolute inset-0 flex items-center px-4 py-8 md:px-12 md:py-16">
                    <div class="container mx-auto flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-8">
                        <!-- Poster Card -->
                        <a :href="movie.url" class="flex-shrink-0 group">
                            <div class="relative aspect-[2/3] w-32 md:w-48 lg:w-56 overflow-hidden rounded-lg shadow-2xl ring-2 ring-yellow-500/50 transition-all duration-300 group-hover:ring-yellow-500 group-hover:scale-105">
                                <img :src="movie.poster_url" :alt="movie.title" class="h-full w-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        </a>

                        <!-- Movie Info Overlay -->
                        <div class="flex-1 pt-4 md:pt-0">
                            <a :href="movie.url">
                                <!-- Badge -->
                                <span class="mb-3 inline-block rounded px-3 py-1 text-sm font-bold tracking-wide"
                                      :class="movie.statuses && movie.statuses.includes('hot') ? 'bg-red-600 text-white' : 'bg-yellow-500 text-black'"
                                      x-text="movie.statuses && movie.statuses.includes('hot') ? 'HOT' : 'SẮP CHIẾU'"></span>

                                <!-- Title -->
                                <h2 class="mb-3 text-2xl font-bold text-white md:text-4xl lg:text-5xl hover:text-yellow-400 transition" x-text="movie.title"></h2>

                                <!-- Description -->
                                <p class="mb-4 max-w-2xl text-gray-300 line-clamp-2 md:line-clamp-3" x-text="movie.description"></p>

                                <!-- Meta Info -->
                                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-400 md:gap-4">
                                    <span class="flex items-center gap-1">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span x-text="movie.year"></span>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span x-text="movie.duration + ' phút'"></span>
                                    </span>
                                </div>

                                <!-- Action Button -->
                                <div class="mt-6">
                                    <span class="inline-flex items-center gap-2 rounded-full bg-yellow-500 px-6 py-2.5 font-semibold text-white hover:bg-yellow-600 transition shadow-lg shadow-yellow-500/30">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                        Xem Trailer
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Navigation Arrows -->
        <button @click="previousSlide()" aria-label="Previous slide" class="absolute left-4 top-1/2 -translate-y-1/2 z-10 rounded-full bg-black/50 p-2.5 text-white hover:bg-yellow-500 transition md:left-8 backdrop-blur-sm">
            <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button @click="nextSlide()" aria-label="Next slide" class="absolute right-4 top-1/2 -translate-y-1/2 z-10 rounded-full bg-black/50 p-2.5 text-white hover:bg-yellow-500 transition md:right-8 backdrop-blur-sm">
            <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Dot Indicators -->
        <div class="absolute bottom-4 left-1/2 z-10 flex -translate-x-1/2 gap-2.5">
            <template x-for="(movie, index) in movies" :key="index">
                <button @click="goToSlide(index)"
                        :aria-label="`Go to slide ${index + 1}`"
                        :class="currentSlide === index ? 'bg-yellow-500 w-8' : 'bg-white/50 w-2 hover:bg-white/75'"
                        class="h-2 rounded-full transition-all duration-300"></button>
            </template>
        </div>

        <!-- Progress Bar -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-800">
            <div class="h-full bg-yellow-500 transition-all duration-100 ease-linear"
                 :style="`width: ${progressBar}%`"></div>
        </div>
    </div>

    <!-- Alpine.js Component -->
    <script>
        window.trailerSliderData = @js($movies->map(function($m) {
            return [
                'id' => $m->id,
                'title' => $m->title,
                'description' => $m->description ?? 'Xem trailer ' . $m->title,
                'poster_url' => $m->poster_url,
                'backdrop_url' => $m->backdrop_url,
                'url' => $m->url,
                'year' => $m->year,
                'duration' => $m->duration ?? 0,
                'statuses' => $m->statuses ?? [],
            ];
        })->values());

        function trailerSlider() {
            return {
                movies: window.trailerSliderData,
                currentSlide: 0,
                progressBar: 0,
                interval: null,
                progressInterval: null,
                autoPlayDelay: 3000,

                init() {
                    this.startAutoPlay();
                },

                startAutoPlay() {
                    this.stopAutoPlay();
                    this.progressBar = 0;

                    // Progress bar animation
                    const progressStep = 100 / (this.autoPlayDelay / 50);
                    this.progressInterval = setInterval(() => {
                        this.progressBar += progressStep;
                        if (this.progressBar >= 100) {
                            this.progressBar = 0;
                        }
                    }, 50);

                    // Slide transition
                    this.interval = setInterval(() => {
                        this.nextSlide();
                        this.progressBar = 0;
                    }, this.autoPlayDelay);
                },

                stopAutoPlay() {
                    if (this.interval) {
                        clearInterval(this.interval);
                        this.interval = null;
                    }
                    if (this.progressInterval) {
                        clearInterval(this.progressInterval);
                        this.progressInterval = null;
                    }
                    this.progressBar = 0;
                },

                nextSlide() {
                    this.currentSlide = (this.currentSlide + 1) % this.movies.length;
                },

                previousSlide() {
                    this.currentSlide = this.currentSlide === 0 ? this.movies.length - 1 : this.currentSlide - 1;
                },

                goToSlide(index) {
                    this.currentSlide = index;
                    this.progressBar = 0;
                    // Restart autoplay timer
                    this.startAutoPlay();
                }
            }
        }
    </script>
</section>
@endif
