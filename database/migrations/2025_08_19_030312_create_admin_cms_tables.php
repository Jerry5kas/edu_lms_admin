<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        /**x`
         * Admin Actions Audit
         */
        Schema::create('admin_actions_audit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->string('action'); // e.g. create_course, update_user
            $table->string('target_type')->nullable(); // model class
            $table->unsignedBigInteger('target_id')->nullable();
            $table->json('before_json')->nullable();
            $table->json('after_json')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        /**
         * Pages (Legal, FAQ, Policies)
         */
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('body');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('locale', 10)->default('de_DE');
            $table->json('meta')->nullable(); // SEO meta
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * Banners (Marketing / Homepage)
         */
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_path');
            $table->string('link_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('timings_json')->nullable(); // e.g. {"start":"2025-01-01","end":"2025-02-01"}
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('admin_actions_audit');
    }
};
