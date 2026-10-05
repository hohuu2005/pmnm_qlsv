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
        Schema::create('lop_hocs', function (Blueprint $table) {
            $table->id();
            $table->string('ma_lop')->unique();
            $table->string('ten_lop');
            $table->string('giao_vien');
            
            // BẮT BUỘC PHẢI CÓ ->nullable() Ở 2 CỘT NÀY
            $table->string('sdt_gvcn')->nullable(); 
            $table->text('ghi_chu')->nullable();
            
            $table->string('trang_thai')->default('Hoạt động');
            $table->integer('si_so')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lop_hocs');
    }
};