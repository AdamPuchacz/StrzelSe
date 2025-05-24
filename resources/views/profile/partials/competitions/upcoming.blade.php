@php
    $upcomingCompetitions = auth()->user()->competitions
        ->filter(fn($competition) => \Carbon\Carbon::parse($competition->date)->isFuture());
@endphp

<h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-4">Nadchodzące zawody</h4>

@if($upcomingCompetitions->count() > 0)
    <ul class="space-y-3 mt-2">
        @foreach($upcomingCompetitions as $competition)
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

                {{-- Przyciski do kalendarza Google i Outlook --}}
                @php
                    $startGoogle = \Carbon\Carbon::parse($competition->date)->format('Ymd\THis\Z');
                    $endGoogle = \Carbon\Carbon::parse($competition->date)->addHours(2)->format('Ymd\THis\Z');

                    $googleUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE"
                        . "&text=" . urlencode($competition->title)
                        . "&details=" . urlencode($competition->description)
                        . "&location=" . urlencode($competition->location)
                        . "&dates={$startGoogle}/{$endGoogle}";

                    $startOutlook = \Carbon\Carbon::parse($competition->date)->format('Y-m-d\TH:i:s');
                    $endOutlook = \Carbon\Carbon::parse($competition->date)->addHours(2)->format('Y-m-d\TH:i:s');

                    $outlookUrl = "https://outlook.office.com/calendar/action/compose"
                        . "?subject=" . urlencode($competition->title)
                        . "&body=" . urlencode($competition->description)
                        . "&location=" . urlencode($competition->location)
                        . "&startdt={$startOutlook}"
                        . "&enddt={$endOutlook}";
                @endphp

                <div class="flex gap-3 mt-2">
                    <a href="{{ $googleUrl }}" target="_blank"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded transition text-sm">
                        Google Calendar
                    </a>
                    <a href="{{ $outlookUrl }}" target="_blank"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-3 rounded transition text-sm">
                        Outlook
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <p class="text-gray-600 dark:text-gray-400 mt-1">Brak nadchodzących zawodów.</p>
@endif
