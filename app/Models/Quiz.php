<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['lesson_id', 'title', 'settings'];

    protected $casts = [
        'settings' => 'array',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}

