<section
    x-data="featuredNews()"
    x-init="fetchNews()"
    class="container mx-auto px-4 py-8 grid md:grid-cols-3 gap-6"
>
    {{-- Featured Slider --}}
    <div class="md:col-span-2 relative overflow-hidden">
        <template x-if="featured.length > 0">
            <div class="relative w-full h-[400px] rounded-lg shadow-md">
                <template x-for="(story, index) in featured" :key="story.id">
                    <div
                        x-show="currentIndex === index"
                        class="absolute inset-0 transition-opacity duration-700 ease-in-out"
                        x-transition.opacity
                    >
                        <img :src="story.image_url || 'https://via.placeholder.com/800x400'"
                             class="w-full h-full object-cover rounded-lg" :alt="story.title">

                        <div class="absolute inset-0 bg-black/50 rounded-lg p-6 flex flex-col justify-end text-white">
                            <span class="text-sm uppercase tracking-wide text-red-400" x-text="story.category || 'Uncategorized'"></span>
                            <h2 class="text-2xl font-bold mt-2" x-text="story.title"></h2>
                            <p class="text-sm mt-1">
                                <span x-text="'By ' + (story.author || 'Unknown')"></span> ·
                                <span x-text="formatDate(story.published_at)"></span>
                            </p>
                        </div>
                    </div>
                </template>
            </div>
        </template>

        {{-- Slider Dots --}}
        <div class="absolute inset-x-0 bottom-4 flex justify-center space-x-2" x-show="featured.length > 1">
            <template x-for="(story, index) in featured" :key="index">
                <button
                    class="w-3 h-3 rounded-full transition"
                    :class="currentIndex === index ? 'bg-white' : 'bg-white/60 hover:bg-white'"
                    @click="goToSlide(index)"
                ></button>
            </template>
        </div>
    </div>

    {{-- Top Featured News Cards --}}
    <div class="space-y-4">
        <template x-for="news in topFeatured" :key="news.id">
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-lg flex gap-4">
                <img :src="news.image_url || 'https://via.placeholder.com/120x80'"
                     class="w-24 h-16 object-cover rounded-md" :alt="news.title">
                <div>
                    <h3 class="font-semibold text-gray-800 text-sm line-clamp-2" x-text="news.title"></h3>
                    <p class="text-xs text-gray-500 mt-1" x-text="'By ' + (news.author || 'Unknown')"></p>
                </div>
            </div>
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
            }
        }
    }
</script>
