<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-200 leading-tight">
            {{ __('Dodaj nowe zawody') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{-- Wyświetlanie błędów walidacji --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <strong class="block font-bold mb-2">Ups! Wystąpiły błędy:</strong>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formularz dodawania zawodów --}}
        <form action="{{ route('shooting-competitions.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-gray-200 dark:bg-gray-800 p-6 rounded-lg shadow-md">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-gray-700 dark:text-gray-300">Nazwa zawodów</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required
                       class="w-full mt-2 p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Wprowadź nazwę zawodów">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 dark:text-gray-300">Opis</label>
                <textarea id="description" name="description" required
                          class="w-full mt-2 p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Podaj krótki opis zawodów">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="date" class="block text-gray-700 dark:text-gray-300">Data</label>
                <input type="date" id="date" name="date" required
                       class="w-full mt-2 p-2 border rounded bg-gray-50 text-gray-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                       min="{{ \Carbon\Carbon::now()->addDays(2)->format('Y-m-d') }}">
            </div>

            <div class="mb-4">
                <label for="location" class="block text-gray-700 dark:text-gray-300">Lokalizacja</label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" required
                       class="w-full mt-2 p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Podaj miejsce zawodów">
            </div>

            <div class="mb-4">
                <label for="max_participants" class="block text-gray-700 dark:text-gray-300">Limit uczestników (opcjonalnie):</label>
                <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants') }}"
                       class="w-full mt-2 p-2 border rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                       min="1" placeholder="Pozostaw puste, jeśli brak limitu">
            </div>

            {{-- Dodawanie zdjęcia --}}
            <div class="mb-4">
                <label for="image" class="block text-gray-700 dark:text-gray-300">Zdjęcie (opcjonalnie)</label>
                <input type="file" id="image" name="image"
                       class="mt-2 block w-full border rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 file:bg-gray-300 file:border-none file:px-4 file:py-2 file:rounded file:cursor-pointer">
            </div>

            <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                Dodaj zawody
            </button>
        </form>
    </div>
</x-app-layout>