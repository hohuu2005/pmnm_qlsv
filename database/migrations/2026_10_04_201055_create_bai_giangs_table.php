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
        Schema::create('bai_giangs', function (Blueprint $table) {
            $table->id();
            
            // Khóa ngoại liên kết với bảng mon_hocs
            $table->foreignId('mon_hoc_id')->constrained('mon_hocs')->cascadeOnDelete();
            
            $table->string('tieu_de');
            $table->integer('thu_tu')->default(1); // Bài 1, Bài 2...
            $table->string('video_url')->nullable(); // Link YouTube
            $table->string('file_dinh_kem')->nullable(); // Đường dẫn file upload
            
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('bai_giangs');
    }
};
