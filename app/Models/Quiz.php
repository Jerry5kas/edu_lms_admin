<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'lesson_id',
        'title',
//        'description',
        'settings'
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function course()
    {
        return $this->hasOneThrough(Course::class, Lesson::class, 'id', 'id', 'lesson_id', 'course_id');
    }

    /**
     * Check if quiz is active
     */
    public function isActive()
    {
        return $this->settings['is_active'] ?? true;
    }

    /**
     * Get time limit in minutes
     */
    public function getTimeLimit()
    {
        return $this->settings['time_limit'] ?? null;
    }

    /**
     * Get passing score percentage
     */
    public function getPassingScore()
    {
        return $this->settings['passing_score'] ?? 70;
    }

    /**
     * Get maximum attempts allowed
     */
    public function getMaxAttempts()
    {
        return $this->settings['max_attempts'] ?? 3;
    }

    /**
     * Check if questions should be shuffled
     */
    public function shouldShuffleQuestions()
    {
        return $this->settings['shuffle_questions'] ?? false;
    }

    /**
     * Check if results should be shown
     */
    public function shouldShowResults()
    {
        return $this->settings['show_results'] ?? true;
    }

    /**
     * Check if review is allowed
     */
    public function allowReview()
    {
        return $this->settings['allow_review'] ?? true;
    }
}

