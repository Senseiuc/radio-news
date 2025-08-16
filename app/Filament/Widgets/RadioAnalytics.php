<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class RadioAnalytics extends ChartWidget
{
    protected static ?string $heading = 'Blog Analytics';

    protected function getData(): array
    {
        // Last 7 days
        $dates = collect(range(0, 6))
            ->map(fn($i) => Carbon::today()->subDays($i)->format('Y-m-d'))
            ->reverse()
            ->values();

        $counts = $dates->map(function ($date) {
            return Article::whereDate('created_at', $date)->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Articles Published',
                    'data' => $counts,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)', // blue
                ],
            ],
            'labels' => $dates->map(fn($date) => Carbon::parse($date)->format('M d'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // could be 'line', 'bar', 'pie'
    }
}
