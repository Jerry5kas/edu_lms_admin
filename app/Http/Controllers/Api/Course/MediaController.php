<?php

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Display a listing of media files
     */
    public function index(): JsonResponse
    {
        $media = Media::with('user')
            ->latest()
            ->paginate(20);

        $stats = [
            'total_files' => Media::count(),
            'total_size' => Media::sum('size_bytes'),
            'by_type' => [
                'images' => Media::where('mime', 'like', 'image/%')->count(),
                'videos' => Media::where('mime', 'like', 'video/%')->count(),
                'documents' => Media::whereIn('mime', [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'text/plain'
                ])->count(),
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'media' => $media
            ]
        ]);
    }

    /**
     * Store a newly uploaded media file
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'disk' => 'nullable|string|in:public,s3,bunny',
        ]);

        $file = $request->file('file');
        $disk = $request->input('disk', 'public');
        
        // Generate unique filename
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Store file
        $path = $file->storeAs('media', $filename, $disk);
        
        // Create media record
        $media = Media::create([
            'user_id' => Auth::id(),
            'disk' => $disk,
            'path' => $path,
            'mime' => $file->getMimeType(),
            'size_bytes' => $file->getSize(),
            'original_name' => $file->getClientOriginalName(),
            'meta' => [
                'extension' => $file->getClientOriginalExtension(),
                'uploaded_at' => now()->toISOString(),
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'File uploaded successfully',
            'data' => $media
        ], 201);
    }

    /**
     * Display the specified media file
     */
    public function show(Media $media): JsonResponse
    {
        $media->load('user');

        return response()->json([
            'success' => true,
            'data' => $media
        ]);
    }

    /**
     * Remove the specified media file
     */
    public function destroy(Media $media): JsonResponse
    {
        // Delete file from storage
        if ($media->path && Storage::disk($media->disk)->exists($media->path)) {
            Storage::disk($media->disk)->delete($media->path);
        }
        
        // Delete media record
        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully'
        ]);
    }

    /**
     * Upload file via AJAX (for use in other forms)
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'disk' => 'nullable|string|in:public,s3,bunny',
        ]);

        $file = $request->file('file');
        $disk = $request->input('disk', 'public');
        
        // Generate unique filename
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        // Store file
        $path = $file->storeAs('media', $filename, $disk);
        
        // Create media record
        $media = Media::create([
            'user_id' => Auth::id(),
            'disk' => $disk,
            'path' => $path,
            'mime' => $file->getMimeType(),
            'size_bytes' => $file->getSize(),
            'original_name' => $file->getClientOriginalName(),
            'meta' => [
                'extension' => $file->getClientOriginalExtension(),
                'uploaded_at' => now()->toISOString(),
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'File uploaded successfully',
            'data' => $media
        ]);
    }

    /**
     * Get media files for selection (AJAX)
     */
    public function getMedia(Request $request): JsonResponse
    {
        $query = Media::query();
        
        // Filter by type
        if ($request->has('type')) {
            $type = $request->input('type');
            if ($type === 'image') {
                $query->where('mime', 'like', 'image/%');
            } elseif ($type === 'video') {
                $query->where('mime', 'like', 'video/%');
            } elseif ($type === 'document') {
                $query->whereIn('mime', [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'text/plain'
                ]);
            }
        }
        
        // Search by name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('original_name', 'like', "%{$search}%");
        }
        
        $media = $query->latest()->paginate(12);
        
        return response()->json([
            'success' => true,
            'data' => $media
        ]);
    }

    /**
     * Get file info by path
     */
    public function getByPath(Request $request): JsonResponse
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $media = Media::where('path', $request->path)->first();
        
        if (!$media) {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $media
        ]);
    }

    /**
     * Bulk delete media files
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:media,id',
        ]);

        $mediaFiles = Media::whereIn('id', $request->ids)->get();
        
        foreach ($mediaFiles as $media) {
            // Delete file from storage
            if ($media->path && Storage::disk($media->disk)->exists($media->path)) {
                Storage::disk($media->disk)->delete($media->path);
            }
            
            // Delete media record
            $media->delete();
        }
        
        return response()->json([
            'success' => true,
            'message' => count($mediaFiles) . ' files deleted successfully'
        ]);
    }
}
