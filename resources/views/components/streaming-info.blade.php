@props(['movie' => null])

@if($movie)
<div class="rounded-lg bg-gray-800 p-4">
    <h3 class="mb-3 font-semibold text-white">Rạp + nền tảng chiếu phim</h3>
    @if($movie->streamings->isNotEmpty())
        <div class="space-y-2">
        @foreach($movie->streamings->sortBy('sort_order') as $streaming)
        @php
            $movieUrl = $streaming->getMovieUrl($movie, $streaming->pivot->external_url);
        @endphp

        @if($movieUrl && $streaming->pivot->status === 'available')
        <a href="{{ $movieUrl }}" target="_blank" rel="noopener noreferrer"
           class="flex items-center gap-3 p-2 rounded bg-gray-700 hover:bg-gray-600 transition block">
        @else
        <div class="flex items-center gap-3 p-2 rounded {{ $streaming->pivot->status === 'coming_soon' ? 'bg-gray-700/50' : 'bg-gray-700' }}">
        @endif
            {{-- Logo/Icon --}}
            <div class="flex-shrink-0 w-16 h-12 rounded bg-white flex items-center justify-center overflow-hidden">
                @if($streaming->icon)
                    {{-- Try to load SVG logo first --}}
                    <img src="{{ asset('images/streamings/' . $streaming->slug . '.svg') }}"
                         alt="{{ $streaming->name }}"
                         class="w-full h-full object-contain p-1">
                @else
                    <span class="text-2xl">{{ $streaming->type === 'cinema' ? '🎬' : '📺' }}</span>
                @endif
            </div>
            {{-- Name & Status --}}
            <div class="flex-1">
                <span class="font-medium {{ $streaming->pivot->status === 'coming_soon' ? 'text-gray-400' : 'text-white' }}">
                    {{ $streaming->name }}
                </span>
                @if($streaming->pivot->status === 'coming_soon')
                <span class="ml-2 text-xs text-gray-500">Chưa có lịch</span>
                @endif
            </div>
            {{-- External link icon --}}
            @if($movieUrl && $streaming->pivot->status === 'available')
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            @endif
        @if($movieUrl && $streaming->pivot->status === 'available')
        </a>
        @else
        </div>
        @endif
        @endforeach
        </div>
    @else
        <p class="text-gray-400 text-sm">Chưa có thông tin chính thức</p>
    @endif
</div>
@endif
