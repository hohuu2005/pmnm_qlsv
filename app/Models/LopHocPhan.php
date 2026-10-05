<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LopHocPhan extends Model
{
    use HasFactory;
    protected $fillable = [
        'mon_hoc_id',
        'ma_lop_hp',
        'ten_lop_hp',
        'giang_vien',
        'so_luong_sv',
        'hoc_ky',
        'trang_thai'
    ];
    public function monHoc()
    {
        return $this->belongsTo(MonHoc::class, 'mon_hoc_id');
    }
    //
}
