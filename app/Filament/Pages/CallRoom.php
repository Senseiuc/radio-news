<?php

namespace App\Filament\Pages;

use App\Services\DailyService;
use Filament\Pages\Page;

class CallRoom extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static string $view = 'filament.pages.call-room';
    protected static bool $shouldRegisterNavigation = false; // hide from sidebar

    public string $roomUrl;

    public function mount(string $roomName)
    {
        $token = app(DailyService::class)->createMeetingToken($roomName, true);

        $this->roomUrl = "https://senseiuc.daily.co/{$roomName}?t={$token['token']}";
    }
}
