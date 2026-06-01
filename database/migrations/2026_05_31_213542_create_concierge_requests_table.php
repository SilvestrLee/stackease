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
        Schema::create('concierge_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('provider_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('batch_window_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('request_reference')->unique();
            $table->string('service_name');
            $table->string('request_type')->default('subscription_setup');
            $table->string('desired_plan')->nullable();
            $table->unsignedInteger('seat_count')->default(1);
            $table->string('duration')->nullable();
            $table->string('budget_range')->nullable();
            $table->boolean('existing_account')->default(false);
            $table->text('issue_description')->nullable();
            $table->text('user_notes')->nullable();
            $table->text('admin_notes')->nullable();

            $table->string('status')->default('submitted');
            $table->string('priority')->default('normal');

            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concierge_requests');
    }
};