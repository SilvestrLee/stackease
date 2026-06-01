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
        Schema::create('invoice_pricing_snapshots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invoice_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('provider_cost_amount', 12, 2)->default(0);
            $table->string('provider_cost_currency')->default('USD');
            $table->decimal('fx_rate', 12, 2)->default(0);
            $table->decimal('local_provider_cost', 14, 2)->default(0);
            $table->decimal('fx_buffer_percent', 5, 2)->default(10);
            $table->decimal('fx_buffer_amount', 14, 2)->default(0);
            $table->decimal('service_fee', 14, 2)->default(0);
            $table->decimal('gateway_fee', 14, 2)->default(0);
            $table->decimal('final_total', 14, 2)->default(0);

            $table->string('rate_source')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->json('metadata')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_pricing_snapshots');
    }
};