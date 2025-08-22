<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'slug', 'title', 'subtitle', 'description',
        'language', 'level', 'price_cents', 'currency',
        'is_published', 'published_at', 'thumbnail_path', 'trailer_url', 'meta',
        'created_by', 'updated_by'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'meta' => 'array',
    ];

    // Auto-generate UUID
    protected static function booted()
    {
        static::creating(function ($course) {
            if (empty($course->uuid)) {
                $course->uuid = Str::uuid();
            }
        });
    }

    public function categories()
    {
        return $this->belongsToMany(CourseCategory::class, 'course_category_pivot');
    }

    public function tags()
    {
        return $this->belongsToMany(CourseTag::class, 'course_tag_pivot');
    }

    public function sections()
    {
        return $this->hasMany(CourseSection::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
