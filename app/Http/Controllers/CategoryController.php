<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ForumTopic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    /**
     * Wyświetla kategorię i listę tematów.
     */
    public function show(Category $category)
    {
        $topics = $category->topics()->latest()->get();

        return view('categories.show-category', compact('category', 'topics'));
    }

    /**
     * Wyświetla formularz edycji posta.
     */
    public function editTopic(Category $category, ForumTopic $topic)
    {
        $this->authorize('update', $topic);

        return view('topics.edit', compact('category', 'topic'));
    }

    /**
     * Aktualizuje post
     */
    public function updateTopic(Request $request, Category $category, ForumTopic $topic)
    {
        $this->authorize('update', $topic);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', 'regex:/\\S/'],
            'content' => ['required', 'string', 'max:1000', 'regex:/\\S/'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        // Obsługa usunięcia obrazu
        if ($request->input('delete_image') == '1' && $topic->image) {
            $this->deleteImage($topic->image);
            $topic->update(['image' => null]);
        }

        
        if ($request->hasFile('image')) {
            // Najpierw usuwamy stary plik, jeśli istniał i nie został już usunięty
            if ($topic->image) {
                $this->deleteImage($topic->image);
            }
            // Zapis nowego pliku w folderze 'topic_images'
            $newPath = $request->file('image')->store('topic_images', 'public');

            $validated['image'] = 'storage/'.$newPath;
        }

        // Aktualizacja posta
        $topic->update(array_merge(
            $validated,
            ['is_edited' => true]
        ));

        return redirect()->route('categories.show', $category)->with('success', 'Post został zaktualizowany.');
    }

    /**
     * Usuwa post.
     */
    public function destroyTopic(Category $category, ForumTopic $topic)
    {
        $this->authorize('delete', $topic);

        if ($topic->image) {
            $this->deleteImage($topic->image);
        }

        // Oznaczenie kto usuwa post
        $deletedBy = (Auth::user()->hasRole('moderator') || Auth::user()->hasRole('admin'))
            ? 'moderator'
            : 'author';

        $topic->update(['deleted_by' => $deletedBy]);
        $topic->delete();

        return redirect()->route('categories.show', $category)->with('success', 'Post został usunięty.');
    }

    /**
     * Usuwa fizyczny plik obrazu z dysku.
     */
    private function deleteImage($imagePath)
    {
        
        $publicPath = str_replace('storage/', '', $imagePath);

        if (Storage::disk('public')->exists($publicPath)) {
            Storage::disk('public')->delete($publicPath);
        }
    }
}
