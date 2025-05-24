<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password as PasswordFacade; // alias do resetu haseł
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
// reguły dla haseł
use Illuminate\View\View; // do tworzenia instancji Validator

class NewPasswordController extends Controller
{
    /**
     * Wyświetla formularz resetu hasła.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Obsługuje zapis nowego hasła.
     */
    public function store(Request $request): RedirectResponse
    {
        // Tworzymy instancję walidatora
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
        ]);

        // Walidujemy z użyciem updatePassword:
        $validator->validateWithBag('updatePassword');

        // Jeśli walidacja się powiedzie, przystępujemy do resetu hasła:
        $status = PasswordFacade::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // Jeżeli reset przebiegł pomyślnie:
        if ($status === PasswordFacade::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('status', __($status));
        }

        
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
