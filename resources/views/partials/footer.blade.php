<footer class="bg-gray-900 text-gray-300 mt-12">
    {{-- Footer Ad --}}
    @include('partials.ad-slot', ['placement' => 'footer'])
    <div class="container mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-4 gap-8">
        <div>
            <a href="/" class="inline-flex items-center gap-2 mb-3">
                <img src="{{ asset('images/homeland_logo.png') }}" alt="Homeland Radio" class="h-8 w-auto">
            </a>
            <p class="text-sm">Homeland delivers the latest news across politics, business, tech, and culture.</p>
        </div>
        <div>
            <h4 class="font-bold mb-2">Sections</h4>
            <ul class="space-y-1 text-sm">
                <li><a href="/articles?category=politics" class="hover:underline">Politics</a></li>
                <li><a href="/articles?category=business" class="hover:underline">Business</a></li>
                <li><a href="/articles?category=tech" class="hover:underline">Tech</a></li>
                <li><a href="/articles?category=sports" class="hover:underline">Sports</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold mb-2">Legal</h4>
            <ul class="space-y-1 text-sm">
                <li><a href="/privacy" class="hover:underline">Privacy Policy</a></li>
                <li><a href="/terms" class="hover:underline">Terms of Use</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold mb-2">Contact</h4>
            <p class="text-sm">Email: {{ $siteSettings->contact_email ?? 'contact@homeland.com' }}</p>
        </div>
    </div>
    <div class="border-t border-gray-800">
        <div class="container mx-auto px-4 py-4 text-xs text-gray-400 flex flex-col sm:flex-row items-center justify-between gap-2">
            <span>&copy; {{ date('Y') }} Homeland News. All rights reserved.</span>
            <div class="space-x-4">
                <a href="/privacy" class="hover:underline">Privacy Policy</a>
                <a href="/terms" class="hover:underline">Terms of Use</a>
            </div>
        </div>
    </div>
</footer>
