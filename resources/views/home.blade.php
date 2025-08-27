@extends('layouts.app')

@section('content')

    @include('partials.hero')

    {{-- Categories --}}
    @include('partials.categories')

    {{-- Video Section --}}
    @include('partials.video')
{{--    @include('partials.sections')--}}

@endsection
