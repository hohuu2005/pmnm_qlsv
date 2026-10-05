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
        Schema::create('sinh_viens', function (Blueprint $table) {
            $table->id();
            
            // 1. Cột định danh tử huyệt
            $table->string('ma_sv')->unique(); 
            
            // 2. Thông tin nhân thân chuẩn
            $table->string('ho_ten');
            $table->date('ngay_sinh')->nullable(); // Thay thế hoàn toàn cột 'tuoi'
            $table->string('email')->unique();
            
            // 3. Khóa ngoại: Sinh viên này thuộc về lớp nào?
            // Dùng onDelete('restrict') để không cho phép xóa Lớp nếu lớp đó vẫn còn Sinh viên
            $table->foreignId('lop_hoc_id')->constrained('lop_hocs')->onDelete('restrict');
            
            // 4. Trạng thái học vụ
            $table->string('trang_thai')->default('Đang học'); // Đang học, Bảo lưu, Đã tốt nghiệp...
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinh_viens');
    }
};
