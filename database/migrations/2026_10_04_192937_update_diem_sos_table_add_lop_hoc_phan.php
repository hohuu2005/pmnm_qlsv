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
        Schema::table('diem_sos', function (Blueprint $table) {
            // Thêm cột khóa ngoại mới liên kết với Lớp học phần (cho phép nullable để không bị lỗi với dữ liệu cũ)
            $table->foreignId('lop_hoc_phan_id')->nullable()->constrained('lop_hoc_phans')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('diem_sos', function (Blueprint $table) {
            $table->dropForeign(['lop_hoc_phan_id']);
            $table->dropColumn('lop_hoc_phan_id');
        });
    }
};
