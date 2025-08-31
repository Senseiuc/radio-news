@extends('layouts.app')

@section('title', ($currentCategory?->name ? $currentCategory->name.' Articles' : 'All Articles').' | Homeland News')
@section('meta_description', $currentCategory?->name ? ('Latest '.$currentCategory->name.' articles from Homeland News.') : 'Browse the latest articles from Homeland News across politics, business, tech, sports and more.')
@section('canonical', url()->full())

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-extrabold tracking-tight">
                {{ $currentCategory?->name ? $currentCategory->name : 'All Articles' }}
            </h1>
            @if($currentCategory)
                <a href="{{ route('articles.index') }}" class="text-sm text-blue-700 hover:underline">Clear filter</a>
            @endif
        </div>

        @if($articles->count() === 0)
            <div class="bg-white border border-gray-200 rounded-lg p-6 text-gray-600">No articles found.</div>
        @else
            @php
                $collection = ($articles instanceof \Illuminate\Pagination\LengthAwarePaginator || $articles instanceof \Illuminate\Pagination\Paginator)
                    ? $articles->getCollection()
                    : collect($articles);
            @endphp

            @if($currentCategory)
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <div class="lg:col-span-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($collection as $article)
                                @php
                                    $img = $article->image_url ? (preg_match('/^https?:\/\//i',$article->image_url) ? $article->image_url : asset(ltrim($article->image_url,'/'))) : 'https://via.placeholder.com/640x360';
                                    $author = optional($article->author)->name;
                                @endphp
                                <article class="bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden">
                                    <a href="/articles/{{ $article->slug }}" class="block">
                                        <div class="relative h-44">
                                            <img src="{{ $img }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="p-4">
                                            <h3 class="font-semibold text-base leading-snug line-clamp-2">{{ $article->title }}</h3>
                                            <div class="mt-2 text-[11px] text-gray-500 flex items-center justify-between">
                                                <span class="truncate">{{ $author ? 'By ' . $author : 'By Unknown' }}</span>
                                                <span class="ml-2 shrink-0">{{ optional($article->published_at)->format('M j, Y') }}</span>
                                            </div>
                                            @if($article->excerpt)
                                                <p class="mt-2 text-sm text-gray-700 line-clamp-3">{{ \Illuminate\Support\Str::limit(strip_tags($article->excerpt), 160) }}</p>
                                            @endif
                                        </div>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                        <div class="mt-8">
                            {{ $articles->links() }}
                        </div>
                    </div>
                    <!-- Sidebar -->
                    <aside class="lg:col-span-1 space-y-8">
                        @include('partials.ad-slot', ['placement' => 'sidebar'])
                        @include('partials._recent_posts')
                    </aside>
                </div>
            @else
                <!-- Top 3: full-width row that pushes the sidebar down -->
                @php
                    $topThree = $collection->take(3);
                    $rest = $collection->slice(3);
                @endphp
                @if($topThree->count() > 0)
                    <div class="mb-8">
                        @include('partials.ad-slot', ['placement' => 'index-top'])
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($topThree as $article)
                                @php
                                    $img = $article->image_url ? (preg_match('/^https?:\/\//i',$article->image_url) ? $article->image_url : asset(ltrim($article->image_url,'/'))) : 'https://via.placeholder.com/640x360';
                                    $author = optional($article->author)->name;
                                @endphp
                                <article class="relative rounded-lg shadow hover:shadow-md transition overflow-hidden group h-52 sm:h-60">
                                    <a href="/articles/{{ $article->slug }}" class="block w-full h-full">
                                        <img src="{{ $img }}" alt="{{ $article->title }}" class="absolute inset-0 w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition-colors"></div>
                                        <div class="absolute inset-x-0 bottom-0 p-4 text-white">
                                            <h3 class="font-bold text-lg leading-snug line-clamp-2">{{ $article->title }}</h3>
                                            <p class="mt-1 text-[12px] opacity-90">{{ $author ? 'By ' . $author : 'By Unknown' }}</p>
                                        </div>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <!-- Main content -->
                    <div class="lg:col-span-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($rest as $article)
                                @php
                                    $img = $article->image_url ? (preg_match('/^https?:\/\//i',$article->image_url) ? $article->image_url : asset(ltrim($article->image_url,'/'))) : 'https://via.placeholder.com/640x360';
                                    $author = optional($article->author)->name;
                                @endphp
                                <!-- Others: standard cards with excerpts -->
                                <article class="bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden">
                                    <a href="/articles/{{ $article->slug }}" class="block">
                                        <div class="relative h-44">
                                            <img src="{{ $img }}"
                                                 alt="{{ $article->title }}"
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <div class="p-4">
                                            <h3 class="font-semibold text-base leading-snug line-clamp-2">{{ $article->title }}</h3>
                                            <div class="mt-2 text-[11px] text-gray-500 flex items-center justify-between">
                                                <span class="truncate">{{ $author ? 'By ' . $author : 'By Unknown' }}</span>
                                                <span class="ml-2 shrink-0">{{ optional($article->published_at)->format('M j, Y') }}</span>
                                            </div>
                                            @if($article->excerpt)
                                                <p class="mt-2 text-sm text-gray-700 line-clamp-3">{{ \Illuminate\Support\Str::limit(strip_tags($article->excerpt), 160) }}</p>
                                            @endif
                                        </div>
                                    </a>
                                </article>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $articles->links() }}
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <aside class="lg:col-span-1 space-y-8">
                        {{-- Sidebar Ad --}}
                        @include('partials.ad-slot', ['placement' => 'sidebar'])
                        @include('partials._recent_posts')
                    </aside>
                </div>
            @endif

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
        @endif
    </div>
@endsection
