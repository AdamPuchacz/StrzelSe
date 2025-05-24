<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/topic_images');
            $publicPath = Storage::url($path);

            return response()->json([
                'success' => true,
                'path' => $publicPath,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Nie udało się przesłać obrazu.',
        ], 400);
    }
}
