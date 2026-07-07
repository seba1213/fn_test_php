<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortLinkRedirectController;
use App\Http\Controllers\ShortLinkStatsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{code}', ShortLinkRedirectController::class)
    ->where('code', '(?!admin$)[^/]+')
    ->name('short-links.redirect');

Route::view('/link-missing', 'link-missing')
    ->name('short-links.missing');

Route::middleware('auth')
    ->prefix('api')
    ->group(function (): void {
        Route::get('/short-links/{shortLink}/stats', ShortLinkStatsController::class)
            ->name('api.short-links.stats');
    });
