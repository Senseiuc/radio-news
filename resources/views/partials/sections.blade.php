<section class="my-8">
    <h2 class="text-xl font-bold mb-4 border-b pb-2">Politics</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @for($i = 1; $i <= 3; $i++)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <img src="https://via.placeholder.com/400x250" alt="Story">
                <div class="p-4">
                    <h3 class="font-semibold">Politics Story {{ $i }}</h3>
                    <p class="text-sm text-gray-600">Short description goes here.</p>
                </div>
            </div>
        @endfor
    </div>
</section>

<section class="my-8">
    <h2 class="text-xl font-bold mb-4 border-b pb-2">Business</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @for($i = 1; $i <= 3; $i++)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <img src="https://via.placeholder.com/400x250" alt="Story">
                <div class="p-4">
                    <h3 class="font-semibold">Business Story {{ $i }}</h3>
                    <p class="text-sm text-gray-600">Short description goes here.</p>
                </div>
            </div>
        @endfor
    </div>
</section>
