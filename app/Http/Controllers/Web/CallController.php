<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Services\DailyService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CallController extends Controller
{
    public function join(Request $request, DailyService $daily): View
    {
        // Determine a room name: use setting or default persistent name
        $roomName = config('app.name', 'homeland');
        $roomName = Str::slug($roomName.'-public', '-');

        // Ensure room exists (ignore errors if already exists)
        try {
            $daily->createRoom($roomName, [
                'privacy' => 'public',
                'properties' => [
                    'enable_chat' => true,
                    'enable_screenshare' => true,
                    'enable_knocking' => false,
                ],
            ]);
        } catch (\Throwable $e) {
            // room may already exist; ignore
        }

        // Role-based host token: admins, editors, publishers -> owner
        $isOwner = auth()->check() && auth()->user()->hasAnyRole(['admin','editor','publisher']);
        $token = null;
        try {
            $resp = $daily->createMeetingToken($roomName, $isOwner);
            $token = $resp['token'] ?? null;
        } catch (\Throwable $e) {
            $token = null;
        }

        // Build room URL (replace with your Daily subdomain as needed)
        $subdomain = env('DAILY_SUBDOMAIN', 'senseiuc');
        $roomUrl = "https://{$subdomain}.daily.co/{$roomName}" . ($token ? "?t={$token}" : '');

        $embedUrl = $roomUrl . (str_contains($roomUrl, '?') ? '&' : '?') . 'embedType=prebuilt';

        return view('calls.join', [
            'roomName' => $roomName,
            'roomUrl' => $roomUrl,
            'embedUrl' => $embedUrl,
            'isOwner' => $isOwner,
        ]);
    }
}
