@extends('layouts.app')

@php
    $seoTitle = $post->title;
    $seoDescription = $post->excerpt ?: strip_tags(\Illuminate\Support\Str::limit($post->content, 160));
    $canonicalUrl = $post->url;
    $ogImage = $post->thumbnail_url;
@endphp

@push('schemas')
<script type="application/ld+json">
    {!! \App\Helpers\SeoHelper::postSchema($post) !!}
</script>

<script type="application/ld+json">
    {!! \App\Helpers\SeoHelper::breadcrumbListSchema([
        'Trang chủ' => route('home'),
        'Tin điện ảnh' => route('post.index'),
        $post->title => $post->url
    ]) !!}
</script>
@endpush

@section('content')
<!-- Breadcrumb -->
<nav class="container mx-auto px-4 py-4 text-sm text-gray-400">
    <ol class="flex items-center gap-2">
        <li><a href="{{ route('home') }}" class="hover:text-white transition">Trang chủ</a></li>
        <li class="text-gray-600">/</li>
        <li><a href="{{ route('post.index') }}" class="hover:text-white transition">Tin điện ảnh</a></li>
        <li class="text-gray-600">/</li>
        <li class="text-white">{{ $post->title }}</li>
    </ol>
</nav>

<div class="container mx-auto px-4 py-8">
    <div class="mx-auto max-w-3xl">
        <!-- Post Header -->
        <article class="rounded-lg bg-gray-800 p-6 md:p-8">
            @if($post->thumbnail)
            <div class="mb-6 overflow-hidden rounded-lg">
                <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}"
                     class="w-full object-cover">
            </div>
            @endif

            <h1 class="mb-4 text-3xl font-bold md:text-4xl">{{ $post->title }}</h1>

            <div class="mb-6 flex items-center gap-4 text-sm text-gray-400">
                <span>{{ $post->published_at?->format('d/m/Y') }}</span>
                <span>{{ $post->view_count }} lượt xem</span>
            </div>

            <div class="prose prose-invert max-w-none">
                {!! $post->content !!}
            </div>
        </article>

        <!-- Share -->
        <div class="mt-6 rounded-lg bg-gray-800 p-4">
            <h3 class="mb-3 font-semibold">Chia sẻ bài viết:</h3>
            <div class="flex gap-2">
                <button onclick="window.open('https://www.facebook.com/sharer/sharer.php?u={{ urlencode($post->url) }}', '_blank')"
                        class="flex h-10 w-10 items-center justify-center rounded bg-blue-600 hover:bg-blue-700 transition">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </button>
                <button onclick="window.open('https://twitter.com/intent/tweet?url={{ urlencode($post->url) }}&text={{ urlencode($post->title) }}', '_blank')"
                        class="flex h-10 w-10 items-center justify-center rounded bg-sky-500 hover:bg-sky-600 transition">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Related Posts -->
        @if(isset($relatedPosts) && $relatedPosts->isNotEmpty())
        <div class="mt-8">
            <h3 class="mb-4 text-xl font-bold">Bài viết liên quan</h3>
            <div class="grid gap-4 md:grid-cols-2">
                @foreach($relatedPosts as $relatedPost)
                <article class="rounded-lg bg-gray-800 p-4 transition hover:bg-gray-750">
                    @if($relatedPost->thumbnail)
                    <a href="{{ $relatedPost->url }}" class="block aspect-video mb-3 overflow-hidden rounded">
                        <img src="{{ $relatedPost->thumbnail_url }}" alt="{{ $relatedPost->title }}"
                             loading="lazy" class="h-full w-full object-cover">
                    </a>
                    @endif
                    <h4 class="mb-2 font-semibold hover:text-yellow-400 transition">
                        <a href="{{ $relatedPost->url }}">{{ $relatedPost->title }}</a>
                    </h4>
                    <div class="text-xs text-gray-500">
                        {{ $relatedPost->published_at?->format('d/m/Y') }}
                    </div>
                </article>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
