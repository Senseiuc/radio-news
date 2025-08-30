@extends('layouts.app')

@section('title', 'Join Live Call')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Join Live Call</h1>
        @if($isOwner)
            <span class="inline-flex items-center gap-2 text-sm text-green-700 bg-green-50 border border-green-200 rounded px-3 py-1">
                <i class="fas fa-crown"></i> You are joining as Host
            </span>
        @else
            <span class="inline-flex items-center gap-2 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded px-3 py-1">
                <i class="fas fa-user"></i> You are joining as Participant
            </span>
        @endif
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <iframe
            src="{{ $embedUrl }}"
            allow="microphone; camera; autoplay; display-capture; clipboard-read; clipboard-write;"
            class="w-full h-[75vh]"
        ></iframe>
    </div>

    <div class="mt-4 text-sm text-gray-600">
        <p>Room: <strong>{{ $roomName }}</strong></p>
        <ul class="list-disc ml-6 mt-2">
            <li>Hosts can mute/remove participants, enable/disable recording and screenshare.</li>
            <li>Participants join with camera/mic permission prompts.</li>
            <li>This is a public room. Share cautiously.</li>
        </ul>
    </div>
</div>
@endsection
