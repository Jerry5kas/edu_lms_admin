<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTag extends Model
{
    protected $fillable = ['slug', 'name'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_tag_pivot', 'tag_id', 'course_id');
    }
}
