@php
    $yt = optional($siteSettings)->youtube_live_url ?? env('YOUTUBE_LIVE_URL');
    $fb = optional($siteSettings)->facebook_live_url ?? env('FACEBOOK_LIVE_URL');
    // Prefer YouTube if both present
    $hasLive = !empty($yt) || !empty($fb);
@endphp

@if($hasLive)
<section class="container mx-auto px-4 pt-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="flex items-center justify-between px-4 py-3 border-b">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-2 text-red-700 bg-red-50 border border-red-200 font-semibold text-xs px-2.5 py-1 rounded-full">
                    <span class="inline-block w-2 h-2 bg-red-600 rounded-full animate-pulse"></span>
                    LIVE
                </span>
                <span class="text-sm text-gray-600">Now streaming</span>
            </div>
            @if(!empty($yt))
                <span class="text-xs text-gray-500">YouTube Live</span>
            @elseif(!empty($fb))
                <span class="text-xs text-gray-500">Facebook Live</span>
            @endif
        </div>
        <div class="relative pt-[56.25%]">
            @if(!empty($yt))
                @php
                    $embed = $yt;
                    // Accept channel live URLs or direct video/streams
                    if (preg_match("~youtu\.be/([\w-]+)~", $yt, $m)) { $embed = 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=0&modestbranding=1&rel=0'; }
                    elseif (preg_match("~v=([\w-]+)~", $yt, $m)) { $embed = 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=0&modestbranding=1&rel=0'; }
                    elseif (preg_match("~/embed/([\w-]+)~", $yt, $m)) { $embed = 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=0&modestbranding=1&rel=0'; }
                @endphp
                <iframe class="absolute inset-0 w-full h-full" src="{{ $embed }}" title="YouTube Live"
                        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe>
            @elseif(!empty($fb))
                @php
                    // Facebook Page Live Video plugin expects a page URL; if full plugin URL passed, use directly
                    $src = $fb;
                    if (!str_contains($fb, 'facebook.com/plugins/video.php')) {
                        $enc = urlencode($fb);
                        $src = "https://www.facebook.com/plugins/video.php?href={$enc}&show_text=false&autoplay=false";
                    }
                @endphp
                <iframe class="absolute inset-0 w-full h-full" src="{{ $src }}" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowfullscreen></iframe>
            @endif
        </div>
    </div>
</section>
@endif
