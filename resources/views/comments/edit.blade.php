<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edytuj komentarz
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6 px-4">
        <form action="{{ route('comments.update', $comment) }}" method="POST" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            @csrf
            @method('PUT')

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

            <label for="content" class="block text-lg font-bold text-gray-800 dark:text-gray-200">Treść komentarza:</label>
<textarea name="content" id="content" rows="5" class="border p-2 w-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{old('content', $comment->content) }}</textarea>

            @if ($comment->image)
                <div class="mt-6">
                    <input type="hidden" name="delete_image" value="0">
                    
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="delete_image" name="delete_image" value="1" class="hidden peer">
                        <label for="delete_image" class="cursor-pointer flex items-center gap-2 bg-gray-200 dark:bg-gray-700 px-4 py-2 rounded-md text-gray-900 dark:text-gray-200 peer-checked:bg-red-600 peer-checked:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 4a1 1 0 00-1 1v1H4a1 1 0 000 2h1v7a3 3 0 003 3h6a3 3 0 003-3V8h1a1 1 0 100-2h-4V5a1 1 0 00-1-1H9zm3 2V5H8v1h4zM8 9a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 11-2 0v-4H9v4a1 1 0 11-2 0V9z" clip-rule="evenodd" />
                            </svg>
                            Usuń aktualne zdjęcie
                        </label>
                    </div>

                    <div class="mt-4 w-1/4">
                        <a href="{{ asset($comment->image) }}" target="_blank">
                            <img src="{{ asset($comment->image) }}" class="rounded-lg shadow-lg hover:opacity-75 transition cursor-pointer">
                        </a>
                    </div>
                </div>
            @endif

            <button type="submit" class="mt-6 bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                Zapisz zmiany
            </button>
        </form>
    </div>
</x-app-layout>
