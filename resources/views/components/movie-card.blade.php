@props(['movie'])

<a href="{{ $movie->url }}" class="group relative overflow-hidden rounded-lg bg-gray-800 transition hover:scale-105 hover:shadow-xl hover:shadow-red-500/20">
    <!-- Poster -->
    <div class="aspect-[2/3] overflow-hidden">
        <img
            src="{{ $movie->poster_url }}"
            alt="{{ $movie->title }}"
            loading="lazy"
            class="h-full w-full object-cover transition group-hover:scale-110"
        >
    </div>

    <!-- Play Button Overlay -->
    <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition group-hover:opacity-100">
        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-red-600">
            <svg class="ml-1 h-8 w-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z"/>
            </svg>
        </div>
    </div>

    <!-- Info -->
    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black via-black/70 to-transparent p-4">
        <h3 class="truncate text-lg font-semibold">{{ $movie->title }}</h3>
        @if($movie->original_title && $movie->original_title !== $movie->title)
        <p class="truncate text-sm text-gray-300">{{ $movie->original_title }}</p>
        @endif
        <div class="mt-2 flex items-center gap-3 text-sm text-gray-400">
            @if($movie->year)
            <span>{{ $movie->year }}</span>
            @endif
            @if($movie->duration)
            <span>{{ $movie->duration }} phút</span>
            @endif
        </div>
    </div>

    <!-- Status Badge -->
    @if($movie->status === 'hot')
    <span class="absolute left-2 top-2 rounded bg-red-600 px-2 py-1 text-xs font-semibold">HOT</span>
    @elseif($movie->status === 'upcoming')
    <span class="absolute left-2 top-2 rounded bg-yellow-600 px-2 py-1 text-xs font-semibold">SẮP CHIẾU</span>
    @endif
</a>
