<?php

use App\Http\Controllers\Api\AdController;
use App\Models\ChatMessage;
use App\Services\DailyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\RadioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Public API routes for listeners and site visitors
| Admin API routes protected by Filament authentication
|--------------------------------------------------------------------------
*/

// ✅ Authenticated user details (for logged-in API users, if needed)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Public Endpoints (No Auth Required)
|--------------------------------------------------------------------------
*/

// Articles
Route::prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->middleware('throttle:60,1');
    Route::get('/search', [ArticleController::class, 'search'])->middleware('throttle:60,1');
    Route::get('/{article}', [ArticleController::class, 'show'])->middleware('throttle:60,1');
});

// Radio status (public)
Route::get('/radio/status', [RadioController::class, 'status'])->middleware('throttle:60,1');

Route::get('/ads', [AdController::class, 'index'])->middleware('throttle:60,1');

Route::post('/calls/create', function () {
    $room = app(DailyService::class)->createRoom();
    return response()->json($room);
})->middleware('throttle:60,1');

Route::post('/meetings', function (Request $request, DailyService $daily) {
    $room = $daily->createRoom($request->name);
    return response()->json($room);
});

Route::get('/meetings', function (DailyService $daily) {
    return response()->json($daily->listRooms());
});

Route::post('/daily-webhook', function (Request $request) {
    if ($request->type === 'chat-message') {
        ChatMessage::create([
            'meeting_id' => $request->data['room_name'],
            'sender_name' => $request->data['user_name'],
            'message' => $request->data['message'],
        ]);
    }
    return response()->json(['status' => 'ok']);
});

//https://yourapp.com/api/daily-webhook
/*
|--------------------------------------------------------------------------
| Admin Endpoints (Filament Auth Required)
|--------------------------------------------------------------------------
| These routes are only accessible to logged-in Filament admins.
| If using Filament Shield, add ->middleware('permission:permission_name')
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:filament'])->prefix('admin')->group(function () {

    // Radio analytics
    Route::get('/radio/peaks', [RadioController::class, 'peaks']);
    Route::get('/radio/analytics', [RadioController::class, 'analytics']);

    // Optional: article management API endpoints for admins
    Route::get('/articles/manage', [ArticleController::class, 'manage']);
});
