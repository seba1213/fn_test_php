<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShortLinkStatsController extends Controller
{
    public function __invoke(Request $request, ShortLink $shortLink): JsonResponse
    {
        abort_unless($shortLink->user_id === $request->user()?->id, 404);

        return response()->json([
            'short_link_id' => $shortLink->id,
            'total_clicks' => $shortLink->statistics()->count(),
        ]);
    }
}

