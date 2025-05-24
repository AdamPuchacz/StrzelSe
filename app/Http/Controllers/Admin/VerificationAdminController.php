<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VerificationRequest;

class VerificationAdminController extends Controller
{
    public function index()
    {
        // Pobieramy wnioski oczekujące
        $pendingRequests = VerificationRequest::with('user', 'files')
            ->where('status', 'pending')
            ->get();

        // Pobieramy wnioski przetworzone: approved, rejected, old
        // => „archiwalne”
        $processedRequests = VerificationRequest::with('user', 'files')
            ->whereIn('status', ['approved', 'rejected', 'old'])
            ->get();

        return view('admin.verification-requests.verification-requests', compact(
            'pendingRequests',
            'processedRequests'
        ));
    }

    public function approve($id)
    {
        $request = VerificationRequest::findOrFail($id);
        $request->update(['status' => 'approved']);

        $user = $request->user;
        $user->update(['role' => 'verified']);

        return redirect()
            ->route('admin.verification.index')
            ->with('success', 'Wniosek został zaakceptowany. Rola użytkownika została zmieniona na "zweryfikowany".');
    }

    public function reject($id)
    {
        $request = VerificationRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);

        return redirect()
            ->route('admin.verification.index')
            ->with('error', 'Wniosek odrzucony.');
    }
}
