<?php

return [
    'uploaded' => 'nie udało się przesłać pliku. Plik może być za duży (2MB) lub wystąpił inny błąd.',
    'accepted' => ':attribute musi zostać zaakceptowane.',
    'active_url' => ':attribute nie jest prawidłowym adresem URL.',
    'after' => ':attribute musi być datą późniejszą niż :date.',
    'alpha' => ':attribute może zawierać tylko litery.',
    'alpha_dash' => ':attribute może zawierać tylko litery, cyfry i podkreślenia.',
    'alpha_num' => ':attribute może zawierać tylko litery i cyfry.',
    'array' => ':attribute musi być tablicą.',
    'before' => ':attribute musi być datą wcześniejszą niż :date.',
    'between' => [
        'numeric' => ':attribute musi być wartością pomiędzy :min i :max.',
        'file' => ':attribute musi mieć pomiędzy :min a :max kilobajtów.',
        'string' => ':attribute musi mieć pomiędzy :min a :max znaków.',
        'array' => ':attribute musi mieć pomiędzy :min a :max pozycji.',
    ],
    'boolean' => 'pole :attribute musi być wartością prawda (true) lub fałsz (false).',
    'confirmed' => 'podane :attribute nie są identyczne.',
    'date' => ':attribute nie jest prawidłową datą.',
    'date_format' => ':attribute nie zgadza się z formatem :format.',
    'different' => ':attribute i :other muszą być różne.',
    'digits' => ':attribute musi mieć :digits cyfr.',
    'digits_between' => ':attribute musi mieć pomiędzy :min a :max cyfr.',
    'email' => ':attribute musi być poprawnym adresem email.',
    'exists' => 'wybrany :attribute jest nieprawidłowy.',
    'image' => ':attribute musi mieć rozszerzenie jpg, jpeg, png, gif, bmp, svg lub webp.',
    'in' => 'wybrany :attribute jest nieprawidłowy.',
    'integer' => ':attribute musi być liczbą całkowitą.',
    'ip' => ':attribute musi być poprawnym adresem IP.',
    'max' => [
        'numeric' => ':attribute nie może być większy niż :max.',
        'file' => ':attribute nie może być większy niż :max kilobajtów.',
        'string' => ':attribute nie może być dłuższy niż :max znaków.',
        'array' => ':attribute nie może mieć więcej niż :max pozycji.',
    ],
    'mimes' => ':attribute musi być plikiem typu: :values.',
    'min' => [
        'numeric' => ':attribute musi mieć co najmniej :min.',
        'file' => ':attribute musi mieć co najmniej :min kilobajtów.',
        'string' => ':attribute musi mieć co najmniej :min znaków.',
        'array' => ':attribute musi mieć co najmniej :min pozycji.',
    ],
    'not_in' => 'wybrany :attribute jest nieprawidłowy.',
    'numeric' => ':attribute musi być liczbą.',
    'regex' => 'format :attribute jest nieprawidłowy.',
    'required' => 'pole :attribute jest wymagane.',
    'required_if' => 'pole :attribute jest wymagane, gdy :other ma wartość :value.',
    'required_with' => 'pole :attribute jest wymagane, gdy :values są obecne.',
    'required_with_all' => 'pole :attribute jest wymagane, gdy wszystkie :values są obecne.',
    'required_without' => 'pole :attribute jest wymagane, gdy :values nie są obecne.',
    'required_without_all' => 'pole :attribute jest wymagane, gdy żadne z :values nie są obecne.',
    'same' => ':attribute i :other muszą być takie same.',
    'size' => [
        'numeric' => ':attribute musi mieć :size.',
        'file' => ':attribute musi mieć :size kilobajtów.',
        'string' => ':attribute musi mieć :size znaków.',
        'array' => ':attribute musi zawierać :size pozycji.',
    ],
    'string' => ':attribute musi być ciągiem znaków.',
    'timezone' => ':attribute musi być prawidłową strefą czasową.',
    'unique' => ':attribute jest już zajęty.',
    'url' => 'Format :attribute jest nieprawidłowy.',
    'password' => [
        'min' => 'hasło musi mieć co najmniej :min znaków.',
        'letters' => 'hasło musi zawierać co najmniej jedną literę.',
        'mixed' => 'hasło musi zawierać zarówno małe, jak i wielkie litery.',
        'numbers' => 'hasło musi zawierać co najmniej jedną cyfrę.',
        'symbols' => 'hasło musi zawierać co najmniej jeden znak specjalny.',
        'uncompromised' => 'podane hasło pojawiło się w wycieku danych. Wybierz inne hasło.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Niestandardowe wiadomości walidacyjne
    |--------------------------------------------------------------------------
    */
    'custom' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Niestandardowe atrybuty
    |--------------------------------------------------------------------------
    */
    'attributes' => [
        'username' => 'nazwa użytkownika',
        'password' => 'hasło',
        'email' => 'adres e-mail',
        'password_confirmation' => 'potwierdzenie hasła',
        'current_password' => 'aktualne hasło',
        'image' => 'obraz',
        'attachments.*' => 'załącznik',
    ],
];
