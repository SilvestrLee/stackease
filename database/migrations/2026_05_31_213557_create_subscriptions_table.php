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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('provider_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('concierge_request_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('invoice_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('subscription_reference')->unique();
            $table->string('provider_name');
            $table->string('plan_type')->nullable();
            $table->unsignedInteger('seat_count')->default(1);

            $table->date('start_date')->nullable();
            $table->date('renewal_date')->nullable();

            $table->decimal('amount', 14, 2)->default(0);
            $table->string('currency')->default('NGN');
            $table->string('status')->default('pending_setup');

            $table->text('access_note')->nullable();
            $table->text('internal_note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};