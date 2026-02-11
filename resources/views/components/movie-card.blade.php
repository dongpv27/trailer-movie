@props(['movie'])

<a href="{{ $movie->url }}" class="group relative overflow-hidden rounded-lg bg-gray-800 transition hover:scale-105 hover:shadow-xl hover:shadow-yellow-500/20">
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
        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-yellow-500">
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

    <!-- Status Badges -->
    <div class="absolute left-2 top-2 flex flex-col gap-1 items-start">
        @if(is_array($movie->statuses) && count($movie->statuses) > 0)
            @foreach($movie->statuses as $status)
                @if($status === 'hot')
                    <span class="inline-block whitespace-nowrap rounded bg-red-600 px-2 py-0.5 text-xs font-semibold shadow-lg">HOT</span>
                @elseif($status === 'upcoming')
                    <span class="inline-block whitespace-nowrap rounded bg-yellow-500 px-2 py-0.5 text-xs font-semibold shadow-lg">SẮP CHIẾU</span>
                @elseif($status === 'released')
                    <span class="inline-block whitespace-nowrap rounded bg-green-600 px-2 py-0.5 text-xs font-semibold shadow-lg">ĐANG CHIẾU</span>
                @endif
            @endforeach
        @endif
    </div>
</a>
