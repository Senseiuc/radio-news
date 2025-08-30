@extends('layouts.app')

@section('title', 'Live | Homeland News')
@section('meta_description', 'Watch our live stream on YouTube or Facebook right now.')
@section('canonical', url('/live'))

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4 flex items-center gap-2">
            <span class="inline-block w-2 h-2 bg-red-600 rounded-full animate-ping"></span>
            <span class="inline-flex items-center gap-2 text-red-700 bg-red-50 border border-red-200 font-semibold text-xs px-2.5 py-1 rounded-full">LIVE</span>
            <span>Live Stream</span>
        </h1>
    </div>

    @include('partials.live-section')

    <div class="container mx-auto px-4 py-6">
        @include('partials.ad-slot', ['placement' => 'home-inline'])
    </div>
@endsection
