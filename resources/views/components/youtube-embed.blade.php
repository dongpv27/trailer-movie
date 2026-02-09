@props(['trailer'])

<div
    x-data="{
        playing: false,
        embedUrl: '',
        play() {
            this.embedUrl = 'https://www.youtube.com/embed/{{ $trailer->youtube_id }}?autoplay=1&rel=0&modestbranding=1&playsinline=1';
            this.playing = true;
        }
    }"
    class="relative aspect-video overflow-hidden rounded-lg bg-gray-800"
    id="trailer-{{ $trailer->id }}"
>
    <!-- Thumbnail Overlay -->
    <div x-show="!playing" x-cloak class="absolute inset-0 z-10">
        <img
            src="{{ $trailer->thumbnail_url }}"
            alt="{{ $trailer->title }}"
            loading="lazy"
            class="h-full w-full object-cover"
        >
        <div class="absolute inset-0 bg-black/30"></div>

        <!-- Play Button -->
        <button
            @click="play()"
            class="absolute inset-0 flex items-center justify-center group"
            aria-label="Play trailer"
        >
            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-yellow-500 transition group-hover:scale-110 group-hover:bg-yellow-600 shadow-lg">
                <svg class="ml-2 h-10 w-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </div>
        </button>
    </div>

    <!-- Iframe Container (loaded only when playing) -->
    <div x-show="playing" x-cloak class="absolute inset-0 w-full h-full">
        <iframe
            :src="embedUrl"
            title="{{ $trailer->title }}"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
            class="w-full h-full border-0"
        ></iframe>
    </div>
</div>
