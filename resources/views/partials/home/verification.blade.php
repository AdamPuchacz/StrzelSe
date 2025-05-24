<section class="bg-gray-200 dark:bg-gray-800 p-6 rounded-lg shadow-md lg:mt-0 mt-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4 text-center lg:text-left">
        📌 Zostań zweryfikowanym użytkownikiem!
    </h2>
    <p class="text-gray-700 dark:text-gray-300 text-center mb-4">
        Jesteś właścicielem strzelnicy? Masz możliwość i chciałbyś organizować swoje zawody? <br>
        Prześlij zgłoszenie 📝, aby uzyskać możliwość tworzenia własnych zawodów sportowych!
        Skracamy formalności do niezbędnego minimum, abyś jak najszybciej mógł dołączyć do grona zweryfikowanych użytkowników 🏆
    </p>

    @auth
        @if(auth()->user()->role === 'user')
            <div class="flex justify-center">
                <a href="{{ route('verification.request') }}" 
                   class="block text-center bg-gray-700 hover:bg-gray-800 text-white font-semibold py-2 px-9 rounded-md text-sm transition">
                    Złóż wniosek
                </a>
            </div>
        @else
            <p class="text-green-500 text-center font-semibold">
                Twoje konto jest już zweryfikowane!
            </p>
        @endif
    @else
        <p class="text-gray-600 dark:text-gray-400 text-center">
            Aby złożyć wniosek, musisz się 
            <a href="{{ route('login') }}" class="text-blue-500 hover:underline dark:text-blue-400">zalogować</a>.
        </p>
    @endauth
</section>
