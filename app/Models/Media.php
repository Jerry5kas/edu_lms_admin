<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = [
        'user_id',
        'disk',
        'path',
        'mime',
        'size_bytes',
        'original_name',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'size_bytes' => 'integer',
    ];

    /**
     * Get the user who uploaded this media
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the file URL
     */
    public function getUrlAttribute()
    {
        if (!$this->path) {
            return null;
        }
        
        $disk = Storage::disk($this->disk);
        
        if ($this->disk === 'public') {
            return $disk->url($this->path);
        }
        
        // For S3, Bunny, etc. - generate signed URL
        if (in_array($this->disk, ['s3', 'bunny'])) {
            return $disk->temporaryUrl($this->path, now()->addMinutes(60));
        }
        
        return $disk->url($this->path);
    }

    /**
     * Get file size in human readable format
     */
    public function getSizeFormattedAttribute()
    {
        $bytes = $this->size_bytes;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if file is an image
     */
    public function getIsImageAttribute()
    {
        return str_starts_with($this->mime, 'image/');
    }

    /**
     * Check if file is a video
     */
    public function getIsVideoAttribute()
    {
        return str_starts_with($this->mime, 'video/');
    }

    /**
     * Check if file is a document
     */
    public function getIsDocumentAttribute()
    {
        $documentMimes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'text/plain',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];
        
        return in_array($this->mime, $documentMimes);
    }

    /**
     * Get file extension
     */
    public function getExtensionAttribute()
    {
        return $this->meta['extension'] ?? pathinfo($this->original_name, PATHINFO_EXTENSION);
    }

    /**
     * Get thumbnail URL for images
     */
    public function getThumbnailUrlAttribute()
    {
        if (!$this->is_image) {
            return null;
        }
        
        // For now, return the same URL as the main image
        // In a real implementation, you might generate thumbnails
        return $this->url;
    }

    /**
     * Scope to filter by file type
     */
    public function scopeOfType($query, $type)
    {
        switch ($type) {
            case 'image':
                return $query->where('mime', 'like', 'image/%');
            case 'video':
                return $query->where('mime', 'like', 'video/%');
            case 'document':
                return $query->whereIn('mime', [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'text/plain',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ]);
            default:
                return $query;
        }
    }

    /**
     * Scope to search by filename
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('original_name', 'like', "%{$search}%");
    }

    /**
     * Delete the file when the model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($media) {
            // Delete file from storage
            if ($media->path && Storage::disk($media->disk)->exists($media->path)) {
                Storage::disk($media->disk)->delete($media->path);
            }
        });
    }
}

