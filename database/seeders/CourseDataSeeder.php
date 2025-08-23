<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseTag;
use Illuminate\Support\Str;

class CourseDataSeeder extends Seeder
{
    public function run()
    {
        // Create sample categories
        $categories = [
            ['name' => 'Programming', 'slug' => 'programming', 'description' => 'Learn programming languages and frameworks'],
            ['name' => 'Design', 'slug' => 'design', 'description' => 'Graphic design and UI/UX courses'],
            ['name' => 'Business', 'slug' => 'business', 'description' => 'Business and entrepreneurship courses'],
            ['name' => 'Marketing', 'slug' => 'marketing', 'description' => 'Digital marketing and SEO courses'],
            ['name' => 'Data Science', 'slug' => 'data-science', 'description' => 'Data analysis and machine learning'],
        ];

        foreach ($categories as $category) {
            CourseCategory::firstOrCreate(['slug' => $category['slug']], $category);
        }

        // Create sample tags
        $tags = [
            ['name' => 'Beginner', 'slug' => 'beginner'],
            ['name' => 'Advanced', 'slug' => 'advanced'],
            ['name' => 'JavaScript', 'slug' => 'javascript'],
            ['name' => 'Python', 'slug' => 'python'],
            ['name' => 'React', 'slug' => 'react'],
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'UI/UX', 'slug' => 'ui-ux'],
            ['name' => 'SEO', 'slug' => 'seo'],
        ];

        foreach ($tags as $tag) {
            CourseTag::firstOrCreate(['slug' => $tag['slug']], $tag);
        }

        // Create sample courses
        $courses = [
            [
                'title' => 'Complete Laravel Course for Beginners',
                'subtitle' => 'Learn Laravel from scratch to advanced',
                'slug' => 'complete-laravel-course',
                'description' => 'Master Laravel framework with this comprehensive course',
                'language' => 'en',
                'level' => 'beginner',
                'price_cents' => 9900,
                'currency' => 'EUR',
                'is_published' => true,
                'published_at' => now(),
                'created_by' => 1,
            ],
            [
                'title' => 'Advanced React Development',
                'subtitle' => 'Build modern web applications with React',
                'slug' => 'advanced-react-development',
                'description' => 'Learn advanced React patterns and best practices',
                'language' => 'en',
                'level' => 'advanced',
                'price_cents' => 14900,
                'currency' => 'EUR',
                'is_published' => true,
                'published_at' => now(),
                'created_by' => 1,
            ],
            [
                'title' => 'Digital Marketing Masterclass',
                'subtitle' => 'Complete guide to digital marketing',
                'slug' => 'digital-marketing-masterclass',
                'description' => 'Learn SEO, social media marketing, and more',
                'language' => 'en',
                'level' => 'intermediate',
                'price_cents' => 7900,
                'currency' => 'EUR',
                'is_published' => false,
                'created_by' => 1,
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::firstOrCreate(['slug' => $courseData['slug']], $courseData);
            
            // Attach random categories if not already attached
            if ($course->categories()->count() === 0) {
                $randomCategories = CourseCategory::inRandomOrder()->limit(rand(1, 2))->get();
                $course->categories()->attach($randomCategories);
            }
            
            // Attach random tags if not already attached
            if ($course->tags()->count() === 0) {
                $randomTags = CourseTag::inRandomOrder()->limit(rand(2, 4))->get();
                $course->tags()->attach($randomTags);
            }
        }
    }
}
