<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            Panel administracyjny - weryfikacja użytkowników
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            
            @include('admin.partials.pending')

            @include('admin.partials.resolved')
        </div>
    </div>
</x-app-layout>
