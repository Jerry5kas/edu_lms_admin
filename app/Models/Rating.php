<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'rating', 'title',
        'review', 'is_public', 'moderated_at'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'moderated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
