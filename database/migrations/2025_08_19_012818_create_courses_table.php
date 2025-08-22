<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->string('language', 8)->default('de');
            $table->enum('level', ['beginner','intermediate','advanced'])->default('beginner');
            $table->integer('price_cents')->default(0);
            $table->char('currency', 3)->default('EUR');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->string('trailer_url')->nullable();
            $table->json('meta')->nullable(); // duration_total, tags_cache
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('course_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('course_categories')->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('course_category_pivot', function (Blueprint $table) {
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('course_categories')->cascadeOnDelete();
            $table->primary(['course_id','category_id']);
        });

        Schema::create('course_tags', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('course_tag_pivot', function (Blueprint $table) {
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('course_tags')->cascadeOnDelete();
            $table->primary(['course_id','tag_id']);
        });

        Schema::create('course_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('section_id')->nullable()->constrained('course_sections')->nullOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('duration_seconds')->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_preview')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->enum('content_type', ['video','pdf','quiz','link'])->default('video');
            $table->enum('video_provider', ['youtube','s3','bunny'])->nullable();
            $table->string('video_ref')->nullable();
            $table->longText('transcript_text')->nullable();
            $table->json('attachment_json')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lesson_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->integer('seconds_watched')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->integer('last_position_seconds')->default(0);
            $table->timestamps();
            $table->unique(['user_id','lesson_id']);
        });

        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        // Placeholder for quiz questions/answers/submissions if added later

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('disk')->default('public');
            $table->string('path');
            $table->string('mime', 100);
            $table->unsignedBigInteger('size_bytes');
            $table->string('original_name');
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('lesson_views');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('course_sections');
        Schema::dropIfExists('course_tag_pivot');
        Schema::dropIfExists('course_tags');
        Schema::dropIfExists('course_category_pivot');
        Schema::dropIfExists('course_categories');
        Schema::dropIfExists('courses');
    }
};

