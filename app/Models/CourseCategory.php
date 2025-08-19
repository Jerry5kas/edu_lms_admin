<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    protected $fillable = ['parent_id', 'slug', 'name', 'description', 'sort_order'];

    public function parent()
    {
        return $this->belongsTo(CourseCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(CourseCategory::class, 'parent_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_category_pivot');
    }
}
