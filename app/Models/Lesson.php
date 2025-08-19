<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'course_id','section_id','title','slug','description',
        'duration_seconds','sort_order','is_preview','is_published',
        'published_at','content_type','video_provider','video_ref',
        'transcript_text','attachment_json'
    ];

    protected $casts = [
        'is_preview' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'attachment_json' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function section()
    {
        return $this->belongsTo(CourseSection::class);
    }

    public function views()
    {
        return $this->hasMany(LessonView::class);
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }
}

