<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BaiTap extends Model
{
    use HasFactory;
    protected $fillable = [
        'mon_hoc_id',
        'tieu_de',
        'lop_hoc_id',
        'noi_dung',
        'file_de_bai',
        'han_nop'
    ];
    public function monHoc()
    {
        return $this->belongsTo(MonHoc::class, 'mon_hoc_id');
    }
    public function lopHoc()
    {
        return $this->belongsTo(LopHoc::class, 'lop_hoc_id');
    }
    //
}
