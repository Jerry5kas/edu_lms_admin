<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Display a listing of media files
     */
    public function index()
    {
        $media = Media::with('user')
            ->latest()
            ->paginate(20);

        return view('course.media.index', compact('media'));
    }

    /**
     * Show the form for uploading new media
     */
    public function create()
    {
        return view('course.media.create');
    }

    /**
     * Store a newly uploaded media file
     */
    public function store(Request $request)
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

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'media' => $media,
                'url' => $this->getSignedUrl($media),
            ]);
        }

        return redirect()->route('media.index')
            ->with('success', 'File uploaded successfully.');
    }

    /**
     * Display the specified media file
     */
    public function show(Media $media)
    {
        return view('course.media.show', compact('media'));
    }

    /**
     * Remove the specified media file
     */
    public function destroy($id)
    {
        $file = Media::findOrFail($id);
        $file->delete();

        return redirect()->route('media.index')->with('success', 'File deleted successfully!');
    }


    /**
     * Get signed URL for media file
     */
    public function getSignedUrl(Media $media)
    {
        $disk = Storage::disk($media->disk);

        if ($media->disk === 'public') {
            return $disk->url($media->path);
        }

        // For S3, Bunny, etc. - generate signed URL
        if (in_array($media->disk, ['s3', 'bunny'])) {
            return $disk->temporaryUrl($media->path, now()->addMinutes(60));
        }

        return $disk->url($media->path);
    }

    /**
     * Upload file via AJAX (for use in other forms)
     */
    public function upload(Request $request)
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
            'media' => $media,
            'url' => $this->getSignedUrl($media),
        ]);
    }

    /**
     * Get media files for selection (AJAX)
     */
    public function getMedia(Request $request)
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

        return response()->json($media);
    }

    /**
     * Get file info by path
     */
    public function getByPath(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $media = Media::where('path', $request->path)->first();

        if (!$media) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->json([
            'media' => $media,
            'url' => $this->getSignedUrl($media),
        ]);
    }

    /**
     * Bulk delete media files
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:media,id',
        ]);

        $mediaFiles = Media::whereIn('id', $request->ids)->get();

        foreach ($mediaFiles as $media) {
            // Delete file from storage
            if (Storage::disk($media->disk)->exists($media->path)) {
                Storage::disk($media->disk)->delete($media->path);
            }

            // Delete media record
            $media->delete();
        }

        return response()->json([
            'success' => true,
            'message' => count($mediaFiles) . ' files deleted successfully.',
        ]);
    }
}
