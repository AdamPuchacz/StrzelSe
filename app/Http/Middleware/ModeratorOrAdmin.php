<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ModeratorOrAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (! $user || ! $user->hasRole(['admin', 'moderator'])) {
            abort(403, 'Nie masz uprawnień.');
        }

        return $next($request);
    }
}
