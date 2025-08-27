<?php

use App\Filament\Pages\CallRoom;
use App\Http\Controllers\Web\ArticlePageController;
use App\Http\Controllers\Web\FeedController;
use App\Http\Controllers\Web\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Public article pages (SEO-friendly)
Route::get('/articles', [ArticlePageController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticlePageController::class, 'show'])->name('articles.show');

// SEO discovery endpoints
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/feed', [FeedController::class, 'index'])->name('feed');

Route::get('/admin/call-room/{roomName}', CallRoom::class)
    ->name('filament.pages.call-room');
