<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonView extends Model
{
    protected $fillable = [
        'user_id', 'lesson_id', 'seconds_watched',
        'completed_at', 'last_position_seconds'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}

