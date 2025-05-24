<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class StrongPassword implements Rule
{
    public function passes($attribute, $value)
    {
        // Sprawdź długość hasła
        if (strlen($value) < 8) {
            return false;
        }

        // Sprawdź obecność małych i wielkich liter
        if (! preg_match('/[a-z]/', $value) || ! preg_match('/[A-Z]/', $value)) {
            return false;
        }

        // Sprawdź obecność cyfr
        if (! preg_match('/\d/', $value)) {
            return false;
        }

        // Sprawdź obecność znaków specjalnych
        if (! preg_match('/[\W_]/', $value)) {
            return false;
        }

        // Sprawdź, czy hasło nie zostało ujawnione w wyciekach danych
        $hash = strtoupper(sha1($value));
        $prefix = substr($hash, 0, 5);
        $suffix = substr($hash, 5);

        $response = Http::get("https://api.pwnedpasswords.com/range/{$prefix}");

        if ($response->successful() && strpos($response->body(), $suffix) !== false) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Hasło musi mieć co najmniej 8 znaków, zawierać małe i wielkie litery, cyfrę, znak specjalny i nie może być ujawnione w wyciekach danych.';
    }
}
