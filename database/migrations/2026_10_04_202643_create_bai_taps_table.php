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
        Schema::create('bai_taps', function (Blueprint $table) {
            $table->id();
            
            // Khóa ngoại liên kết Môn học và Lớp hành chính
            $table->foreignId('mon_hoc_id')->constrained('mon_hocs')->cascadeOnDelete();
            
            // LƯU Ý: Nếu bảng lớp học của bạn trong DB tên là 'lops' chứ không phải 'lop_hocs', hãy sửa lại chữ 'lop_hocs' ở dòng dưới cho khớp nhé.
            $table->foreignId('lop_hoc_id')->constrained('lop_hocs')->cascadeOnDelete();
            
            $table->string('tieu_de'); // Tên bài tập
            $table->text('noi_dung')->nullable(); // Mô tả hoặc yêu cầu đề bài
            $table->string('file_de_bai')->nullable(); // File đính kèm đề (PDF, Word...)
            $table->dateTime('han_nop'); // Thời hạn nộp bài
            
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('bai_taps');
    }
};
