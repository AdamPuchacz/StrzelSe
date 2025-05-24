<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'StrzelSe') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="h-screen bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('{{ asset('images/background.jpg') }}');">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
        
        <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-gray-400 bg-opacity-60 dark:bg-gray-800 dark:bg-opacity-80 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="bg-gray-400 bg-opacity-60 dark:bg-gray-800 dark:bg-opacity-80 p-6 rounded-lg shadow-lg max-w-6xl mx-auto">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
