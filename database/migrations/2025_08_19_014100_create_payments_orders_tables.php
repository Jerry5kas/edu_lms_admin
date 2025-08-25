<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->char('currency', 3)->default('EUR');
            $table->integer('amount_cents')->default(0);
            $table->integer('discount_cents')->default(0);
            $table->integer('tax_cents')->default(0);
            $table->integer('total_cents')->default(0);
            $table->enum('status', ['pending','paid','failed','cancelled','refunded'])->default('pending');
            $table->enum('gateway', ['razorpay'])->default('razorpay');
            $table->string('gateway_order_id')->unique();
            $table->json('notes')->nullable();
            $table->timestamp('placed_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();
        });

        // Order items
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->integer('unit_price_cents');
            $table->integer('quantity')->default(1);
            $table->integer('line_total_cents');
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        // Payments
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('amount_cents');
            $table->char('currency', 3)->default('EUR');
            $table->enum('gateway', ['razorpay'])->default('razorpay');
            $table->string('gateway_payment_id')->unique();
            $table->string('gateway_signature')->nullable();
            $table->enum('method', ['card','upi','netbanking'])->nullable();
            $table->enum('status', ['created','authorized','captured','failed','refunded'])->default('created');
            $table->string('error_code')->nullable();
            $table->text('error_description')->nullable();
            $table->timestamp('captured_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->json('raw_payload')->nullable();
            $table->timestamps();
        });

        // Webhook events
        Schema::create('webhook_events', function (Blueprint $table) {
            $table->id();
            $table->enum('provider', ['razorpay']);
            $table->string('event_type');
            $table->string('event_id')->unique();
            $table->json('payload');
            $table->timestamp('processed_at')->nullable();
            $table->enum('processing_status', ['pending','processed','failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamp('received_at')->useCurrent();
        });


        // Refunds
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->integer('amount_cents');
            $table->string('reason')->nullable();
            $table->string('gateway_refund_id')->unique();
            $table->string('status')->default('pending');
            $table->json('raw_payload')->nullable();
            $table->timestamps();
        });

        // Invoices
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('invoice_no')->unique();
            $table->timestamp('issued_at')->nullable();
            $table->string('billing_name');
            $table->json('address_json');
            $table->json('line_items_json');
            $table->json('totals_json');
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('refunds');
        Schema::dropIfExists('webhook_events');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
