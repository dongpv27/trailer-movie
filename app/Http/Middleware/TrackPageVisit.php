<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Movie;
use App\Models\PageVisit;
use App\Models\Post;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class TrackPageVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->shouldTrack($request)) {
            $this->trackVisit($request);
        }

        return $response;
    }

    protected function shouldTrack(Request $request): bool
    {
        // Only track GET requests
        if ($request->method() !== 'GET') {
            return false;
        }

        // Skip admin, filament, api, and static files
        $path = $request->path();
        $skipPatterns = [
            'admin*',
            'filament*',
            'api*',
            'sanctum*',
            '_ignition*',
            'telescope*',
            'horizon*',
        ];

        foreach ($skipPatterns as $pattern) {
            if (str_starts_with($path, str_replace('*', '', $pattern))) {
                return false;
            }
        }

        // Only track HTML requests (not AJAX, JSON, etc.)
        if ($request->expectsJson() || $request->ajax()) {
            return false;
        }

        return true;
    }

    protected function trackVisit(Request $request): void
    {
        // Extract all data BEFORE dispatching to avoid serializing non-serializable objects
        $url = $request->fullUrl();
        $sessionId = $request->session()->getId();
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $referer = $request->header('referer');
        $method = $request->method();
        $locale = app()->getLocale();
        $path = $request->path();

        // Get visitable info here, not inside the queued closure
        $visitable = $this->extractVisitable($request->route(), $request);
        $visitableType = $visitable?->getMorphClass();
        $visitableId = $visitable?->id;
        $routeName = $request->route()?->getName();

        dispatch(function () use ($url, $routeName, $visitableType, $visitableId, $sessionId, $ipAddress, $userAgent, $referer, $method, $locale) {
            PageVisit::create([
                'url' => $url,
                'route_name' => $routeName,
                'visitable_type' => $visitableType,
                'visitable_id' => $visitableId,
                'session_id' => $sessionId,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'referer' => $referer,
                'metadata' => [
                    'method' => $method,
                    'locale' => $locale,
                ],
                'visited_at' => now(),
            ]);
        })->afterResponse();
    }

    protected function extractVisitable($route, Request $request): ?Model
    {
        if (!$route) {
            return null;
        }

        $parameterMap = [
            'movie' => Movie::class,
            'post' => Post::class,
            'category' => Category::class,
        ];

        foreach ($parameterMap as $param => $model) {
            $id = $route->parameter($param);
            if ($id) {
                return $model::find($id);
            }
        }

        // Check for slug-based routes
        if ($route->hasParameter('slug')) {
            // Try to find by slug in different models
            if (str_starts_with($request->path(), 'phim/')) {
                return Movie::where('slug', $route->parameter('slug'))->first();
            }
            if (str_starts_with($request->path(), 'tin-dien-anh/')) {
                return Post::where('slug', $route->parameter('slug'))->first();
            }
            if (str_starts_with($request->path(), 'the-loai/') ||
                str_starts_with($request->path(), 'quoc-gia/') ||
                str_starts_with($request->path(), 'nam-pham/')) {
                return Category::where('slug', $route->parameter('slug'))->first();
            }
        }

        return null;
    }
}
