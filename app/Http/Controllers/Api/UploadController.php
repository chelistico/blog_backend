<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function image(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg+xml|max:10240',
            'folder' => 'nullable|string|in:articles,avatars,settings,banners,misc',
        ]);

        $folder = $request->input('folder', 'misc');
        $file = $request->file('image');

        $path = $file->store("images/{$folder}", 'public');

        return response()->json([
            'success' => true,
            'data' => [
                'url' => Storage::url($path),
                'path' => $path,
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ],
        ]);
    }

    public function delete(Request $request): JsonResponse
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $path = str_replace('/storage/', '', $request->path);

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);

            return response()->json([
                'success' => true,
                'message' => 'Archivo eliminado correctamente',
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => ['code' => 'NOT_FOUND', 'message' => 'Archivo no encontrado'],
        ], 404);
    }
}
