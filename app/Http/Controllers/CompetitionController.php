<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class CompetitionController extends Controller
{
    use AuthorizesRequests;

    /**
     * Wyświetla listę zawodów (publiczna).
     */
    public function index()
    {
        $today = Carbon::today();

        // Aktualne zawody
        $currentCompetitions = Competition::whereDate('date', '>=', $today)
            ->orderBy('date', 'asc')
            ->get();

        // Archiwalne zawody
        $archivedCompetitions = Competition::whereDate('date', '<', $today)
            ->orderBy('date', 'desc')
            ->get();

        return view('shooting-competitions.competitions', compact('currentCompetitions', 'archivedCompetitions'));
    }

    /**
     * Wyświetla szczegóły wybranych zawodów (publiczne).
     */
    public function show(Competition $competition)
    {
        // Wczytanie relacji uczestników
        $competition->load('participants');

        // Czy zawody są już archiwalne?
        $isArchived = Carbon::parse($competition->date)->isPast();
        $participantCount = $isArchived ? $competition->participants()->count() : null;

        // Sprawdzenie, czy do zawodów pozostało mniej niż 1 dzień
        $lessThanOneDay = Carbon::now()->addDay()->greaterThanOrEqualTo(
            Carbon::parse($competition->date)
        );

        return view('shooting-competitions.show', compact(
            'competition',
            'isArchived',
            'participantCount',
            'lessThanOneDay'
        ));
    }

    /**
     * Formularz do tworzenia zawodów (dla zweryfikowanych/adminów).
     */
    public function create()
    {
        $this->authorize('create', Competition::class);

        return view('shooting-competitions.create');
    }

    /**
     * Zapisuje nowe zawody do bazy danych.
     */
    public function store(Request $request)
    {
        $minDate = Carbon::now()->addDays(2)->format('Y-m-d');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => ['required', 'date', 'after_or_equal:'.$minDate],
            'location' => 'required|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:2048',
        ], [
            'date.after_or_equal' => 'Zawody muszą być zaplanowane co najmniej z 2-dniowym wyprzedzeniem.',
        ]);

        // Obsługa obrazu (opcjonalnego)
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('competition_images', 'public');
        } else {
            $imagePath = null;
        }

        Competition::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'location' => $validated['location'],
            'max_participants' => $validated['max_participants'] ?? null,
            'image_path' => $imagePath,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('shooting-competitions.index')->with('success', 'Zawody zostały dodane!');
    }

    /**
     * Zapisuje użytkownika na wybrane zawody.
     */
    public function join(Competition $competition)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Musisz być zalogowany, aby zapisać się na zawody.');
        }

        // Sprawdzenie, czy zawody zaczynają się za mniej niż 24 godziny
        if (Carbon::now()->addDay()->greaterThanOrEqualTo(Carbon::parse($competition->date))) {
            return redirect()->route('shooting-competitions.show', $competition)
                ->with('error', 'Zapisy na te zawody zostały zamknięte.');
        }

        if ($competition->max_participants &&
            $competition->participants()->count() >= $competition->max_participants) {
            return redirect()->route('shooting-competitions.show', $competition)
                ->with('error', 'Limit uczestników został osiągnięty.');
        }

        if ($user->competitions->contains($competition)) {
            return redirect()->route('shooting-competitions.show', $competition)
                ->with('error', 'Jesteś już zapisany na te zawody.');
        }

        $user->competitions()->attach($competition);

        return redirect()->route('shooting-competitions.show', $competition)
            ->with('success', 'Zapisano na zawody!');
    }

    /**
     * Wypisuje użytkownika z zawodów.
     */
    public function leave(Competition $competition)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Musisz być zalogowany, aby wypisać się z zawodów.');
        }

        if (! $user->competitions->contains($competition)) {
            return redirect()->route('shooting-competitions.show', $competition)
                ->with('error', 'Nie jesteś zapisany na te zawody.');
        }

        $user->competitions()->detach($competition);

        return redirect()->route('shooting-competitions.show', $competition)
            ->with('success', 'Wypisano z zawodów.');
    }

    /**
     * Wyświetla zawody, na które użytkownik jest zapisany.
     */
    public function userCompetitions()
    {
        $competitions = Auth::user()->competitions()->latest()->get();

        return view('shooting-competitions.user', compact('competitions'));
    }

    /**
     * Pobieranie raportu uczestników zawodów w formacie CSV (dla admina i twórcy zawodów).
     */
    public function downloadReport(Competition $competition)
    {
        // Sprawdzenie uprawnień (admin lub twórca zawodów)
        if (Auth::user()->role !== 'admin' && Auth::id() !== $competition->created_by) {
            return redirect()->route('shooting-competitions.show', $competition)
                ->with('error', 'Nie masz uprawnień do pobrania raportu.');
        }

        // Pobranie listy uczestników
        $participants = $competition->participants()->select('name', 'email')->get();

        // Tworzenie nazwy pliku
        $filename = Str::slug($competition->title).'.csv';

        // Tworzenie danych do CSV
        $csvData = "L.P,Nazwa użytkownika,Adres e-mail\n";
        foreach ($participants as $index => $participant) {
            $csvData .= ($index + 1).','.$participant->name.','.$participant->email."\n";
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
