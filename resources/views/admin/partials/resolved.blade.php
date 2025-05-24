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
                    @forelse($request->files as $file)
                        <a href="{{ asset('storage/' . $file->path) }}" target="_blank" 
                           class="text-blue-500 hover:underline">
                            Pobierz
                        </a><br>
                    @empty
                        Brak załączników
                    @endforelse
                </td>
                <td class="px-4 py-2 font-semibold 
                    {{ $request->status === 'approved' ? 'text-green-500' : 'text-red-500' }}">
                    {{ $request->status === 'approved' ? 'Zaakceptowany' : 'Odrzucony' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
