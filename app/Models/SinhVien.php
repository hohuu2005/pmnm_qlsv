<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SinhVien extends Model
{
    use HasFactory;

    // Khai báo các cột được phép thêm/sửa hàng loạt (Mass Assignment)
    protected $fillable = [
        'ma_sv', 
        'ho_ten', 
        'ngay_sinh', 
        'email', 
        'lop_hoc_id', 
        'trang_thai'
    ];

    // Thiết lập quan hệ N-1: Nhiều Sinh viên thuộc về 1 Lớp học
    public function lopHoc()
    {
        return $this->belongsTo(LopHoc::class, 'lop_hoc_id', 'id');
    }
}