<section class="lg:col-span-2 mb-12">
    <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-6 text-center">
        Kategorie Forum
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($categories as $category)
            <div class="bg-gray-200 dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-3">
                    {{ $category->name }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ $category->description }}
                </p>
                <a href="{{ route('categories.show', $category->id) }}" 
                   class="block text-center bg-gray-700 hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded-md text-sm transition">
                    Zobacz więcej
                </a>
            </div>
        @endforeach
    </div>
</section>
