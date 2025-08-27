<header class="bg-white shadow" x-data="headerComponent()" x-init="load()">
    <div class="container mx-auto px-4 py-4 grid grid-cols-2 md:grid-cols-3 items-center gap-4">
        <div class="flex items-center">
            <span class="text-xl font-bold text-blue-700">Home Land</span>
        </div>

        <div class="justify-self-center w-full hidden md:block">
            <form class="grid grid-cols-[1fr_auto] max-w-md w-full" @submit.prevent>
                <input
                    type="text"
                    placeholder="Type and hit enter..."
                    class="w-full border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <button type="submit" class="bg-blue-700 text-white px-4" aria-label="Search">
                    <i class="fa-solid fa-search"></i>
                </button>
            </form>
        </div>

        <div class="justify-self-end flex items-center gap-2">
            <button
                class="p-2 rounded text-blue-700 hover:bg-blue-50 md:hidden"
                :aria-expanded="isSearchOpen ? 'true' : 'false'"
                aria-controls="mobileSearchPanel"
                aria-label="Open search"
                type="button"
                @click="toggleSearch()"
            >
                🔍
            </button>

            <div class="hidden md:flex items-center gap-2">
                <a href="#" class="bg-blue-700 text-white py-1.5 px-3 " aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="bg-sky-500 text-white py-1.5 px-3" aria-label="Twitter/X"><i class="fab fa-twitter"></i></a>
                <a href="#" class="bg-gradient-to-r from-purple-500 to-pink-500 text-white py-1.5 px-3" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" class="bg-red-600 text-white py-1.5 px-3" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="#" class="bg-blue-500 text-white py-1.5 px-3" aria-label="Email"><i class="fas fa-envelope"></i></a>
                <a href="#" class="bg-blue-800 text-white py-1.5 px-3" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="bg-pink-600 text-white py-1.5 px-3" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
            </div>

            <button class="bg-blue-700 text-white py-1.5 px-3 rounded" type="button" aria-label="Open menu">
                ☰
            </button>
        </div>
    </div>

    <div id="mobileSearchPanel" class="md:hidden border-t border-gray-200" x-show="isSearchOpen" x-transition @keydown.escape.window="isSearchOpen=false" @click.outside="isSearchOpen=false">
        <div class="container mx-auto px-4 py-3">
            <form class="grid grid-cols-[1fr_auto]" @submit.prevent>
                <input
                    type="text"
                    placeholder="Type and hit enter..."
                    class="w-full border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <button type="submit" class="bg-blue-700 text-white px-4 rounded-r-md">
                    Search
                </button>
            </form>
        </div>
    </div>
</header>

<nav class="hidden md:block bg-white border-t border-gray-200" x-data="headerComponent()" x-init="load()">
  <div class="container mx-auto px-4">
    <div class="flex items-center justify-between py-6 pr-4">
      <!-- Left: dynamic categories -->
      <div class="flex items-center space-x-6">
        <a href="/" class="text-blue-700 font-semibold uppercase text-sm hover:text-blue-500">HOME</a>
        <template x-for="cat in visibleCategories" :key="cat.id">
            <a :href="'/articles?category=' + cat.slug" class="text-gray-600 uppercase text-sm hover:text-blue-500" x-text="cat.name"></a>
        </template>
        <div class="relative group pb-2" x-data="{ open: false }" x-show="moreCategories.length > 0" @mouseenter="open = true" @mouseleave="open = false">
          <button class="flex items-center text-gray-600 uppercase text-sm hover:text-blue-500 pt-2" aria-haspopup="menu" :aria-expanded="open ? 'true' : 'false'">
            MORE
            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>

          <div
            class="absolute left-0 top-full z-10 w-48 rounded-md border border-gray-200 bg-white shadow-lg py-2"
            x-show="open"
            x-transition
            role="menu"
          >
            <template x-for="cat in moreCategories" :key="cat.id">
              <a :href="'/articles?category=' + cat.slug" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" x-text="cat.name"></a>
            </template>
          </div>
        </div>
      </div>

      <!-- Right: dynamic date -->
      <div class="text-gray-500 text-sm whitespace-nowrap" x-text="formatDate()"></div>
    </div>
  </div>
</nav>

<script>
    function headerComponent() {
        return {
            isSearchOpen: false,
            categories: [],
            visibleCategories: [],
            moreCategories: [],
            toggleSearch() { this.isSearchOpen = !this.isSearchOpen; },
            async load() {
                try {
                    const res = await fetch('/api/categories');
                    if (res.ok) {
                        const data = await res.json();
                        // If it's a Laravel Resource collection, data.data holds items
                        this.categories = Array.isArray(data) ? data : (data.data ?? []);
                        // Use API-provided order (sort_order), then split into visible/more
                        this.visibleCategories = this.categories.slice(0, 8);
                        this.moreCategories = this.categories.slice(8);
                    }
                } catch (e) {
                    console.warn('Failed to load categories', e);
                }
            },
            formatDate() {
                try {
                    return new Date().toLocaleDateString(undefined, { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                } catch (e) {
                    return '';
                }
            }
        }
    }
</script>
