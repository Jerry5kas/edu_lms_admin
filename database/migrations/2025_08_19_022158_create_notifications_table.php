<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            // Laravel default
            $table->uuid('id')->primary();
            $table->string('type'); // Notification class name
            $table->morphs('notifiable'); // user / dashboard / etc
            $table->text('data'); // payload
            $table->timestamp('read_at')->nullable();

            // 🔥 Custom fields merged in
            $table->enum('channel', ['email','sms','in_app'])->default('in_app');
            $table->enum('category', ['system','marketing','enrollment','payment'])->default('system'); // previously 'type'
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->json('meta')->nullable();
            $table->timestamp('scheduled_for')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->string('error_message')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });

        // Announcement targets (broadcast audiences)
        Schema::create('announcement_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('announcement_id')
                ->constrained('notifications')
                ->cascadeOnDelete();
            $table->enum('role', ['all courses','dashboard','instructor'])->nullable();
            $table->json('segment_json')->nullable(); // advanced targeting rules
            $table->timestamps();
        });

        // SMS logs
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('phone_e164', 20)->nullable();
            $table->string('template_key')->nullable();
            $table->text('message');
            $table->string('provider_message_id')->nullable();
            $table->string('status')->default('pending');
            $table->string('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->json('response_json')->nullable();
            $table->timestamps();
        });

        // Email logs
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('email')->nullable();
            $table->string('template_key')->nullable();
            $table->string('subject')->nullable();
            $table->string('status')->default('pending');
            $table->string('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->json('response_json')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
        Schema::dropIfExists('sms_logs');
        Schema::dropIfExists('announcement_targets');
        Schema::dropIfExists('notifications');
    }
};
