<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            Panel administratora - zgłoszenia weryfikacyjne
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Zgłoszenia oczekujące</h3>
            
            <table class="w-full border-collapse border border-gray-300 dark:border-gray-600 mb-8">
                <thead>
                    <tr class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Imię</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Nazwisko</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">E-mail</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Telefon</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Region</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Załączniki</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Status</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingRequests as $request)
                        <tr class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                            <td class="px-4 py-2">{{ $request->first_name }}</td>
                            <td class="px-4 py-2">{{ $request->last_name }}</td>
                            <td class="px-4 py-2">{{ $request->user->email }}</td>
                            <td class="px-4 py-2">{{ $request->phone }}</td>
                            <td class="px-4 py-2">{{ $request->region }}</td>
                            <td class="px-4 py-2">
                                @if($request->files->count())
                                    @foreach($request->files as $file)
                                        <a href="{{ asset('storage/' . $file->path) }}" target="_blank" 
                                           class="text-blue-500 hover:underline">
                                            Pobierz
                                        </a><br>
                                    @endforeach
                                @else
                                    Brak załączników
                                @endif
                            </td>
                            <td class="px-4 py-2 text-yellow-500 font-semibold">Oczekuje</td>
                            <td class="px-4 py-2 flex space-x-2">
                                <form action="{{ route('admin.verification.approve', $request->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                        Akceptuj
                                    </button>
                                </form>
                                <form action="{{ route('admin.verification.reject', $request->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Odrzuć
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Zgłoszenia rozpatrzone</h3>
            
            <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
                <thead>
                    <tr class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Imię</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Nazwisko</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">E-mail</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Telefon</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Region</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Załączniki</th>
                        <th class="border border-gray-300 dark:border-gray-600 px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($processedRequests as $request)
                        <tr class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                            <td class="px-4 py-2">{{ $request->first_name }}</td>
                            <td class="px-4 py-2">{{ $request->last_name }}</td>
                            <td class="px-4 py-2">{{ $request->user->email }}</td>
                            <td class="px-4 py-2">{{ $request->phone }}</td>
                            <td class="px-4 py-2">{{ $request->region }}</td>
                            <td class="px-4 py-2">
                                @if($request->files->count())
                                    @foreach($request->files as $file)
                                        <a href="{{ asset('storage/' . $file->path) }}" target="_blank" 
                                           class="text-blue-500 hover:underline">
                                            Pobierz
                                        </a><br>
                                    @endforeach
                                @else
                                    Brak załączników
                                @endif
                            </td>
                            <td class="px-4 py-2 font-semibold 
                                {{ $request->status === 'approved' ? 'text-green-500' : 'text-red-500' }}">
                                {{ $request->status === 'approved' ? 'Zaakceptowany' : 'Odrzucony' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
