<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-200 leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- Sekcja formularzy --}}
            <div class="space-y-6">
                @include('profile.partials.update-profile-information-form')
                @include('profile.partials.update-password-form')
                @include('profile.partials.delete-user-form')
            </div>

            {{-- Sekcja zawodów użytkownika --}}
            <div class="p-6 bg-gray-200 dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Twoje zawody
                </h3>

                {{-- Nadchodzące zawody --}}
                @include('profile.partials.competitions.upcoming')

                {{-- Archiwalne zawody --}}
                @include('profile.partials.competitions.archived')
            </div>
        </div>
    </div>
</x-app-layout>
