@extends('layouts.app')

@section('title', $article->title . ' | Homeland News')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($article->excerpt ?: strip_tags($article->body)), 160))
@section('canonical', route('articles.show', $article->slug))
@section('og_type', 'article')
@section('og_title', $article->title)
@section('og_description', \Illuminate\Support\Str::limit(strip_tags($article->excerpt ?: strip_tags($article->body)), 200))
@section('og_image', ($article->image_url && !preg_match('/^https?:\/\//i', $article->image_url)) ? asset(ltrim($article->image_url,'/')) : ($article->image_url ?: asset('images/homeland_logo.png')))
@section('twitter_title', $article->title)
@section('twitter_description', \Illuminate\Support\Str::limit(strip_tags($article->excerpt ?: strip_tags($article->body)), 200))

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $article->title,
    'datePublished' => optional($article->published_at)->toIso8601String(),
    'author' => $article->author ? ['@type' => 'Person', 'name' => $article->author->name] : null,
    'image' => $article->image_url ? (preg_match('/^https?:\/\//i',$article->image_url) ? $article->image_url : asset(ltrim($article->image_url,'/'))) : null,
    'mainEntityOfPage' => route('articles.show', $article->slug),
]) !!}
</script>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main content -->
        <article class="lg:col-span-3">
        @php
            $img = $article->image_url ? (preg_match('/^https?:\/\//i',$article->image_url) ? $article->image_url : asset(ltrim($article->image_url,'/'))) : null;
            $author = optional($article->author)->name;
            $url = request()->fullUrl();
            $encodedUrl = urlencode($url);
            $encodedTitle = urlencode($article->title);
        @endphp

        <header class="mb-6">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $article->title }}</h1>
            <div class="mt-2 text-sm text-gray-600 flex flex-wrap items-center gap-2">
                <span>{{ $author ? 'By ' . $author : 'By Unknown' }}</span>
                <span>·</span>
                <span>{{ optional($article->published_at)->format('M j, Y') }}</span>
                @if($article->categories && $article->categories->isNotEmpty())
                    <span>·</span>
                    <span>{{ $article->categories->pluck('name')->take(2)->join(', ') }}</span>
                @endif
            </div>
        </header>

        @if($img)
            <div class="mb-6">
                <img src="{{ $img }}" alt="{{ $article->title }}" class="w-full max-h-[520px] object-cover rounded-lg shadow">
            </div>
        @endif

        {{-- Media players --}}
        @php
            $audio = $article->audio_source;
            $video = $article->video_source;
            $isYouTube = $video && preg_match('~^(https?:)?//(www\.)?(youtube\.com|youtu\.be)/~i', $video);
            $isVimeo = $video && preg_match('~^(https?:)?//(www\.)?vimeo\.com/~i', $video);
        @endphp

        @if($audio)
            <div class="mb-6 bg-white rounded-lg shadow p-4">
                <h2 class="text-base font-semibold mb-2">Listen to this article</h2>
                <audio controls preload="none" class="w-full">
                    <source src="{{ $audio }}">
                    Your browser does not support the audio element.
                </audio>
            </div>
        @endif

        @if($video)
            <div class="mb-6 bg-white rounded-lg shadow overflow-hidden">
                @if($isYouTube)
                    @php
                        // Convert to embed URL
                        $embed = $video;
                        if (preg_match("~youtu\.be/([\w-]+)~", $video, $m)) { $embed = 'https://www.youtube.com/embed/' . $m[1]; }
                        elseif (preg_match("~v=([\w-]+)~", $video, $m)) { $embed = 'https://www.youtube.com/embed/' . $m[1]; }
                    @endphp
                    <div class="relative pt-[56.25%]">
                        <iframe src="{{ $embed }}" class="absolute inset-0 w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe>
                    </div>
                @elseif($isVimeo)
                    @php
                        $embed = $video;
                        if (preg_match("~vimeo\.com/(?:video/)?(\d+)~", $video, $m)) { $embed = 'https://player.vimeo.com/video/' . $m[1]; }
                    @endphp
                    <div class="relative pt-[56.25%]">
                        <iframe src="{{ $embed }}" class="absolute inset-0 w-full h-full" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                    </div>
                @else
                    <video controls preload="metadata" class="w-full max-h-[520px] bg-black">
                        <source src="{{ $video }}">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>
        @endif

        {{-- Article Inline Ad --}}
        @include('partials.ad-slot', ['placement' => 'article-inline'])

        <!-- Share bar -->
        <div class="mb-8 flex flex-wrap items-center gap-2">
            <span class="text-sm text-gray-600 mr-2">Share:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" target="_blank" rel="noopener" class="px-3 py-1.5 bg-blue-700 text-white rounded text-sm">Facebook</a>
            <a href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" target="_blank" rel="noopener" class="px-3 py-1.5 bg-sky-500 text-white rounded text-sm">X</a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $encodedUrl }}" target="_blank" rel="noopener" class="px-3 py-1.5 bg-blue-800 text-white rounded text-sm">LinkedIn</a>
            <a href="https://api.whatsapp.com/send?text={{ $encodedTitle }}%20{{ $encodedUrl }}" target="_blank" rel="noopener" class="px-3 py-1.5 bg-green-600 text-white rounded text-sm">WhatsApp</a>
            <a href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedTitle }}" target="_blank" rel="noopener" class="px-3 py-1.5 bg-blue-600 text-white rounded text-sm">Telegram</a>
            <a href="mailto:?subject={{ $encodedTitle }}&body={{ $encodedUrl }}" class="px-3 py-1.5 bg-gray-700 text-white rounded text-sm">Email</a>
            <button type="button" class="px-3 py-1.5 bg-gray-200 text-gray-800 rounded text-sm" onclick="navigator.clipboard.writeText('{{ $url }}').then(()=>alert('Link copied'))">Copy Link</button>
        </div>

        <div class="prose max-w-none prose-img:rounded-lg">
            {!! $article->body !!}
        </div>

        <!-- You may also like -->
        @if(($related ?? collect())->isNotEmpty())
            <section class="mt-12">
                <h2 class="text-xl font-bold mb-4">You may also like</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($related as $rel)
                        @php
                            $rimg = $rel->image_url ? (preg_match('/^https?:\/\//i',$rel->image_url) ? $rel->image_url : asset(ltrim($rel->image_url,'/'))) : 'https://via.placeholder.com/480x270';
                        @endphp
                        <article class="bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden">
                            <a href="{{ route('articles.show', $rel->slug) }}" class="block">
                                <div class="relative h-40">
                                    <img src="{{ $rimg }}" alt="{{ $rel->title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-base leading-snug line-clamp-2">{{ $rel->title }}</h3>
                                    <div class="mt-1 text-[11px] text-gray-500">{{ optional($rel->published_at)->format('M j, Y') }}</div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Comments -->
        <section class="mt-12">
            <h2 class="text-xl font-bold mb-4">Comments</h2>
            @if(($approvedComments ?? collect())->isEmpty())
                <p class="text-sm text-gray-600">No comments yet.</p>
            @else
                <ul class="space-y-4">
                    @foreach($approvedComments as $c)
                        <li class="bg-white rounded-lg border border-gray-100 p-4">
                            <div class="text-sm text-gray-700">
                                <span class="font-semibold">{{ optional($c->user)->name ?? 'User' }}</span>
                                <span class="text-gray-500">· {{ $c->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="mt-1 text-gray-800">{{ $c->body }}</div>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="mt-6">
                @if(session('status'))
                    <div class="mb-3 text-sm text-green-700 bg-green-50 border border-green-200 rounded p-3">{{ session('status') }}</div>
                @endif
                @if($errors->has('auth'))
                    <div class="mb-3 text-sm text-red-700 bg-red-50 border border-red-200 rounded p-3">{{ $errors->first('auth') }}</div>
                @endif
                <h3 class="font-semibold mb-2">Add a comment</h3>
                @auth
                    <form method="post" action="{{ route('articles.comments.store', $article->slug) }}" class="space-y-3">
                        @csrf
                        <div>
                            <label for="body" class="sr-only">Comment</label>
                            <textarea id="body" name="body" rows="4" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Write your comment...">{{ old('body') }}</textarea>
                            @error('body')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-md">Post comment</button>
                        </div>
                    </form>
                @else
                    <p class="text-sm text-gray-700">Please <a href="{{ route('login') }}" class="text-blue-700 underline">log in</a> or <a href="{{ route('register') }}" class="text-blue-700 underline">create an account</a> to add a comment.</p>
                @endauth
            </div>
        </section>
    </article>

        <!-- Sidebar -->
        <aside class="lg:col-span-1 space-y-8">
            {{-- Sidebar Ad --}}
            @include('partials.ad-slot', ['placement' => 'sidebar'])
            <!-- Recent Posts -->
            <section class="bg-white rounded-lg shadow border border-gray-100">
                <div class="px-5 py-4 border-b">
                    <h2 class="text-lg font-bold">Recent Posts</h2>
                </div>
                <ul class="divide-y">
                    @foreach(($recentPosts ?? collect()) as $post)
                        <li>
                            <a href="/articles/{{ $post->slug }}" class="block px-5 py-3 hover:bg-gray-50">
                                <div class="text-sm font-medium text-gray-900 line-clamp-2">{{ $post->title }}</div>
                            </a>
                        </li>
                    @endforeach
                    @if(($recentPosts ?? collect())->isEmpty())
                        <li class="px-5 py-3 text-sm text-gray-500">No recent posts.</li>
                    @endif
                </ul>
            </section>

            <!-- Social Feed -->
            <section class="bg-white rounded-lg shadow border border-gray-100 p-5">
                <h2 class="text-lg font-bold mb-3">Social Feed</h2>
                <p class="text-sm text-gray-600 mb-4">Follow us for updates</p>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ $siteSettings->facebook_url ?? '#' }}" class="bg-blue-700 text-white py-1.5 px-3 rounded" aria-label="Facebook" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ $siteSettings->twitter_url ?? '#' }}" class="bg-sky-500 text-white py-1.5 px-3 rounded" aria-label="Twitter/X" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                    <a href="{{ $siteSettings->instagram_url ?? '#' }}" class="bg-gradient-to-r from-purple-500 to-pink-500 text-white py-1.5 px-3 rounded" aria-label="Instagram" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
                    <a href="{{ $siteSettings->youtube_url ?? '#' }}" class="bg-red-600 text-white py-1.5 px-3 rounded" aria-label="YouTube" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a>
                    <a href="{{ $siteSettings->linkedin_url ?? '#' }}" class="bg-blue-800 text-white py-1.5 px-3 rounded" aria-label="LinkedIn" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a>
                    <a href="{{ $siteSettings->tiktok_url ?? '#' }}" class="bg-pink-600 text-white py-1.5 px-3 rounded" aria-label="TikTok" target="_blank" rel="noopener"><i class="fab fa-tiktok"></i></a>
                </div>
            </section>

            <!-- Newsletter -->
            <section class="bg-white rounded-lg shadow border border-gray-100 p-5">
                <h2 class="text-lg font-bold mb-2">Newsletter</h2>
                <p class="text-sm text-gray-600 mb-4">Get the latest news in your inbox.</p>
                @if(session('newsletter_status'))
                    <div class="mb-3 text-sm text-green-700 bg-green-50 border border-green-200 rounded p-3">{{ session('newsletter_status') }}</div>
                @endif
                <form method="post" action="{{ route('newsletter.store') }}">
                    @csrf
                    <label for="newsletter-email" class="sr-only">Email address</label>
                    <input id="newsletter-email" name="email" type="email" required placeholder="Your email address" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="mt-3 w-full bg-blue-700 text-white py-2 rounded-md">Subscribe</button>
                </form>
            </section>
        </aside>
    </div>
</div>
@endsection
