<x-app-layout>
    @if(session('success'))
        <div class="p-4 bg-green-200 dark:bg-green-800 shadow rounded-lg text-center mb-4">
            <p class="text-lg text-green-800 dark:text-green-200 font-semibold">
                {{ session('success') }}
            </p>
        </div>
    @endif

    {{-- Gdy nie można złożyć nowego wniosku, wyświetlamy status starego --}}
    @if($lastRequest && !$canResubmit)
        <div class="p-4 bg-gray-200 dark:bg-gray-800 shadow rounded-lg text-center mb-6">
            <p class="text-lg text-gray-800 dark:text-gray-200 font-semibold">
                Status Twojego wniosku:
                <span class="{{ $statusColor }}">{{ $statusText }}</span>
            </p>

            @if($lastRequest->status === 'rejected' && $daysLeft > 0)
                <p class="text-sm text-red-500 dark:text-red-400 mt-2">
                    Liczba dni pozostała do możliwości złożenia nowego wniosku:
                    <strong>{{ $daysLeft }}</strong>
                </p>
            @endif
        </div>
    @endif

    {{-- Formularz zgłoszeniowy wyświetlamy tylko gdy $canResubmit = true --}}
    @if($canResubmit)
        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6 text-center">
            Formularz zgłoszeniowy
        </h3>

        <div class="max-w-3xl mx-auto">
            @if($errors->any())
                <div class="bg-red-200 dark:bg-red-800 p-4 rounded-lg mb-6">
                    <ul class="list-disc list-inside text-red-600 dark:text-red-200">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('verification.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white dark:bg-gray-800 p-6 shadow rounded-lg">
                @csrf

                {{-- Imię --}}
                <div>
                    <label for="first_name" class="block font-medium text-gray-700 dark:text-gray-300">Imię</label>
                    <input type="text" id="first_name" name="first_name" required 
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg p-2"
                           value="{{ old('first_name') }}">
                </div>

                {{-- Nazwisko --}}
                <div>
                    <label for="last_name" class="block font-medium text-gray-700 dark:text-gray-300">Nazwisko</label>
                    <input type="text" id="last_name" name="last_name" required 
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg p-2"
                           value="{{ old('last_name') }}">
                </div>

                {{-- Numer telefonu --}}
                <div>
                    <label for="phone" class="block font-medium text-gray-700 dark:text-gray-300">Numer telefonu</label>
                    <input type="text" id="phone" name="phone" required 
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg p-2"
                           value="{{ old('phone') }}">
                </div>

                {{-- Region --}}
                <div>
                    <label for="region" class="block font-medium text-gray-700 dark:text-gray-300">Obszar organizowania zawodów</label>
                    <input type="text" id="region" name="region" required 
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg p-2"
                           value="{{ old('region') }}">
                </div>

                {{-- Załączniki --}}
                <div>
                    <label for="attachments" class="block font-medium text-gray-700 dark:text-gray-300">Dodaj pliki (zdjęcia/PDF)</label>
                    <input type="file" id="attachments" name="attachments[]" multiple 
                           class="w-full text-gray-900 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg p-2">
                </div>

                {{-- Przycisk Wyślij --}}
                <div class="text-center">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded transition">
                        Wyślij zgłoszenie
                    </button>
                </div>
            </form>
        </div>
    @endif
</x-app-layout>
