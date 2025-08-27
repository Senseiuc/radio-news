@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ $base }}/</loc>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ $base }}/articles</loc>
        <changefreq>hourly</changefreq>
        <priority>0.9</priority>
    </url>
    @foreach($articles as $a)
        <url>
            <loc>{{ $base }}/articles/{{ $a->slug }}</loc>
            @if($a->updated_at)
            <lastmod>{{ $a->updated_at->toAtomString() }}</lastmod>
            @endif
            <changefreq>daily</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach
</urlset>
