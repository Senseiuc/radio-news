<section
    x-data="featuredNews()"
    x-init="fetchNews()"
    class="container mx-auto px-4 py-8 grid md:grid-cols-5 gap-6"
>
    {{-- Featured Slider --}}
    <div class="md:col-span-3 relative overflow-hidden">
        <template x-if="featured.length > 0">
            <div class="relative w-full h-[340px] lg:h-[420px] rounded-lg shadow-md">
                <template x-for="(story, index) in featured" :key="story.id">
                    <div
                        x-show="currentIndex === index"
                        class="absolute inset-0 transition-opacity duration-700 ease-in-out"
                        x-transition.opacity
                    >
                        <img :src="story.image_url || 'https://via.placeholder.com/800x400'"
                             class="w-full h-full object-cover rounded-lg" :alt="story.title">

                        <div class="absolute inset-0 bg-black/50 rounded-lg p-6 flex flex-col justify-end text-white pointer-events-none">
                            <span class="text-xs lg:text-sm uppercase tracking-wide text-red-400" x-text="story.category || 'Uncategorized'"></span>
                            <h2 class="text-xl lg:text-2xl font-bold mt-1.5 lg:mt-2 leading-snug" x-text="story.title"></h2>
                            <p class="text-[11px] lg:text-sm mt-1 opacity-90">
                                <span x-text="'By ' + (story.author || 'Unknown')"></span> ·
                                <span x-text="formatDate(story.published_at)"></span>
                            </p>
                        </div>

                        <!-- Clickable overlay link -->
                        <template x-if="story.slug">
                            <a class="absolute inset-0 z-10" :href="'/articles/' + story.slug" :aria-label="story.title">
                                <span class="sr-only" x-text="story.title"></span>
                            </a>
                        </template>
                    </div>
                </template>
            </div>
        </template>

        {{-- Slider Dots --}}
        <div class="absolute inset-x-0 bottom-4 flex justify-center space-x-2 z-20" x-show="featured.length > 1">
            <template x-for="(story, index) in featured" :key="index">
                <button
                    class="w-2.5 h-2.5 rounded-full transition"
                    :class="currentIndex === index ? 'bg-white' : 'bg-white/60 hover:bg-white'"
                    @click="goToSlide(index)"
                ></button>
            </template>
        </div>
    </div>

    {{-- Top Featured News Cards --}}
    <div
        class="md:col-span-2"
        :class="limitedTopFeatured().length > 3 ? 'grid grid-cols-1 sm:grid-cols-2 gap-3' : 'space-y-3'"
    >
        <template x-for="news in limitedTopFeatured()" :key="news.id">
            <article class="relative group bg-white rounded-md border border-gray-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                <template x-if="news.slug">
                    <a :href="'/articles/' + news.slug" class="absolute inset-0 z-10" :aria-label="news.title">
                        <span class="sr-only" x-text="news.title"></span>
                    </a>
                </template>
                <div class="grid grid-cols-[72px_1fr] sm:grid-cols-[84px_1fr] grid-rows-[1fr_auto] gap-3 p-3 h-24 sm:h-28 pointer-events-none">
                    <img
                        :src="news.image_url || 'https://via.placeholder.com/120x80'"
                        :alt="news.title"
                        class="w-[72px] h-[72px] sm:w-[84px] sm:h-[84px] object-cover rounded col-start-1 row-start-1"
                    >
                    <h3
                        class="col-start-2 row-start-1 font-semibold text-gray-900 text-sm leading-snug line-clamp-2 group-hover:text-gray-700 transition-colors"
                        x-text="news.title"
                    ></h3>

                    <!-- Author/date stands alone below the photo and title -->
                    <div class="col-span-2 row-start-2 flex items-center justify-between text-[11px] text-gray-500">
                        <span class="truncate"
                              x-text="(typeof news.author === 'object' && news.author) ? ('By ' + (news.author.name || 'Unknown')) : ('By ' + (news.author || 'Unknown'))">
                        </span>
                        <span class="ml-2 shrink-0" x-text="formatDate(news.published_at)"></span>
                    </div>
                </div>
            </article>
        </template>
    </div>
</section>

<script>
    function featuredNews() {
        return {
            featured: [],
            topFeatured: [],
            currentIndex: 0,
            interval: null,

            fetchNews() {
                fetch('/api/articles/featured')
                    .then(res => res.json())
                    .then(data => {
                        this.featured = data.featured || [];
                        this.topFeatured = data.top || [];
                        this.startAutoSlide();
                    })
                    .catch(err => console.error('Failed to load news:', err));
            },

            startAutoSlide() {
                if (this.featured.length > 1) {
                    this.interval = setInterval(() => {
                        this.currentIndex = (this.currentIndex + 1) % this.featured.length;
                    }, 5000);
                }
            },

            goToSlide(index) {
                this.currentIndex = index;
            },

            formatDate(dateString) {
                if (!dateString) return '';
                const date = new Date(dateString);
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            },

            // Return up to 6 items for Top Featured
            limitedTopFeatured() {
                const items = this.topFeatured || [];
                return items.slice(0, 6);
            }
        }
    }
</script>
