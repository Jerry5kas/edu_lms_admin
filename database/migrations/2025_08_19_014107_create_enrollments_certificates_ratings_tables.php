<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->enum('source', ['purchase', 'admin_grant', 'coupon', 'bundle'])->default('purchase');
            $table->enum('status', ['active', 'revoked', 'refunded', 'expired'])->default('active');
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'course_id']); // one enrollment per user/course
        });

        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('enrollments')->cascadeOnDelete();
            $table->string('certificate_no')->unique();
            $table->timestamp('issued_at')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('verification_code')->unique();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();
        });

        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('rating'); // 1-5
            $table->string('title')->nullable();
            $table->text('review')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamp('moderated_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'course_id']); // one rating per user/course
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('enrollments');
    }
};
