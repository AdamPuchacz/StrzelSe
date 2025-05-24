<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\ForumTopic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Formularz dodawania komentarza.
     */
    public function create(ForumTopic $topic)
    {
        return view('comments.create', compact('topic'));
    }

    /**
     * Zapis nowego komentarza.
     */
    public function store(Request $request, ForumTopic $topic)
    {

        $request->merge(['content' => trim($request->input('content'))]);

        $validatedData = $request->validate([
            'content' => ['required', 'string', 'max:1000', 'regex:/\\S/'],
            'topic_id' => ['required', 'exists:forum_topics,id'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('comment_images', 'public');
            $validatedData['image'] = 'storage/'.$path;
        }

        Comment::create([
            'content' => $validatedData['content'],
            'user_id' => auth()->id(),
            'topic_id' => $validatedData['topic_id'],
            'image' => $validatedData['image'] ?? null,
        ]);

        return redirect()->route('topics.show', $validatedData['topic_id'])->with('success', 'Komentarz dodany.');
    }

    /**
     * Aktualizacja komentarza z oznaczeniem
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        try {
            $request->merge(['content' => trim($request->input('content'))]);

            $validated = $request->validate([
                'content' => ['required', 'string', 'max:1000', 'regex:/\S/'],
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        if ($request->input('delete_image') == '1' && $comment->image) {
            $this->deleteImage($comment->image);
            $comment->image = null;
            $comment->save();
        }

        
        $comment->update(array_merge($validated, ['is_edited' => true]));

        return redirect()->route('topics.show', $comment->topic)->with('success', 'Komentarz został zaktualizowany.');
    }

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('comments.edit', compact('comment'));
    }

    /**
     * Usuwanie komentarza
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        if ($comment->image) {
            $this->deleteImage($comment->image);
        }

        $deletedBy = (Auth::user()->hasRole('moderator') || Auth::user()->hasRole('admin')) ? 'moderator' : 'author';
        $comment->update(['deleted_by' => $deletedBy]);

        $comment->delete();

        return redirect()->route('topics.show', $comment->topic)->with('success', 'Komentarz został usunięty.');
    }

    /**
     * Usuwanie obrazu powiązany z komentarzem.
     */
    private function deleteImage($imagePath)
    {
        $filePath = str_replace('storage/', 'public/', $imagePath);

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $fullPath = storage_path("app/public/{$filePath}");
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
