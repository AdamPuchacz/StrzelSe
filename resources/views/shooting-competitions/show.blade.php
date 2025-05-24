<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $competition->title }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-gray-200 dark:bg-gray-800 shadow-md rounded-lg">
        <div class="flex items-start justify-between mb-4">
            {{-- Lewa strona - treść --}}
            <div class="flex-1 pr-4">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                    {{ $competition->title }}
                </h1>

                <p class="mt-4 text-gray-700 dark:text-gray-300">
                    <strong class="text-gray-800 dark:text-gray-200">Data:</strong>
                    {{ \Carbon\Carbon::parse($competition->date)->format('d.m.Y') }}
                </p>

                <p class="text-gray-700 dark:text-gray-300">
                    <strong class="text-gray-800 dark:text-gray-200">Lokalizacja:</strong>
                    {{ $competition->location }}
                </p>

                <p class="text-gray-700 dark:text-gray-300">
                    <strong class="text-gray-800 dark:text-gray-200">Opis:</strong>
                    {!! nl2br(e($competition->description)) !!}
                </p>

                {{-- Licznik uczestników --}}
                <p class="mt-4 text-gray-700 dark:text-gray-300">
                    <strong class="text-gray-800 dark:text-gray-200">Liczba uczestników:</strong>
                    {{ $competition->participants->count() }}
                    @if ($competition->max_participants)
                        / {{ $competition->max_participants }}
                    @else
                        <span class="text-gray-500">Brak limitu</span>
                    @endif
                </p>

                {{-- Komunikat o pełnym limicie uczestników --}}
                @if ($competition->max_participants && $competition->participants->count() >= $competition->max_participants)
                    <p class="text-red-500 font-semibold mt-2">Lista uczestników jest już pełna.</p>
                @endif

                {{-- Przyciski zapisu/wypisu --}}
                <div class="mt-4">
                    @if (!$isArchived)
                        @if($lessThanOneDay)
                            {{-- Gdy do zawodów pozostało mniej niż 1 dzień --}}
                            <p class="text-red-500 font-semibold mt-2">
                                Nie można się już zapisać – zostało mniej niż 1 dzień do zawodów.
                            </p>
                        @else
                            {{-- Normalna logika zapisu, jeżeli nie minął deadline --}}
                            @auth
                                @if(!$competition->participants->contains(auth()->user()))
                                    @if (!$competition->max_participants || $competition->participants->count() < $competition->max_participants)
                                        <form action="{{ route('shooting-competitions.join', $competition) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded 
                                                           dark:bg-green-600 dark:hover:bg-green-700 transition">
                                                Zapisz się
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <form action="{{ route('shooting-competitions.leave', $competition) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded 
                                                       dark:bg-red-600 dark:hover:bg-red-700 transition">
                                            Wypisz się
                                        </button>
                                    </form>
                                @endif
                            @else
                                <p class="text-gray-600 dark:text-gray-400">
                                    Aby zapisać się na zawody, musisz być
                                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline dark:text-blue-400">zalogowany</a>.
                                </p>
                            @endauth
                        @endif
                    @endif

                    @auth
                        @if (auth()->user()->role === 'admin' || auth()->id() === $competition->created_by)
                            <a href="{{ route('shooting-competitions.download-report', $competition->id) }}"
                               class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded 
                                      dark:bg-blue-600 dark:hover:bg-blue-700 transition mt-4">
                                Pobierz raport uczestników
                            </a>
                        @endif
                    @endauth
                </div>

                <div class="mt-6">
                    <a href="{{ route('shooting-competitions.index') }}"
                       class="text-blue-500 hover:underline dark:text-blue-400">
                        ← Wróć do listy zawodów
                    </a>
                </div>
            </div>

            {{-- Prawa strona - zdjęcie --}}
            @if($competition->image_path)
                <div class="flex-shrink-0 ml-4 mt-2" x-data="{ zoomed: false }">
                    <img src="{{ asset('storage/' . $competition->image_path) }}"
                         alt="{{ $competition->title }}"
                         class="w-64 h-auto rounded shadow-md object-cover cursor-pointer"
                         @click="zoomed = true">

                    {{-- Powiększone zdjęcie --}}
                    <div x-show="zoomed"
                         x-transition.opacity
                         class="fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center"
                         @click="zoomed = false">
                        <img src="{{ asset('storage/' . $competition->image_path) }}"
                             alt="{{ $competition->title }}"
                             class="max-w-full max-h-screen shadow-lg rounded">
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
