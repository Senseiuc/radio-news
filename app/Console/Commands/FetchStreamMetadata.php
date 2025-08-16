<?php

namespace App\Console\Commands;

use App\Models\StreamMetadata;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchStreamMetadata extends Command
{
    protected $signature = 'radio:fetch-metadata';
    protected $description = 'Fetches current radio stream stats';

    public function handle(): void
    {
        $stream = StreamMetadata::query()->firstOrNew(['id' => 1]);

        try {
            $response = Http::timeout(3)->get(config('broadcasting.icecast.status_url'));
            $data = $response->json();

            $updateData = [
                'is_online' => true,
                'last_online_at' => now(),
                'bitrate' => $data['icestats']['source']['bitrate'] ?? null,
                'current_song' => $this->extractSongTitle($data),
                'listeners' => (int) ($data['icestats']['source']['listeners'] ?? 0)
            ];

            // Only update peak if higher than previous
            if ($updateData['listeners'] > $stream->peak_listeners) {
                $updateData['peak_listeners'] = $updateData['listeners'];
            }

            $stream->update($updateData);

        } catch (Exception) {
            $stream->update(['is_online' => false]);
        }
    }

    private function extractSongTitle(array $data): string
    {
        return match(true) {
            isset($data['icestats']['source']['title']) =>
            $data['icestats']['source']['title'],
            isset($data['songtitle']) =>
            $data['songtitle'],
            default => 'Live Broadcast'
        };
    }
}
