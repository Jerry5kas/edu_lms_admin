<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'enrollment_id','certificate_no','issued_at',
        'pdf_path','verification_code','revoked_at'
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Enrollment::class, 'id', 'id', 'enrollment_id', 'user_id');
    }

    public function course()
    {
        return $this->hasOneThrough(Course::class, Enrollment::class, 'id', 'id', 'enrollment_id', 'course_id');
    }
}
