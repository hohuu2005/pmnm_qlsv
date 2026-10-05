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
        Schema::create('lop_hoc_phans', function (Blueprint $table) {
            $table->id();
            
            // Khóa ngoại liên kết với môn học
            $table->foreignId('mon_hoc_id')->constrained('mon_hocs')->cascadeOnDelete();
            
            // Thông tin lớp học phần (VD: 68PM2_Cơ_Sở_Dữ_Liệu)
            $table->string('ma_lop_hp')->unique(); 
            $table->string('ten_lop_hp'); 
            $table->string('giang_vien')->nullable();
            $table->integer('so_luong_sv')->default(50);
            $table->string('hoc_ky')->nullable(); // VD: Học kỳ 1 (2026-2027)
            $table->boolean('trang_thai')->default(true); // Đang mở / Đã đóng
            
            $table->timestamps();
        });
    }
};
