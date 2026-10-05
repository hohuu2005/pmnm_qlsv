<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiemSo extends Model
{
    use HasFactory;

    protected $fillable = [
        'sinh_vien_id',
        'lop_hoc_phan_id',
        'mon_hoc_id',
        'diem_chuyen_can',
        'diem_giua_ky',
        'diem_cuoi_ky',
        'diem_tong_ket',
        'trang_thai',
        'ghi_chu'
    ];

    // Thiết lập quan hệ: 1 Điểm số thuộc về 1 Sinh viên
    public function sinhVien()
    {
        return $this->belongsTo(SinhVien::class, 'sinh_vien_id');
    }

    // Thiết lập quan hệ: 1 Điểm số thuộc về 1 Lớp học phần
    public function lopHocPhan()
    {
        return $this->belongsTo(LopHocPhan::class, 'lop_hoc_phan_id');
    }
    public function monHoc()
    {
        return $this->belongsTo(MonHoc::class, 'mon_hoc_id');
    }
}