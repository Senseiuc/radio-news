<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homeland</title>
    @vite('resources/css/app.css') {{-- Tailwind via Vite --}}
    @vite('resources/js/app.js') {{-- Alpine & app JS via Vite --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900 font-sans">
{{-- Header --}}
@include('partials.header')

{{-- Trending Bar --}}
@include('partials.trending')

{{-- Hero Section --}}
@yield('content')

{{-- Footer --}}
@include('partials.footer')
</body>
</html>
