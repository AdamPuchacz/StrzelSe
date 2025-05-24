<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Strona główna') }}
        </h2>
    </x-slot>

    <div class="relative min-h-screen flex flex-col items-center justify-start w-full py-9">
        <div class="w-full max-w-7xl px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Sekcja Kategorii Forum --}}
                @include('partials.home.categories', ['categories' => $categories])

                {{-- Sekcja weryfikacji użytkownika --}}
                @include('partials.home.verification')
            </div>

            {{-- Komunikaty --}}
            @include('partials.home.messages')
        </div>
    </div>

    {{-- Stopka --}}
    @include('partials.home.footer')
</x-app-layout>