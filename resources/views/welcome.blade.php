<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                
            </style>
        @endif
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            @include('layouts.navigation')
            <img id="background" class="absolute -left-20 top-0 max-w-[877px]" src="" alt="" />
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                           
                        </div>
                        
                    </header>

                    <!-- Categories Section -->
    <section class="py-8">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6 text-center">Kategorie Forum</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white shadow rounded p-6 text-center">
                    <h3 class="text-xl font-bold mb-2">Ogłoszenia</h3>
                    <p class="text-gray-600">Aktualności ze świata strzeleckiego.</p>
                </div>
                <div class="bg-white shadow rounded p-6 text-center">
                    <h3 class="text-xl font-bold mb-2">Sprzęt</h3>
                    <p class="text-gray-600">Podziel się opiniami o wyposażeniu.</p>
                </div>
                <div class="bg-white shadow rounded p-6 text-center">
                    <h3 class="text-xl font-bold mb-2">Strzelnice</h3>
                    <p class="text-gray-600">Znajdź strzelnice w swojej okolicy.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="bg-blue-50 py-8">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-4">O StrzelSe</h2>
            <p class="text-gray-700 max-w-2xl mx-auto">StrzelSe to forum dla miłośników strzelectwa. Dziel się swoją pasją, zdobywaj wiedzę i twórz społeczność z innymi pasjonatami.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="container mx-auto text-center">
            <p>&copy; {{ date('Y') }} StrzelSe. Wszystkie prawa zastrzeżone.</p>
        </div>
    </footer>
</div>