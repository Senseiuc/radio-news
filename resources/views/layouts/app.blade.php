<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Homeland News')</title>
    <meta name="description" content="@yield('meta_description', 'Homeland delivers the latest news across politics, business, tech, and culture.')">
    <link rel="canonical" href="@yield('canonical', request()->fullUrl())">

    <!-- Open Graph -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="Homeland News">
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title', 'Homeland News')))" />
    <meta property="og:description" content="@yield('og_description', trim($__env->yieldContent('meta_description', 'Homeland delivers the latest news across politics, business, tech, and culture.')))" />
    <meta property="og:url" content="@yield('og_url', request()->fullUrl())" />
    <meta property="og:image" content="@yield('og_image', asset('images/homeland_logo.png'))" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', trim($__env->yieldContent('title', 'Homeland News')))" />
    <meta name="twitter:description" content="@yield('twitter_description', trim($__env->yieldContent('meta_description', 'Homeland delivers the latest news across politics, business, tech, and culture.')))" />
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/homeland_logo.png'))" />

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/homeland-favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/app-DzyQcuRG.css') }}">
    <script src="{{ asset('build/assets/app-DtCVKgHt.js') }}" defer></script>
{{--    @vite('resources/css/app.css') --}}{{-- Tailwind via Vite --}}
{{--    @vite('resources/js/app.js') --}}{{-- Alpine & app JS via Vite --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('head')
    @if(!empty($adsenseClient))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $adsenseClient }}" crossorigin="anonymous"></script>
    @endif
</head>
<body class="bg-gray-100 text-gray-900 font-sans">
{{-- Header --}}
@include('partials.header')

{{-- Trending Bar --}}
@include('partials.trending')

{{-- Header Ad Slot --}}
@include('partials.ad-slot', ['placement' => 'header'])

{{-- Page Content --}}
@yield('content')

{{-- Footer --}}
@include('partials.footer')

@include('partials.player-bar')

@stack('scripts')

{{-- Tawk.to widget (loads only if configured in Site Settings) --}}
@if(!empty(optional($siteSettings)->tawk_property_id))
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
var propertyId = @json($siteSettings->tawk_property_id);
var widgetId = @json($siteSettings->tawk_widget_id ?? null) || '1';
s1.src='https://embed.tawk.to/' + propertyId + '/' + widgetId;
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
@endif
</body>
</html>
