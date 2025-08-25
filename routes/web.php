<?php

use App\Filament\Pages\CallRoom;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/call-room/{roomName}', CallRoom::class)
    ->name('filament.pages.call-room');
