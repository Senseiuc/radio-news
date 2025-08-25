<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Services\DailyService;
use Illuminate\Http\Client\ConnectionException;

class CallManager extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static string $view = 'filament.pages.call-manager';
    protected static ?string $navigationLabel = 'Video Calls';

    public array $rooms = [];

    public function mount(): void
    {
        $this->rooms = app(DailyService::class)->listRooms();
    }

    /**
     * @throws ConnectionException
     */
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
