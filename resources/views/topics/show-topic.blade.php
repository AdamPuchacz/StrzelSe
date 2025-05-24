<x-app-layout>
<x-slot name="header">
    <nav class="text-black dark:text-gray-300 text-sm font-semibold">
        <a href="{{ route('welcome') }}" class="hover:underline">Strona główna</a> >
        <a href="{{ route('categories.show', $topic->category->id) }}" class="hover:underline">{{ $topic->category->name }}</a> >
        <span class="text-black dark:text-gray-300">{{ $topic->title }}</span>
    </nav>
</x-slot>

<div class="container mx-auto mt-8">
    <!-- Tytuł posta -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ $topic->title }}</h3>

        <!-- Obraz posta -->
            @if ($topic->image)
                <div class="mb-6 flex justify-center" x-data="{ zoomedTopicImage: false }">
                    <img src="{{ asset($topic->image) }}" 
                        alt="Obraz tematu" 
                        class="rounded-lg w-full max-h-96 object-contain cursor-pointer shadow-md"
                        @click="zoomedTopicImage = true">

                    <div x-show="zoomedTopicImage"
                        x-transition.opacity
                        class="fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center"
                        @click="zoomedTopicImage = false">
                        <img src="{{ asset($topic->image) }}" 
                            alt="Obraz tematu" 
                            class="max-w-full max-h-screen rounded shadow-lg object-contain">
                    </div>
                </div>
            @endif

        <!-- Treść -->
        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
            {!! nl2br(e($topic->content)) !!}
        </p>
    </div>

    <!-- Formularz dodawania komentarza -->
    @auth
    <div class="mt-10 p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Dodaj komentarz</h3>
        
        <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="topic_id" value="{{ $topic->id }}">
            
            <!-- Treść komentarza -->
            <textarea name="content" rows="4" class="border p-2 w-full rounded-md dark:bg-gray-700 dark:text-white" placeholder="Napisz swój komentarz..." required></textarea>

            <!-- Pole do dodania obrazu -->
            <label class="block mt-4 text-gray-700 dark:text-gray-300">Dodaj obraz:</label>
            <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600">
            
            <!-- Błędy walidacji -->
            @if ($errors->any())
                <div class="mt-3 text-red-600 dark:text-red-400">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Przycisk wysyłania -->
            <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500 dark:hover:bg-blue-400">
                Dodaj komentarz
            </button>
        </form>
    </div>
    @else
    <p class="text-gray-900 dark:text-gray-400 mt-4">
         Aby dodać komentarz, musisz być
         <a href="{{ route('login') }}" class="text-blue-500 hover:underline dark:text-blue-400">zalogowany</a>.
        </p>
    @endauth

    <!-- Sekcja komentarzy -->
<div class="mt-10">
    <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Komentarze</h3>

    <div class="space-y-4">
        @forelse($comments as $comment)
            <div class="bg-gray-100 dark:bg-gray-900 shadow rounded-lg p-4">
                <!-- Informacja o usunięciu komentarza -->
                @if($comment->deleted_by)
                    <p class="text-red-500 text-sm">
                        @if($comment->deleted_by === 'moderator')
                            Usunięto przez moderatora z powodu naruszenia regulaminu
                        @elseif($comment->deleted_by === 'admin')
                            Usunięto przez administratora
                        @else
                            Usunięto przez autora
                        @endif
                    </p>
                @else
                    <!-- Obraz komentarza -->
                    @if ($comment->image)
                        <div class="mb-4 flex justify-start" x-data="{ zoomedCommentImage: false }">
                            <img src="{{ asset($comment->image) }}" 
                                alt="Obraz komentarza" 
                                class="rounded-lg w-32 h-auto object-contain cursor-pointer shadow-md"
                                @click="zoomedCommentImage = true">

                            <div x-show="zoomedCommentImage"
                                x-transition.opacity
                                class="fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center"
                                @click="zoomedCommentImage = false">
                                <img src="{{ asset($comment->image) }}" 
                                    alt="Obraz komentarza" 
                                    class="max-w-full max-h-screen rounded shadow-lg object-contain">
                            </div>
                        </div>
                    @endif


                    <!-- Treść komentarza -->
                    <p class="text-black dark:text-gray-300">{!! nl2br(e($comment->content)) !!}</p>
                    <p class="text-sm text-gray-500 mt-2">
                        Dodane przez {{ $comment->user->name }} | {{ $comment->created_at->diffForHumans() }}
                    </p>

                    <!-- Oznaczenie edytowanego komentarza -->
                    @if($comment->is_edited)
                        <p class="text-gray-500 text-xs text-right">Edytowano</p>
                    @endif

                    <!-- Przyciski edycji i usuwania komentarza -->
                    <div class="flex gap-2 mt-2">
                        @can('update', $comment)
                            <a href="{{ route('comments.edit', $comment) }}"
                                class="px-3 py-1 bg-blue-600 dark:bg-blue-500 text-white rounded-md shadow-sm 
                                       hover:bg-blue-500 dark:hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300">
                                Edytuj
                            </a>
                        @endcan

                        @can('delete', $comment)
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                onsubmit="return confirm('Czy na pewno chcesz usunąć ten komentarz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 bg-red-600 dark:bg-red-500 text-white rounded-md shadow-sm 
                                           hover:bg-red-500 dark:hover:bg-red-400 focus:outline-none focus:ring focus:ring-red-300">
                                    Usuń
                                </button>
                            </form>
                        @endcan
                    </div>
                @endif
            </div>
        @empty
            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Brak komentarzy do tego tematu.</p>
        @endforelse
    </div>
</div>
</div>
</x-app-layout>
