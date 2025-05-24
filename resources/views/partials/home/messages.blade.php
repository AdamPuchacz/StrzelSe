@if (session('success'))
    <div class="bg-green-500 text-white p-4 rounded-md text-center mt-4">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-500 text-white p-4 rounded-md text-center mt-4">
        {{ session('error') }}
    </div>
@endif
