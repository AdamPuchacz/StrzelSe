<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-200 leading-tight">
            {{ __('Zawody strzeleckie') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-gray-200 dark:bg-gray-800 shadow-md rounded-lg">
        <h1 class="text-3xl font-bold mb-4 text-gray-800 dark:text-gray-200">Lista zawodów</h1>

        {{-- Przycisk "Dodaj zawody" --}}
        @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'verified'))
            <div class="mb-4">
                <a href="{{ route('shooting-competitions.create') }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">
                    Dodaj zawody
                </a>
            </div>
        @endif

        {{-- Tabela aktualnych zawodów --}}
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-2">Aktualne zawody</h2>
        <div class="overflow-x-auto mb-8">
            <table class="w-full border-collapse border border-gray-300 dark:border-gray-700 rounded-lg">
                <thead class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    <tr>
                        <th class="border px-4 py-2">Nazwa</th>
                        <th class="border px-4 py-2">Data</th>
                        <th class="border px-4 py-2">Lokalizacja</th>
                        <th class="border px-4 py-2">Liczba uczestników</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($currentCompetitions as $competition)
                        <tr class="bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-200">{{ $competition->title }}</td>
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($competition->date)->format('d.m.Y') }}
                            </td>
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-200">{{ $competition->location }}</td>
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-200">
                                {{ $competition->participants->count() }} 
                                @if ($competition->max_participants)
                                    / {{ $competition->max_participants }}
                                @else
                                    <span class="text-gray-500">Brak limitu</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-200">
                                @if(auth()->check() && auth()->user()->competitions->contains($competition))
                                    <span class="text-green-500 font-semibold">Zapisano</span>
                                @else
                                    <span class="text-gray-500">Nie zapisano</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('shooting-competitions.show', $competition) }}"
                                   class="text-blue-500 dark:text-blue-400 hover:underline">Zobacz</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border px-4 py-2 text-center text-gray-500 dark:text-gray-400">
                                Brak dostępnych zawodów.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tabela archiwalnych zawodów --}}
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-2">Archiwalne zawody</h2>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 dark:border-gray-700 rounded-lg">
                <thead class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    <tr>
                        <th class="border px-4 py-2">Nazwa</th>
                        <th class="border px-4 py-2">Data</th>
                        <th class="border px-4 py-2">Lokalizacja</th>
                        <th class="border px-4 py-2">Liczba uczestników</th>
                        <th class="border px-4 py-2">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($archivedCompetitions as $competition)
                        <tr class="bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-200">{{ $competition->title }}</td>
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-200">
                                {{ \Carbon\Carbon::parse($competition->date)->format('d.m.Y') }}
                            </td>
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-200">{{ $competition->location }}</td>
                            <td class="border px-4 py-2 text-gray-800 dark:text-gray-200">
                                {{ $competition->participants->count() }}
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('shooting-competitions.show', $competition) }}"
                                   class="text-blue-500 dark:text-blue-400 hover:underline">Zobacz</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="border px-4 py-2 text-center text-gray-500 dark:text-gray-400">
                                Brak archiwalnych zawodów.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
