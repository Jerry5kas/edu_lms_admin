<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseSection extends Model
{
    use SoftDeletes;

    protected $fillable = ['course_id', 'title', 'sort_order'];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'section_id');
    }

    /**
     * Get lessons count for this section
     */
    public function getLessonsCountAttribute()
    {
        return $this->lessons()->count();
    }

    /**
     * Get total duration of all lessons in this section
     */
    public function getTotalDurationAttribute()
    {
        return $this->lessons()->sum('duration_seconds');
    }

    /**
     * Scope to order by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}


