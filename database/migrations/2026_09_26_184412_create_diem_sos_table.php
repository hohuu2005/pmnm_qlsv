<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diem_sos', function (Blueprint $table) {
            $table->id();
            
            // Khóa ngoại liên kết với bảng sinh_viens
            $table->foreignId('sinh_vien_id')->constrained('sinh_viens')->cascadeOnDelete();
            $table->foreignId('mon_hoc_id')->constrained('mon_hocs')->cascadeOnDelete();
            
            // Các cột lưu thông tin điểm
           
            $table->float('diem_chuyen_can')->nullable();
            $table->float('diem_giua_ky')->nullable();
            $table->float('diem_cuoi_ky')->nullable();
            $table->float('diem_tong_ket')->nullable();
            $table->string('trang_thai')->nullable();
            $table->string('ghi_chu')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diem_sos');
    }
};