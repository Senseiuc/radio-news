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
