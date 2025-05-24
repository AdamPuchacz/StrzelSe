<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dodaj nowy temat w dziale: <span class="text-blue-500">{{ $category->name }}</span>
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6 px-4">
        <form action="{{ route('topics.store', $category) }}" method="POST" enctype="multipart/form-data"
              class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 w-3/4 mx-auto">
            @csrf

            <!-- Komunikaty błędów -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-800 text-red-700 dark:text-red-200 rounded-md">
                    <strong>Błędy formularza:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tytuł -->
            <label for="title" class="block text-lg font-bold text-gray-800 dark:text-gray-200">Tytuł:</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                   class="border p-2 w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

            <!-- Treść -->
            <label for="content" class="block text-lg font-bold text-gray-800 dark:text-gray-200 mt-4">Treść:</label>
            <textarea name="content" id="content" rows="6" required
                      class="border p-2 w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content') }}</textarea>

            <!-- Obraz -->
            <label for="image" class="block text-lg font-bold text-gray-800 dark:text-gray-200 mt-4">Dodaj obraz (opcjonalnie):</label>
            <div class="relative flex items-center bg-gray-100 dark:bg-gray-700 rounded-md p-2">
                <input type="file" name="image" id="image" accept="image/*" class="hidden" onchange="updateFileName()">
                <label for="image" class="cursor-pointer bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600 transition">
                    Wybierz plik
                </label>
                <span id="file-name" class="ml-4 text-gray-600 dark:text-gray-300">Nie wybrano pliku</span>
            </div>

            <!-- Przycisk dodania tematu -->
            <button type="submit" class="mt-6 bg-green-500 text-white px-6 py-2 rounded-lg shadow hover:bg-green-600 transition">
                Dodaj temat
            </button>
        </form>
    </div>

    <script>
        function updateFileName() {
            const input = document.getElementById('image');
            const fileName = input.files.length > 0 ? input.files[0].name : 'Nie wybrano pliku';
            document.getElementById('file-name').textContent = fileName;
        }
    </script>
</x-app-layout>
