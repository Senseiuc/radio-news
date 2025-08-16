<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StreamMetadata;
use Illuminate\Http\JsonResponse;

class RadioController extends Controller
{
    /**
     * Public: Get current radio stream status
     */
    public function status(): JsonResponse
    {
        return response()->json(StreamMetadata::first());
    }

    /**
     * Admin: Peak listener stats
     */
    public function peaks(): JsonResponse
    {
        if (! auth()->user()->can('view_radio_metrics')) {
            abort(403, 'Unauthorized');
        }

        return response()->json([
            'peak_listeners' => StreamMetadata::value('peak_listeners'),
            'uptime' => $this->calculateUptime()
        ]);
    }

    /**
     * Admin: Full radio analytics
     */
    public function analytics(): JsonResponse
    {
        if (! auth()->user()->can('view_radio_metrics')) {
            abort(403, 'Unauthorized');
        }

        return response()->json([
            'total_listeners' => StreamMetadata::value('total_listeners'),
            'peak_listeners'  => StreamMetadata::value('peak_listeners'),
            'uptime'          => $this->calculateUptime(),
            'last_restart'    => StreamMetadata::value('last_restart'),
        ]);
    }

    /**
     * Helper: Calculate streaming uptime
     */
    private function calculateUptime(): string
    {
        // TODO: Implement actual uptime logic based on your streaming server
        return '72 hours';
    }
}
