<section class="bg-red-600 text-white py-2" x-data="trendingBar()" x-init="load()">
    <div class="container mx-auto px-4 flex items-center space-x-4">
        <span class="font-bold">Trending Now:</span>
        <template x-if="items.length > 0">
            <marquee class="text-sm">
                <template x-for="(item, idx) in items" :key="item.id">
                    <span>
                        <a :href="'/articles/' + item.slug" class="underline hover:no-underline text-white" x-text="item.title"></a>
                        <span x-show="idx < items.length - 1"> • </span>
                    </span>
                </template>
            </marquee>
        </template>
        <template x-if="items.length === 0">
            <marquee class="text-sm opacity-80">No trending posts right now</marquee>
        </template>
    </div>
    <script>
        function trendingBar() {
            return {
                items: [],
                async load() {
                    try {
                        const res = await fetch('/api/articles/trending');
                        if (res.ok) {
                            const data = await res.json();
                            this.items = Array.isArray(data) ? data : (data.data ?? []);
                        }
                    } catch (e) {
                        console.warn('Failed to load trending articles', e);
                    }
                }
            }
        }
    </script>
</section>
