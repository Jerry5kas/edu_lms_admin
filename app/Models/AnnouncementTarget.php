<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'announcement_id',
        'role',
        'segment_json',
    ];

    protected $casts = [
        'segment_json' => 'array',
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'announcement_id');
    }
}
