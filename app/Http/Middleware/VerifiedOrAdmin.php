<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifiedOrAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Sprawdzenie czy użytkownik jest zalogowany
        if (! $user) {
            return redirect()->route('login');
        }

        // Sprawdzenie uprawnień
        if (in_array($user->role, ['admin', 'verified'])) {
            return $next($request);
        }

        return abort(403, 'Brak dostępu');
    }
}
