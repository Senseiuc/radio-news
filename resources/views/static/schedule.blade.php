@extends('layouts.app')

@section('title', 'Programme Schedule | Homeland Radio')
@section('meta_description', 'See the weekly on-air schedule for Homeland Radio shows and hosts.')
@section('canonical', route('schedule'))

@section('content')
<div class="container mx-auto px-4 py-10">
    <h1 class="text-2xl font-extrabold tracking-tight mb-6">Programme Schedule</h1>
    @php
        $schedule = optional($siteSettings)->radio_schedule ?? [];
        $grouped = collect($schedule)->groupBy(function($i){ return strtolower($i['day'] ?? ''); });
        $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
    @endphp

    @if(empty($schedule))
        <div class="bg-white border border-gray-200 rounded-lg p-6 text-gray-600">Schedule will be published soon.</div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($days as $day)
                <section class="bg-white rounded-lg shadow border border-gray-100">
                    <div class="px-5 py-3 border-b font-semibold capitalize">{{ $day }}</div>
                    <ul class="divide-y">
                        @forelse(($grouped[$day] ?? collect()) as $item)
                            <li class="px-5 py-3">
                                <div class="text-sm font-medium">
                                    {{ $item['title'] ?? 'Show' }}
                                    @if(!empty($item['host']))
                                        <span class="text-gray-500 font-normal">• {{ $item['host'] }}</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-600 mt-0.5">
                                    {{ $item['start'] ?? '?' }} - {{ $item['end'] ?? '?' }}
                                </div>
                            </li>
                        @empty
                            <li class="px-5 py-3 text-sm text-gray-500">No shows.</li>
                        @endforelse
                    </ul>
                </section>
            @endforeach
        </div>
    @endif
</div>
@endsection
