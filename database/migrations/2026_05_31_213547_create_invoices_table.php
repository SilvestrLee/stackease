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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('concierge_request_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('invoice_reference')->unique();

            $table->decimal('base_usd_cost', 12, 2)->default(0);
            $table->decimal('fx_rate', 12, 2)->default(0);
            $table->decimal('fx_buffer_percent', 5, 2)->default(10);
            $table->decimal('fx_buffer_amount', 12, 2)->default(0);
            $table->decimal('service_fee', 12, 2)->default(0);
            $table->decimal('gateway_fee', 12, 2)->default(0);
            $table->decimal('total_naira_amount', 14, 2)->default(0);

            $table->string('currency')->default('NGN');
            $table->string('status')->default('draft');

            $table->timestamp('sent_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};