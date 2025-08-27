@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<rss version="2.0">
  <channel>
    <title>{{ $siteTitle }}</title>
    <link>{{ $base }}/</link>
    <description>Latest articles from {{ $siteTitle }}</description>
    <language>en-us</language>
    @foreach($items as $item)
      <item>
        <title><![CDATA[{{ $item->title }}]]></title>
        <link>{{ $base }}/articles/{{ $item->slug }}</link>
        <guid isPermaLink="true">{{ $base }}/articles/{{ $item->slug }}</guid>
        @if($item->published_at)
        <pubDate>{{ $item->published_at->toRfc2822String() }}</pubDate>
        @endif
        @if($item->excerpt)
        <description><![CDATA[{{ $item->excerpt }}]]></description>
        @endif
        @if($item->image_url)
          @php
            $enclosureType = 'image/jpeg';
            if (str_ends_with(strtolower($item->image_url), '.svg')) {
                $enclosureType = 'image/svg+xml';
            } elseif (str_ends_with(strtolower($item->image_url), '.png')) {
                $enclosureType = 'image/png';
            }
          @endphp
        <enclosure url="{{ $item->image_url }}" type="{{ $enclosureType }}" />
        @endif
      </item>
    @endforeach
  </channel>
</rss>
