<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Services\DailyService;

class CallManager extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static string $view = 'filament.pages.call-manager';
    protected static ?string $navigationLabel = 'Video Calls';

    public $rooms = [];

    public function mount(): void
    {
        $this->rooms = app(DailyService::class)->listRooms();
    }

    public function createRoom(): void
    {
        app(DailyService::class)->createRoom();
        $this->mount(); // refresh list
    }

    public function deleteRoom($name): void
    {
        app(DailyService::class)->deleteRoom($name);
        $this->mount();
    }
}
