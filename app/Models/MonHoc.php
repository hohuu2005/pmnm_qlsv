<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonHoc extends Model
{
    use HasFactory;
    protected $fillable = [
        'ma_mon',
        'ten_mon',
        'so_tin_chi',
        'loai_mon',
        'khoa_phu_trach',
        'trang_thai'
    ];
    //
}
