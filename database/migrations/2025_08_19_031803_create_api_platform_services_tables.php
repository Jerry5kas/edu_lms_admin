<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        /**
         * API Clients (partners or apps using your API)
         */
        Schema::create('api_clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key')->unique(); // API key
            $table->json('scopes')->nullable(); // e.g. ["read:courses","write:orders"]
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });

        /**
         * Rate Limits (optional)
         */
        Schema::create('rate_limits', function (Blueprint $table) {
            $table->id();
            $table->string('key'); // API key or user key
            $table->string('period'); // e.g. "minute", "hour"
            $table->integer('max_requests')->default(60);
            $table->timestamp('window_started_at')->nullable();
            $table->integer('request_count')->default(0);
            $table->timestamps();

            $table->index(['key', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rate_limits');
        Schema::dropIfExists('api_clients');
    }
};
