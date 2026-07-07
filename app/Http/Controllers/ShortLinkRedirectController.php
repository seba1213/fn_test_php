<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShortLinkRedirectController extends Controller
{
    public function __invoke(Request $request, string $code): RedirectResponse
    {
        $shortLink = ShortLink::query()->where('code', $code)->first();

        if (! $shortLink) {
            return redirect()->route('short-links.missing');
        }

        $shortLink->statistics()->create([
            'ip_address' => (string) $request->ip(),
            'clicked_at' => now(),
        ]);

        return redirect()->away($shortLink->original_url);
    }
}

