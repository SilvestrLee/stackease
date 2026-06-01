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
        Schema::create('batch_windows', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->time('cutoff_time');
            $table->time('fulfillment_start_time');
            $table->time('fulfillment_end_time');
            $table->string('timezone')->default('Africa/Lagos');
            $table->unsignedInteger('capacity_limit')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_windows');
    }
};