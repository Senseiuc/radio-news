<header class="bg-white shadow" x-data="headerComponent()" x-init="load()" style="position: relative; z-index: 60;">
    <div class="container mx-auto px-4 py-4 grid grid-cols-2 md:grid-cols-3 items-center gap-4">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="/" class="flex items-center gap-2" aria-label="Homeland Radio Home">
                <img src="{{ asset('images/homeland_logo.png') }}" alt="Homeland Radio" class="h-16 w-auto">
            </a>
        </div>

        <!-- Desktop Search -->
        <div class="justify-self-center w-full hidden md:block md:mr-40">
            <form class="grid grid-cols-[1fr_auto] max-w-md w-full" action="{{ route('search.index') }}" method="get">
                <input
                    type="text"
                    name="q"
                    placeholder="Search articles..."
                    class="w-full border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <button type="submit" class="bg-blue-700 text-white px-4" aria-label="Search">
                    <i class="fa-solid fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Right Side -->
        <div class="justify-self-end flex items-center gap-3">
            <!-- Join Call icon/button -->
            <a href="{{ route('call.join') }}" class="hidden md:inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white h-9 px-3 rounded" title="Join Live Call" aria-label="Join Live Call">
                <i class="fas fa-video text-base leading-none"></i>
                <span class="text-sm font-medium leading-none">Join Call</span>
            </a>

            <!-- Mobile Search Toggle -->
            <button
                class="inline-flex items-center justify-center h-9 w-9 rounded text-blue-700 hover:bg-blue-50 md:hidden"
                :aria-expanded="isSearchOpen ? 'true' : 'false'"
                aria-controls="mobileSearchPanel"
                aria-label="Open search"
                type="button"
                @click="toggleSearch()"
            >
                🔍
            </button>

            <!-- Socials (Desktop only) -->
            <div class="hidden md:flex items-center gap-2">
                <a href="{{ $siteSettings->facebook_url ?? '#' }}"
                   class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-blue-700 text-white hover:bg-blue-800 transition"
                   aria-label="Facebook" target="_blank" rel="noopener">
                    <i class="fab fa-facebook-f text-sm"></i>
                </a>
                <a href="{{ $siteSettings->twitter_url ?? '#' }}"
                   class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-sky-500 text-white hover:bg-sky-600 transition"
                   aria-label="Twitter/X" target="_blank" rel="noopener">
                    <i class="fab fa-twitter text-sm"></i>
                </a>
                <a href="{{ $siteSettings->instagram_url ?? '#' }}"
                   class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-white hover:from-purple-600 hover:to-pink-600 transition"
                   aria-label="Instagram" target="_blank" rel="noopener">
                    <i class="fab fa-instagram text-sm"></i>
                </a>
                <a href="{{ $siteSettings->youtube_url ?? '#' }}"
                   class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-red-600 text-white hover:bg-red-700 transition"
                   aria-label="YouTube" target="_blank" rel="noopener">
                    <i class="fab fa-youtube text-sm"></i>
                </a>
                <a href="{{ $siteSettings->linkedin_url ?? '#' }}"
                   class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-blue-800 text-white hover:bg-blue-900 transition"
                   aria-label="LinkedIn" target="_blank" rel="noopener">
                    <i class="fab fa-linkedin-in text-sm"></i>
                </a>
                <a href="{{ isset($siteSettings->contact_email) ? 'mailto:'.$siteSettings->contact_email : '#' }}"
                   class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-blue-500 text-white hover:bg-blue-600 transition"
                   aria-label="Email">
                    <i class="fas fa-envelope text-sm"></i>
                </a>
                <a href="{{ $siteSettings->tiktok_url ?? '#' }}"
                   class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-pink-600 text-white hover:bg-pink-700 transition"
                   aria-label="TikTok" target="_blank" rel="noopener">
                    <i class="fab fa-tiktok text-sm"></i>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button
                class="bg-blue-700 text-white h-9 px-3 rounded"
                type="button"
                :aria-label="mobile.open ? 'Close menu' : 'Open menu'"
                :aria-expanded="mobile.open ? 'true' : 'false'"
                @click="mobile.open = !mobile.open; if(mobile.open){ document.documentElement.classList.add('overflow-hidden'); document.body.classList.add('overflow-hidden'); } else { document.documentElement.classList.remove('overflow-hidden'); document.body.classList.remove('overflow-hidden'); }"
            >
                ☰
            </button>
        </div>
    </div>

    <nav class="hidden md:block bg-white border-t border-gray-200" x-data="headerComponent()" x-init="load()">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-6 pr-4">
                <!-- Left: dynamic categories -->
                <div class="flex items-center space-x-6">
                    <a href="/" class="text-blue-700 font-semibold uppercase text-sm hover:text-blue-500">HOME</a>
                    <template x-for="cat in visibleCategories" :key="cat.id">
                        <a :href="'/articles?category=' + cat.slug"
                           class="uppercase text-sm hover:text-blue-500"
                           :class="selectedCategory() === cat.slug ? 'text-blue-700 font-semibold border-b-2 border-blue-700 pb-1' : 'text-gray-600'"
                           x-text="cat.name"></a>
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
                                <a :href="'/articles?category=' + cat.slug"
                                   class="block px-4 py-2 text-sm hover:bg-gray-100"
                                   :class="selectedCategory() === cat.slug ? 'text-blue-700 font-semibold' : 'text-gray-700'"
                                   role="menuitem" x-text="cat.name"></a>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Right: dynamic date -->
                <div class="text-gray-500 text-sm whitespace-nowrap" x-text="formatDate()"></div>
            </div>
        </div>
    </nav>

    <!-- Sidebar Drawer -->
    <div
        x-show="mobile.open"
        x-cloak
        class="fixed inset-y-0 left-0 z-50 flex pointer-events-none"
        @keydown.escape.window="mobile.open = false"
        x-transition:enter="transition-opacity duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <!-- Click-catcher (transparent, no darkening) -->
        <div class="fixed inset-0" @click="mobile.open = false; document.documentElement.classList.remove('overflow-hidden'); document.body.classList.remove('overflow-hidden');"></div>

        <!-- Sidebar Content -->
        <div
            class="relative w-80 max-w-full bg-white h-full shadow-lg flex flex-col p-4 pointer-events-auto will-change-transform overflow-y-auto"
            aria-label="Mobile menu"
            x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            style="backdrop-filter: none;"
        >
            <!-- Close -->
            <button class="absolute top-4 right-4 text-gray-600 hover:text-gray-900"
                    @click="mobile.open = false; document.documentElement.classList.remove('overflow-hidden'); document.body.classList.remove('overflow-hidden');"
                    aria-label="Close menu">✕</button>

            <!-- Logo -->
            <div class="mb-6">
                <a href="/" class="flex items-center gap-2">
                    <img src="{{ asset('images/homeland_logo.png') }}" alt="Homeland Radio" class="h-24 w-auto">
                    <span class="font-bold text-lg">HOMELAND</span>
                </a>
            </div>

            <!-- Search -->
            <form class="mb-4 flex" action="{{ route('search.index') }}" method="get">
                <input type="text" name="q" placeholder="Search articles..."
                       class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                <button type="submit" class="bg-blue-700 text-white px-4 rounded-r-md">
                    <i class="fa-solid fa-search"></i>
                </button>
            </form>

            <!-- Dynamic Categories -->
            <nav class="flex-1 space-y-2">
                <div class="text-xs font-semibold text-gray-500 mt-2">Quick Links</div>
                <a href="{{ route('call.join') }}" class="block py-2 border-b text-emerald-700 hover:text-emerald-800 font-medium" @click="mobile.open = false; document.documentElement.classList.remove('overflow-hidden'); document.body.classList.remove('overflow-hidden');">▶ Join Live Call</a>
                <a href="/privacy" class="block py-2 border-b text-gray-700 hover:text-blue-700" @click="mobile.open = false; document.documentElement.classList.remove('overflow-hidden'); document.body.classList.remove('overflow-hidden');">Privacy Policy</a>
                <a href="/terms" class="block py-2 border-b text-gray-700 hover:text-blue-700" @click="mobile.open = false; document.documentElement.classList.remove('overflow-hidden'); document.body.classList.remove('overflow-hidden');">Terms of Use</a>

                <div class="text-xs font-semibold text-gray-500 mt-4">Categories</div>
                <template x-for="cat in [...visibleCategories, ...moreCategories]" :key="cat.id">
                    <a :href="'/articles?category=' + cat.slug"
                       class="block py-2 border-b hover:text-blue-700"
                       :class="selectedCategory() === cat.slug ? 'text-blue-700 font-semibold' : 'text-gray-700'"
                       @click="mobile.open = false; document.documentElement.classList.remove('overflow-hidden'); document.body.classList.remove('overflow-hidden');"
                       x-text="cat.name"></a>
                </template>

                <div class="mt-4 pt-4 border-t">
                    <div class="text-xs font-semibold text-gray-500 mb-1">Account</div>
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 text-gray-700">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block py-2 text-gray-700">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block py-2 text-gray-700">Register</a>
                        @endif
                    @endauth
                </div>
            </nav>
        </div>
    </div>

    <!-- Mobile Search Panel -->
    <div id="mobileSearchPanel" class="md:hidden border-t border-gray-200"
         x-show="isSearchOpen"
         x-transition
         @keydown.escape.window="isSearchOpen=false"
         @click.outside="isSearchOpen=false">
        <div class="container mx-auto px-4 py-3">
            <form class="grid grid-cols-[1fr_auto]" action="{{ route('search.index') }}" method="get">
                <input type="text" name="q" placeholder="Search articles..."
                       class="w-full border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                <button type="submit" class="bg-blue-700 text-white px-4 rounded-r-md">Search</button>
            </form>
        </div>
    </div>
</header>

<script>
    // Optional: expose a global toggle for the player from the header (e.g., a Listen Live button could call window.toggleRadio())
    window.toggleRadio = function() {
        const root = document.querySelector('[x-data^="radioPlayer"]');
        if (!root) return;
        const comp = root.__x?.$data;
        if (comp && typeof comp.toggle === 'function') comp.toggle();
    }
</script>

<script>
    function headerComponent() {
        return {
            isSearchOpen: false,
            mobile: { open: false },
            categories: [],
            visibleCategories: [],
            moreCategories: [],
            toggleSearch() { this.isSearchOpen = !this.isSearchOpen; },
            async load() {
                try {
                    const res = await fetch('/api/categories');
                    if (res.ok) {
                        const data = await res.json();
                        this.categories = Array.isArray(data) ? data : (data.data ?? []);
                        this.visibleCategories = this.categories.slice(0, 8);
                        this.moreCategories = this.categories.slice(8);
                    }
                } catch (e) {
                    console.warn('Failed to load categories', e);
                }
            },
            formatDate() {
                return new Date().toLocaleDateString(undefined, {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            },
            selectedCategory() {
                const params = new URLSearchParams(window.location.search);
                return params.get('category');
            }
        }
    }
</script>
