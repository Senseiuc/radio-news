@extends('layouts.app')

@section('title', 'Join Call')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-4">Community Call</h1>

    @isset($embedUrl)
        <div class="aspect-video w-full bg-black rounded overflow-hidden shadow">
            <iframe
                src="{{ $embedUrl }}"
                allow="camera; microphone; speaker; display-capture; autoplay; clipboard-read; clipboard-write; picture-in-picture"
                allowfullscreen
                class="w-full h-full border-0"
                title="Daily Prebuilt Call">
            </iframe>
        </div>
    @else
        <p class="text-red-600">Unable to build embed URL.</p>
    @endisset

    <div class="mt-4 text-sm text-gray-600">
        <p>Room: <code>{{ $roomName ?? 'n/a' }}</code></p>
        <p>Direct URL: <a href="{{ $roomUrl ?? '#' }}" class="text-emerald-600 underline">{{ $roomUrl ?? 'n/a' }}</a></p>
        @if(!empty($isOwner))
            <p class="text-amber-700">You have host privileges in this call.</p>
        @endif
    </div>
</div>
@endsection
