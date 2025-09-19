<?php

use App\Filament\Pages\CallRoom;
use App\Http\Controllers\Web\ArticlePageController;
use App\Http\Controllers\Web\FeedController;
use App\Http\Controllers\Web\SitemapController;
use App\Http\Controllers\Web\SearchController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CallController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Auth routes (minimal)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public article pages (SEO-friendly)
Route::get('/articles', [ArticlePageController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticlePageController::class, 'show'])->name('articles.show');
Route::post('/articles/{slug}/comments', [ArticlePageController::class, 'storeComment'])->name('articles.comments.store');

// Search page
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

// Newsletter subscribe
Route::post('/newsletter', [\App\Http\Controllers\Web\NewsletterController::class, 'store'])->name('newsletter.store');

// SEO discovery endpoints
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/feed', [FeedController::class, 'index'])->name('feed');

// Static pages (Coming soon)
Route::view('/terms', 'static.terms')->name('terms');
Route::view('/privacy', 'static.privacy')->name('privacy');
Route::view('/schedule', 'static.schedule')->name('schedule');

// Live page
Route::view('/live', 'live')->name('live');

// Public Join Call page (Daily prebuilt)
Route::get('/call', [CallController::class, 'join'])->name('call.join');

Route::get('/admin/call-room/{roomName}', CallRoom::class)
    ->name('filament.pages.call-room');

Route::get('/deploy-test', function () {
    $output = shell_exec('sh /home/yehnypok/public_html/deploy.sh 2>&1');

    Log::info('Deploy script run by user: ' . auth()->id());

    return "<pre>$output</pre>";
});
