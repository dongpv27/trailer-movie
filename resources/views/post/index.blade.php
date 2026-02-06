@extends('layouts.app')

@section('title', 'Tin Điện Ảnh')
@section('description', 'Tin tức điện ảnh mới nhất, cập nhật liên tục về phim, diễn viên, đạo diễn và sự kiện điện ảnh.')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Tin Điện Ảnh</h1>
        <p class="mt-2 text-gray-400">Cập nhật tin tức mới nhất về thế giới điện ảnh</p>
    </div>

    <!-- Posts Grid -->
    @if($posts->isNotEmpty())
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($posts as $post)
        <article class="overflow-hidden rounded-lg bg-gray-800 transition hover:scale-[1.02] hover:shadow-xl">
            @if($post->thumbnail)
            <a href="{{ $post->url }}" class="block aspect-video overflow-hidden">
                <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}"
                     loading="lazy" class="h-full w-full object-cover transition hover:scale-105">
            </a>
            @endif
            <div class="p-5">
                <h2 class="mb-3 text-xl font-semibold hover:text-red-500 transition">
                    <a href="{{ $post->url }}">{{ $post->title }}</a>
                </h2>
                @if($post->excerpt)
                <p class="mb-4 text-sm text-gray-400 line-clamp-3">{{ $post->excerpt }}</p>
                @endif
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <span>{{ $post->published_at?->format('d/m/Y') }}</span>
                    <span>{{ $post->view_count }} lượt xem</span>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $posts->appends(request()->query())->links() }}
    </div>
    @else
    <div class="rounded-lg bg-gray-800 p-8 text-center">
        <p class="text-gray-400">Chưa có bài viết nào.</p>
    </div>
    @endif
</div>
@endsection
