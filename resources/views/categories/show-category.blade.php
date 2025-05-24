<x-app-layout>
    <x-slot name="header">
        <nav class="text-black dark:text-gray-300 text-sm font-semibold">
            <a href="{{ route('welcome') }}" class="hover:underline">Strona główna</a> >
            <span class="text-black dark:text-gray-300">{{ $category->name }}</span>
        </nav>
    </x-slot>

    <div class="container mx-auto mt-8">
        <p class="text-black dark:text-gray-300 mb-6">{{ $category->description }}</p>
        
        {{-- Przycisk dodania nowego tematu w tej kategorii --}}
        <a href="{{ route('topics.create', ['category' => $category]) }}" 
           class="bg-green-500 text-black px-4 py-2 rounded mb-4 inline-block">
            Dodaj nowy temat
        </a>

        {{-- Lista tematów w kategorii --}}
        <div class="grid grid-cols-1 gap-6">
    @forelse($topics as $topic)
        <div class="bg-white dark:bg-gray-800 shadow rounded p-4">
            <h2 class="text-xl font-bold">
                <a href="{{ route('topics.show', $topic) }}" class="text-blue-500">{{ $topic->title }}</a>
            </h2>
            <p class="text-gray-600 dark:text-gray-300">{{ Str::limit($topic->content, 100) }}</p>
            <p class="text-sm text-gray-500">
                Dodane przez {{ $topic->user->name }} | {{ $topic->created_at->diffForHumans() }}
            </p>

            <!-- Informacja o edytowaniu lub usunięciu -->
            @if($topic->deleted_by)
                <p class="text-red-500 text-sm mt-2">
                    @if($topic->deleted_by === 'moderator')
                        Usunięto przez moderatora z powodu naruszenia regulaminu
                    @elseif($topic->deleted_by === 'admin')
                        Usunięto przez administratora
                    @else
                        Usunięto przez autora
                    @endif
                </p>
            @elseif($topic->is_edited)
                <p class="text-gray-500 text-sm text-right">Edytowano</p>
            @endif

            <!-- Sekcja edycji i usuwania posta -->
            <div class="mt-4 flex gap-2">
                @can('update', $topic)
                    <a href="{{ route('categories.topics.edit', [$category, $topic]) }}"
                        class="px-3 py-1 bg-blue-600 dark:bg-blue-500 text-white rounded-md shadow-sm 
                            hover:bg-blue-500 dark:hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300">
                        Edytuj post
                    </a>
                @endcan

                @can('delete', $topic)
                    <form action="{{ route('categories.topics.destroy', [$category, $topic]) }}" method="POST"
                        onsubmit="return confirm('Czy na pewno chcesz usunąć ten post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-3 py-1 bg-red-600 dark:bg-red-500 text-white rounded-md shadow-sm 
                                hover:bg-red-500 dark:hover:bg-red-400 focus:outline-none focus:ring focus:ring-red-300">
                            Usuń post
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    @empty
        <p class="text-red-900 dark:text-red-400">Brak tematów w tej kategorii.</p>
    @endforelse
</div>
    </div>
</x-app-layout>
