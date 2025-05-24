<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edytuj post
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6 px-4">
        {{-- Upewnij się, że mamy enctype="multipart/form-data" --}}
        <form action="{{ route('categories.topics.update', [$category, $topic]) }}"
              method="POST"
              enctype="multipart/form-data"
              class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">

            @csrf
            @method('PUT')

            {{-- Błędy walidacji --}}
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

            {{-- Pole tytułu --}}
            <label for="title" class="block text-lg font-bold text-gray-800 dark:text-gray-200">
                Tytuł:
            </label>
            <input type="text"
                   name="title"
                   id="title"
                   value="{{ old('title', $topic->title) }}"
                   class="border p-2 w-full bg-gray-100 dark:bg-gray-700
                          text-gray-900 dark:text-gray-200 rounded-md
                          focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>

            {{-- Pole treści --}}
            <label for="content" class="block text-lg font-bold text-gray-800 dark:text-gray-200 mt-4">
                Treść:
            </label>
            <textarea name="content"
                      id="content"
                      rows="5"
                      class="border p-2 w-full bg-gray-100 dark:bg-gray-700
                             text-gray-900 dark:text-gray-200 rounded-md
                             focus:outline-none focus:ring-2 focus:ring-blue-500"
                      required>{{ old('content', $topic->content) }}</textarea>

            {{-- Sekcja obrazu (jeśli istnieje) --}}
            @if ($topic->image)
                <div class="mt-6">
                    {{-- Hidden, by checkbox zawsze miał parę klucz=wartość --}}
                    <input type="hidden" name="delete_image" value="0">

                    {{-- Checkbox „Usuń aktualne zdjęcie” --}}
                    <div class="flex items-center gap-2">
                        <input type="checkbox"
                               id="delete_image"
                               name="delete_image"
                               value="1"
                               class="hidden peer">
                        <label for="delete_image"
                               class="cursor-pointer flex items-center gap-2 bg-gray-200 dark:bg-gray-700
                                      px-4 py-2 rounded-md text-gray-900 dark:text-gray-200
                                      peer-checked:bg-red-600 peer-checked:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M9 4a1 1 0 00-1 1v1H4a1 1 0 000
                                       2h1v7a3 3 0 003 3h6a3 3 0 003-3V8h1a1
                                       1 0 100-2h-4V5a1 1 0 00-1-1H9zm3
                                       2V5H8v1h4zM8 9a1 1 0 011-1h2a1 1
                                       0 011 1v5a1 1 0 11-2 0v-4H9v4a1 1 0
                                       11-2 0V9z"
                                      clip-rule="evenodd" />
                            </svg>
                            Usuń aktualne zdjęcie
                        </label>
                    </div>

                    {{-- Podgląd aktualnego obrazu --}}
                    <div class="mt-4 w-1/4">
                        <a href="{{ asset($topic->image) }}" target="_blank">
                            <img src="{{ asset($topic->image) }}"
                                 class="rounded-lg shadow-lg hover:opacity-75 transition cursor-pointer">
                        </a>
                    </div>
                </div>
            @endif

            {{-- Dodawanie / podmiana obrazu --}}
            <div class="mt-6">
                <label for="image" class="block font-medium text-gray-700 dark:text-gray-300">
                    Zmień / dodaj nowe zdjęcie
                </label>
                <input type="file"
                       name="image"
                       id="image"
                       class="mt-2 block w-full text-sm text-gray-900 border border-gray-300
                              rounded-lg cursor-pointer bg-gray-50
                              dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600">
            </div>

            {{-- Przycisk zapisu --}}
            <button type="submit"
                    class="mt-6 bg-blue-500 text-white px-6 py-2 rounded-lg shadow
                           hover:bg-blue-600 transition">
                Zapisz zmiany
            </button>
        </form>
    </div>
</x-app-layout>
