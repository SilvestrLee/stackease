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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('business_name')->nullable();
            $table->string('country')->default('Nigeria');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('business_type')->nullable();
            $table->string('team_size')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};