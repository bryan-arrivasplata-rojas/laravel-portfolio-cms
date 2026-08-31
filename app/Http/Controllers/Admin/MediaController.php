<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaUploadRequest;
use App\Models\MediaFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = MediaFile::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('original_name', 'like', "%{$search}%");
        }

        if ($request->filled('type')) {
            if ($request->type === 'image') {
                $query->where('mime_type', 'like', 'image/%');
            } elseif ($request->type === 'document') {
                $query->where('mime_type', 'not like', 'image/%');
            }
        }

        $files = $query->paginate(24);

        if ($request->wantsJson()) {
            return response()->json($files);
        }

        return view('admin.media.index', compact('files'));
    }

    public function store(MediaUploadRequest $request): JsonResponse
    {
        $uploadedFile = $request->file('file');
        $originalName = $uploadedFile->getClientOriginalName();
        $extension = $uploadedFile->getClientOriginalExtension();
        $mimeType = $uploadedFile->getClientMimeType();
        $sizeBytes = $uploadedFile->getSize();

        $uniqueName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '_' . time() . '.' . $extension;
        $path = $uploadedFile->storeAs('uploads', $uniqueName, 'public');

        $mediaFile = MediaFile::create([
            'filename' => $uniqueName,
            'original_name' => $originalName,
            'mime_type' => $mimeType,
            'size_bytes' => $sizeBytes,
            'disk' => 'public',
            'path' => $path,
            'public_url' => Storage::url($path),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Archivo subido correctamente.',
            'data' => $mediaFile
        ], 201);
    }

    public function destroy($id, Request $request): JsonResponse
    {
        $media = MediaFile::withTrashed()->findOrFail($id);

        if ($request->boolean('force_delete')) {
            if (Storage::disk('public')->exists($media->path)) {
                Storage::disk('public')->delete($media->path);
            }
            $media->forceDelete();
            $msg = 'Archivo eliminado físicamente y purgado de la base de datos.';
        } else {
            $media->delete();
            $msg = 'Archivo movido a la papelera (eliminación lógica).';
        }

        return response()->json([
            'success' => true,
            'message' => $msg
        ]);
    }

    public function restore($id): JsonResponse
    {
        $media = MediaFile::onlyTrashed()->findOrFail($id);
        $media->restore();

        return response()->json([
            'success' => true,
            'message' => 'Archivo restaurado exitosamente.'
        ]);
    }
}