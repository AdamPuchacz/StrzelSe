<?php

namespace App\Http\Controllers;

use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationRequestController extends Controller
{
    private function checkResubmitStatus(?VerificationRequest $lastRequest)
    {
        // Domyślne wartości
        $canResubmit = false;
        $daysLeft = 0;

        if ($lastRequest) {
            $updatedAt = $lastRequest->updated_at;
            $hoursSince = $updatedAt ? now()->diffInHours($updatedAt) : 0;
            $daysLeft = max(0, 7 - ceil($hoursSince / 24));

            // Warunek złożenia wniosku
            if ($lastRequest->status === 'rejected' && $daysLeft <= 0) {
                $canResubmit = true;
            }
        } else {
            
            $canResubmit = true;
        }

        return [
            'canResubmit' => $canResubmit,
            'daysLeft' => $daysLeft,
        ];
    }

    /**
     * Wyświetla formularz zgłoszeniowy do weryfikacji konta.
     */
    public function create()
    {
        $lastRequest = VerificationRequest::where('user_id', Auth::id())->latest()->first();

        
        $info = $this->checkResubmitStatus($lastRequest);
        $canResubmit = $info['canResubmit'];
        $daysLeft = $info['daysLeft'];

        
        $status = $lastRequest ? $lastRequest->status : null;
        $statusTranslations = [
            'approved' => 'Zaakceptowany',
            'rejected' => 'Odrzucony',
            'pending' => 'Oczekuje',
        ];
        $statusColors = [
            'approved' => 'text-green-600 dark:text-green-400',
            'rejected' => 'text-red-600 dark:text-red-400',
            'pending' => 'text-yellow-600 dark:text-yellow-400',
        ];

        $statusText = $status ? ($statusTranslations[$status] ?? 'Nieznany') : null;
        $statusColor = $status ? ($statusColors[$status] ?? 'text-gray-600 dark:text-gray-400') : null;

        return view('verification.request', compact(
            'lastRequest', 'daysLeft', 'canResubmit',
            'statusText', 'statusColor'
        ));
    }

    /**
     * Przetwarza formularz zgłoszeniowy do weryfikacji konta.
     */
    public function store(Request $request)
    {
        $lastRequest = VerificationRequest::where('user_id', Auth::id())->latest()->first();

        
        $info = $this->checkResubmitStatus($lastRequest);
        if (! $info['canResubmit']) {
            return redirect()->route('welcome')
                ->with('error', "Możesz złożyć kolejny wniosek dopiero za {$info['daysLeft']} dni.");
        }

        $validatedData = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'digits:9'],
            'region' => ['required', 'string', 'max:255'],
            'attachments.*' => ['nullable', 'file', 'mimes:jpg,png,pdf', 'max:2048'],
        ]);

        // Oznaczanie stare wnioski jako old
        VerificationRequest::where('user_id', Auth::id())->update(['status' => 'old']);

        // Tworzenie nowy wniosek
        $verification = VerificationRequest::create([
            'user_id' => Auth::id(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'region' => $request->region,
            'status' => 'pending',
        ]);

        // Obsługa załączników
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('verification_files', 'public');
                $verification->files()->create(['path' => $path]);
            }
        }

        return redirect()
            ->route('verification.request')
            ->with('success', 'Twój wniosek o weryfikację został wysłany i jest w trakcie przetwarzania.');
    }
}
