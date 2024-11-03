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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();  // Full Name
            $table->string('username')->nullable()->unique();  // Username
            $table->string('email')->nullable()->unique();  // Email
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();  // Password
            $table->string('role')->default('0')->nullable();  // Role
            $table->string('place_of_birth')->nullable();  // Place of Birth
            $table->date('date_of_birth')->nullable();  // Date of Birth
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
