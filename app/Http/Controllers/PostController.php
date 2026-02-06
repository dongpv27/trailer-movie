<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::published()
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('post.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        // Increment view count
        $post->incrementView();

        // Related posts
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->limit(4)
            ->get();

        return view('post.show', compact('post', 'relatedPosts'));
    }
}
