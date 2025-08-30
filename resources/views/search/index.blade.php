@extends('layouts.app')

@section('title', ($q ? 'Search: '.$q : 'Search').' | Homeland News')
@section('meta_description', $q ? ('Search results for '.$q.' on Homeland News') : 'Search Homeland News for the latest stories and updates')
@section('canonical', route('search.index', ['q' => $q]))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-extrabold tracking-tight">Search</h1>
        <form class="hidden md:block" action="{{ route('search.index') }}" method="get">
            <label class="sr-only" for="q">Search</label>
            <input id="q" name="q" value="{{ $q }}" type="text" placeholder="Search articles..." class="border border-gray-300 rounded-l-md px-3 py-2">
            <button class="bg-blue-700 text-white px-4 py-2 rounded-r-md">Search</button>
        </form>
    </div>

    @if(! $q)
        <div class="bg-white border border-gray-200 rounded-lg p-6 text-gray-600">Type a keyword in the search box.</div>
    @elseif($articles->count() === 0)
        <div class="bg-white border border-gray-200 rounded-lg p-6 text-gray-600">No results for "{{ $q }}".</div>
    @else
        <p class="text-sm text-gray-600 mb-3">Showing {{ $articles->total() }} results for "{{ $q }}"</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($articles as $article)
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
    @endif
</div>
@endsection
