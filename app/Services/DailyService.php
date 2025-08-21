<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class DailyService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.daily.api_key');
        $this->baseUrl = config('services.daily.base_url', 'https://api.daily.co/v1');
    }

    /**
     * @throws ConnectionException
     */
    public function createRoom($name = null, $properties = [])
    {
        $payload = array_merge([
            'name' => $name ?? uniqid('room-'),
            'privacy' => 'private',
            'properties' => [
                'enable_chat' => true,
                'enable_screenshare' => true,
                'enable_knocking' => true
            ]
        ], $properties);

        $response = Http::withToken($this->apiKey)
            ->post("{$this->baseUrl}/rooms", $payload);

        return $response->json();
    }

    public function listRooms()
    {
        return Http::withToken($this->apiKey)
            ->get("{$this->baseUrl}/rooms")
            ->json();
    }

    public function deleteRoom($name)
    {
        return Http::withToken($this->apiKey)
            ->delete("{$this->baseUrl}/rooms/{$name}")
            ->json();
    }
}
