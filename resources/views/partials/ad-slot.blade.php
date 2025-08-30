<?php
/**
 * Usage: @include('partials.ad-slot', ['placement' => 'header'])
 * Renders the first active ad configured for the given placement.
 * Supports:
 *  - type = 'custom': renders custom_code['html'] unescaped.
 *  - type in ['banner','in-article','auto'] with Google AdSense slot_id, if ADSENSE_CLIENT configured.
 */
$placement = $placement ?? null;
$ads = ($adsByPlacement ?? collect())->get($placement) ?? collect();
$ad = $ads->first();
?>
@if($placement && $ad)
    <div class="container mx-auto px-4 my-4" data-ad-placement="{{ $placement }}">
        <div class="w-full flex justify-center">
            @php
                $type = $ad->type ?? 'custom';
                $slot = $ad->slot_id ?? null;
                $code = $ad->custom_code ?? null; // array or string
            @endphp

            @if($type === 'custom' && $code)
                {!! is_array($code) && isset($code['html']) ? $code['html'] : (is_string($code) ? $code : '') !!}
            @elseif(in_array($type, ['banner','in-article','auto']) && $slot && !empty($adsenseClient))
                {{-- Google AdSense block --}}
                @if($type === 'in-article')
                    <ins class="adsbygoogle"
                         style="display:block; text-align:center;"
                         data-ad-layout="in-article"
                         data-ad-format="fluid"
                         data-ad-client="{{ $adsenseClient }}"
                         data-ad-slot="{{ $slot }}"></ins>
                @else
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="{{ $adsenseClient }}"
                         data-ad-slot="{{ $slot }}"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                @endif
                <script>(adsbygoogle=window.adsbygoogle||[]).push({});</script>
            @else
                {{-- No valid ad to render --}}
            @endif
        </div>
    </div>
@endif
