<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('provider_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->decimal('regular_price', 12, 2)->nullable();
            $table->decimal('deal_price', 12, 2)->nullable();
            $table->unsignedTinyInteger('discount_percent')->nullable();

            $table->string('deal_url')->nullable();
            $table->string('badge')->nullable();

            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->string('status')->default('draft');
            $table->boolean('is_featured')->default(false);

            $table->timestamps();

            $table->index(['status', 'is_featured']);
            $table->index(['provider_id', 'category_id']);
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};