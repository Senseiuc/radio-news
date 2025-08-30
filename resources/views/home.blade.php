@extends('layouts.app')

@section('title', 'Homeland News | Latest Updates and Breaking Stories')
@section('meta_description', 'Stay updated with Homeland News: breaking stories, politics, business, tech, culture, and more.')
@section('canonical', url('/'))

@section('content')

    @include('partials.hero')

    {{-- Live Stream Section (YouTube/Facebook) --}}
    @include('partials.live-section')

    {{-- Home Inline Ad --}}
    @include('partials.ad-slot', ['placement' => 'home-inline'])

    {{-- Categories --}}
    @include('partials.categories')

    {{-- Video Section --}}
{{--    @include('partials.video')--}}
{{--    @include('partials.section\s')--}}

@endsection
