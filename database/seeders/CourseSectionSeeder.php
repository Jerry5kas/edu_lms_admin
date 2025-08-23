<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseSection;

class CourseSectionSeeder extends Seeder
{
    public function run()
    {
        // Get existing courses
        $courses = Course::all();

        foreach ($courses as $course) {
            // Create sections for each course
            $sections = [
                [
                    'title' => 'Introduction',
                    'sort_order' => 1,
                ],
                [
                    'title' => 'Getting Started',
                    'sort_order' => 2,
                ],
                [
                    'title' => 'Core Concepts',
                    'sort_order' => 3,
                ],
                [
                    'title' => 'Advanced Topics',
                    'sort_order' => 4,
                ],
                [
                    'title' => 'Project Work',
                    'sort_order' => 5,
                ],
            ];

            foreach ($sections as $sectionData) {
                CourseSection::firstOrCreate([
                    'course_id' => $course->id,
                    'title' => $sectionData['title'],
                ], [
                    'sort_order' => $sectionData['sort_order'],
                ]);
            }
        }
    }
}
