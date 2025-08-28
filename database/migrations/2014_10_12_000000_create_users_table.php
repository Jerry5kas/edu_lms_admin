<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        // Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default(DB::raw('(UUID())'))->unique();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_e164', 20)->unique()->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('locale', 10)->default('de_DE');
            $table->string('timezone', 64)->default('Europe/Berlin');
            $table->char('country_code', 2)->default('DE');
            $table->date('date_of_birth')->nullable();
            $table->boolean('marketing_opt_in')->default(false);
            $table->string('legal_acceptance_version')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // Social accounts
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('provider');
            $table->string('provider_user_id');
            $table->string('provider_email')->nullable();
            $table->string('avatar_url')->nullable();
            $table->json('raw_json')->nullable();
            $table->timestamps();
        });

        // OTP verifications
        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('phone_e164', 20);
            $table->string('code_hash');
            $table->enum('purpose', ['login','register','2fa']);
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('expires_at');
            $table->timestamp('verified_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        // Communication preferences
        Schema::create('communication_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('email_course_updates')->default(true);
            $table->boolean('email_promotions')->default(false);
            $table->boolean('sms_otp')->default(true);
            $table->boolean('sms_marketing')->default(false);
            $table->timestamps();
        });

        // User addresses
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['billing','shipping']);
            $table->string('name');
            $table->string('line1');
            $table->string('line2')->nullable();
            $table->string('city');
            $table->string('postal_code', 20);
            $table->string('region')->nullable();
            $table->char('country_code', 2)->default('DE');
            $table->string('vat_id')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        // GDPR requests
        Schema::create('gdpr_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['export','erasure']);
            $table->enum('status', ['requested','in_progress','completed','rejected'])->default('requested');
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('processed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Laravel default: password_resets + personal_access_tokens handled by Sanctum
    }

    public function down(): void
    {
        Schema::dropIfExists('gdpr_requests');
        Schema::dropIfExists('user_addresses');
        Schema::dropIfExists('communication_preferences');
        Schema::dropIfExists('otp_verifications');
        Schema::dropIfExists('social_accounts');
        Schema::dropIfExists('users');
    }

};
