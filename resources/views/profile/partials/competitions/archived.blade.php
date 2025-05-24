@php
    $archivedCompetitions = auth()->user()->competitions
        ->filter(fn($competition) => \Carbon\Carbon::parse($competition->date)->isPast());
@endphp

<h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-5">Archiwalne zawody</h4>

@if($archivedCompetitions->count() > 0)
    <ul class="space-y-3 mt-2">
        @foreach($archivedCompetitions as $competition)
            <li class="p-4 bg-white dark:bg-gray-700 rounded-lg">
                <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $competition->title }}</h4>
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Data: {{ \Carbon\Carbon::parse($competition->date)->format('d.m.Y') }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Lokalizacja: {{ $competition->location }}
                </p>
                <a href="{{ route('shooting-competitions.show', $competition) }}" 
                   class="text-blue-500 hover:underline dark:text-blue-400 text-sm">
                    Zobacz szczegóły
                </a>
            </li>
        @endforeach
    </ul>
@else
    <p class="text-gray-600 dark:text-gray-400 mt-1">Brak archiwalnych zawodów.</p>
@endif
