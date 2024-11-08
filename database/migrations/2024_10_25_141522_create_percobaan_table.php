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
        Schema::create('percobaan', function (Blueprint $table) {
            $table->id();
            $table->string('jumlah_gerakan');
            $table->string('waktu_gerakan');
            $table->string('jarak_perpindahan');
            $table->string('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('percobaan');
    }
};
