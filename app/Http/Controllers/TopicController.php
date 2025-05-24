<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ForumTopic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Pokaż formularz tworzenia nowego tematu.
     */
    public function create(Category $category)
    {
        $topic = new ForumTopic;

        return view('topics.create', compact('category', 'topic'));
    }

    /**
     * Zapisz nowy temat.
     */
    public function store(Request $request, Category $category)
    {

        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255', 'regex:/\S/'],
            'content' => ['required', 'string', 'regex:/\S/'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        // Obsługa przesłanego obrazu
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('topic_images', 'public');
            $validatedData['image'] = 'storage/'.$path;
        }

        // Tworzenie nowego tematu
        $topic = ForumTopic::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'category_id' => $category->id,
            'user_id' => auth()->id(),
            'image' => $validatedData['image'] ?? null,
        ]);

        return redirect()
            ->route('topics.show', $topic)
            ->with('success', 'Temat został pomyślnie utworzony.');
    }

    /**
     * Pokaż temat wraz z komentarzami.
     */
    public function show(ForumTopic $topic)
    {
        $comments = $topic->comments()->latest()->get();

        return view('topics.show-topic', compact('topic', 'comments'));
    }
}
