<section
    x-data="categoriesBoard()"
    x-init="init()"
    class="container mx-auto px-4 py-10 space-y-12 relative"
>
    <template x-if="loading && categories.length === 0">
        <div class="text-center text-gray-500">Loading categories…</div>
    </template>

    <template x-for="(cat, idx) in categories" :key="cat.slug">
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-extrabold tracking-tight flex items-center gap-2">
                    <span class="inline-block w-1.5 h-6 rounded bg-red-600"></span>
                    <span x-text="cat.name"></span>
                </h2>
                <a :href="'/articles?category=' + cat.slug" class="text-sm text-red-600 hover:underline">View all</a>
            </div>

            <!-- Grid: first is featured (big), next are standard cards -->
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Featured card (main) -->
                <template x-if="(cat.articles || []).length > 0">
                    <article class="md:col-span-1 bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden group flex flex-col relative">
                        <a :href="'/articles/' + cat.articles[0].slug" class="absolute inset-0 z-10" :aria-label="cat.articles[0].title">
                            <span class="sr-only" x-text="cat.articles[0].title"></span>
                        </a>
                        <div class="relative h-56 md:h-72">
                            <img :src="cat.articles[0].image_url || 'https://via.placeholder.com/800x460'"
                                 :alt="cat.articles[0].title"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-5 md:p-6 flex flex-col flex-grow">
                <span class="text-[10px] uppercase tracking-wide text-red-600 mb-1"
                      x-text="(cat.articles[0].categories && cat.articles[0].categories[0]) ? cat.articles[0].categories[0].name : cat.name"></span>
                            <h3 class="text-xl md:text-2xl font-bold leading-snug group-hover:underline" x-text="cat.articles[0].title"></h3>
                            <div class="mt-2 text-[12px] text-gray-500 flex items-center gap-2">
                                <span x-text="(cat.articles[0].author && cat.articles[0].author.name) ? ('By ' + cat.articles[0].author.name) : (cat.articles[0].author ? ('By ' + cat.articles[0].author) : 'By Unknown')"></span>
                                <span>·</span>
                                <span x-text="formatDate(cat.articles[0].published_at)"></span>
                            </div>
                            <p class="mt-2 text-[13px] md:text-sm text-gray-700 line-clamp-3"
                               x-text="cat.articles[0].excerpt"></p>
                        </div>
                    </article>
                </template>

                <!-- Smaller cards (double column on right) -->
                <!-- Smaller cards (3 per row on desktop) -->
                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="item in (cat.articles || []).slice(1, 7)" :key="item.id">
                        <article class="bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden">
                            <a :href="'/articles/' + item.slug" class="block">
                                <div class="relative h-36 md:h-40">
                                    <img :src="item.image_url || 'https://via.placeholder.com/480x270'"
                                         :alt="item.title"
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="p-3.5">
                                    <h4 class="font-semibold text-[15px] leading-snug line-clamp-2"
                                        x-text="item.title"></h4>
                                    <p class="mt-1 text-[12px] text-gray-500"
                                       x-text="formatDate(item.published_at)"></p>
                                </div>
                            </a>
                        </article>
                    </template>
                </div>

            </div>
        </div>
    </template>

    <!-- Sentinel for infinite scroll -->
    <div x-ref="sentinel" class="h-10"></div>

    <!-- Back to top button -->
    <button
        x-show="showBackToTop"
        @click="scrollToTop()"
        class="fixed bottom-6 left-6 bg-blue-700 text-white rounded-full shadow-lg px-4 py-2 text-sm"
        aria-label="Back to top"
    >↑ Top</button>
</section>

<script>
    function categoriesBoard() {
        return {
            // State
            allCategories: [],
            categories: [],
            loading: false,
            loadingMore: false,
            pageSize: 4,
            nextIndex: 0,
            observer: null,
            showBackToTop: false,

            async init() {
                this.loading = true;
                try {
                    const res = await fetch('/api/categories');
                    const payload = await res.json();
                    const cats = (payload && payload.data) ? payload.data : payload; // Laravel Resource or raw array
                    this.allCategories = (cats || []).map(c => ({ ...c }));

                    // Initial batch
                    await this.loadMore();

                    // Setup IntersectionObserver for infinite scroll
                    this.$nextTick(() => {
                        const sentinel = this.$refs.sentinel;
                        if ('IntersectionObserver' in window && sentinel) {
                            this.observer = new IntersectionObserver(async (entries) => {
                                for (const entry of entries) {
                                    if (entry.isIntersecting) {
                                        await this.loadMore();
                                    }
                                }
                            }, { rootMargin: '200px' });
                            this.observer.observe(sentinel);
                        }
                    });

                    // Back to top visibility
                    window.addEventListener('scroll', () => {
                        this.showBackToTop = window.scrollY > 400;
                    }, { passive: true });
                } catch (e) {
                    console.error('Failed to load categories', e);
                } finally {
                    this.loading = false;
                }
            },

            async loadMore() {
                if (this.loadingMore) return;
                if (this.nextIndex >= this.allCategories.length) return;
                this.loadingMore = true;
                const slice = this.allCategories.slice(this.nextIndex, this.nextIndex + this.pageSize);
                this.nextIndex += this.pageSize;

                // For each category in this slice, fetch its articles; only append if it has any
                for (let cat of slice) {
                    try {
                        const r = await fetch(`/api/articles?category=${encodeURIComponent(cat.slug)}&page=1`);
                        const data = await r.json();
                        const items = (data && data.data) ? data.data : [];
                        if ((items || []).length > 0) {
                            const catWithArticles = { ...cat, articles: items.slice(0, 7) }; // 1 featured + up to 6 small
                            this.categories.push(catWithArticles);
                        }
                    } catch (e) {
                        console.warn('Failed to load articles for category', cat.slug, e);
                    }
                }

                // If finished all, disconnect observer
                if (this.nextIndex >= this.allCategories.length && this.observer) {
                    this.observer.disconnect();
                }
                this.loadingMore = false;
            },

            scrollToTop() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },

            formatDate(dateString) {
                if (!dateString) return '';
                const date = new Date(dateString);
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            }
        }
    }
</script>
