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
        Schema::create('mon_hocs', function (Blueprint $table) {
            $table->id();
            $table->string('ma_mon')->unique();
            $table->string('ten_mon');
            $table->integer('so_tin_chi');
            $table->string('loai_mon')->default('Bắt buộc'); // Bắt buộc, Tự chọn
            $table->string('khoa_phu_trach')->nullable(); // Khoa phụ trách môn học
            $table->string('trang_thai')->default('Đang giảng dạy'); // Ho
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mon_hocs');
    }
};
