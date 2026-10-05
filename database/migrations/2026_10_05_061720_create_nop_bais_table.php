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
        Schema::create('nop_bais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bai_tap_id')->constrained('bai_taps')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Lưu ID tài khoản đăng nhập nộp bài
            $table->string('file_nop');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('nop_bais');
    }
};
