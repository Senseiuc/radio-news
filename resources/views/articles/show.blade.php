@php
    use Illuminate\Support\Str;

    $title     = $article->title;
    $desc      = $article->excerpt ?: Str::limit(strip_tags($article->body ?? ''), 160);
    $canonical = url('/articles/' . $article->slug);
    $image     = $article->image_url ?? asset('images/homeland-logo.svg');
    $siteName  = config('app.name', 'Homeland Radio');

    $jsonLd = [
        '@context' => 'https://schema.org',
        '@type'    => 'NewsArticle',
        'headline' => $title,
        'image'    => [$image],
        'datePublished' => optional($article->published_at)->toAtomString(),
        'dateModified'  => optional($article->updated_at)->toAtomString(),
        'author' => [
            '@type' => 'Person',
            'name'  => optional($article->author)->name,
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name'  => $siteName,
            'logo'  => [
                '@type' => 'ImageObject',
                'url'   => asset('images/homeland-logo.svg'),
            ],
        ],
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id'   => $canonical,
        ],
    ];
@endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | {{ $siteName }}</title>
    <meta name="description" content="{{ $desc }}">
    <link rel="canonical" href="{{ $canonical }}" />

    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $desc }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:image" content="{{ $image }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $desc }}">
    <meta name="twitter:image" content="{{ $image }}">

    <!-- JSON-LD -->
    <script type="application/ld+json">
        {!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
    </script>
</head>
<body class="antialiased">
<article>
    <header>
        <h1>{{ $article->title }}</h1>
        @if($article->published_at)
            <p><time datetime="{{ $article->published_at->toAtomString() }}">
                    {{ $article->published_at->toFormattedDateString() }}
                </time></p>
        @endif
        @if($article->author)
            <p>By {{ $article->author->name }}</p>
        @endif
    </header>

    @if($article->image_url)
        <figure>
            <img src="{{ $article->image_url }}" alt="{{ $article->title }}">
        </figure>
    @endif

    <div>{!! $article->body !!}</div>

    @if($article->categories && $article->categories->count())
        <p>Categories:
            @foreach($article->categories as $cat)
                <a href="{{ url('/articles?category=' . $cat->slug) }}">{{ $cat->name }}</a>{{ !$loop->last ? ',' : '' }}
            @endforeach
        </p>
    @endif
</article>

<nav aria-label="Breadcrumb">
    <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ url('/articles') }}">Articles</a></li>
        <li aria-current="page">{{ $article->title }}</li>
    </ol>
</nav>
</body>
</html>
