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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('status')->default('active')->after('password');
            $table->string('user_type')->default('individual')->after('status');
            $table->string('preferred_contact_method')->nullable()->after('user_type');
            $table->timestamp('last_login_at')->nullable()->after('preferred_contact_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'status',
                'user_type',
                'preferred_contact_method',
                'last_login_at',
            ]);
        });
    }
};