<?php

namespace App\Http\Controllers;

use App\Models\Trailer;
use App\Models\TrailerPlay;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnalyticsController extends Controller
{
    public function trackTrailerPlay(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'trailer_id' => 'required|integer|exists:trailers,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid trailer'], 422);
        }

        $trailer = Trailer::findOrFail($request->trailer_id);

        // Debounce: 1 session = 1 play per hour per trailer
        $recentPlay = TrailerPlay::where('trailer_id', $trailer->id)
            ->where('session_id', $request->session()->getId())
            ->where('played_at', '>', now()->subHour())
            ->first();

        if (!$recentPlay) {
            TrailerPlay::create([
                'trailer_id' => $trailer->id,
                'movie_id' => $trailer->movie_id,
                'session_id' => $request->session()->getId(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'played_at' => now(),
            ]);

            $trailer->incrementPlay();
        }

        return response()->json(['status' => 'tracked']);
    }
}
