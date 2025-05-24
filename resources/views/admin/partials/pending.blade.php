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
                    @forelse($request->files as $file)
                        <a href="{{ asset('storage/' . $file->path) }}" target="_blank" class="text-blue-500 hover:underline">
                            Pobierz
                        </a><br>
                    @empty
                        Brak załączników
                    @endforelse
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
