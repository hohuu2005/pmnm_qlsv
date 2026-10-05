<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BaiGiang extends Model
{
    use HasFactory;
    protected $fillable = [
        'mon_hoc_id',
        'tieu_de',
        'thu_tu',
        'video_url',
        'file_dinh_kem'
    ];
    public function monHoc()
    {
        return $this->belongsTo(MonHoc::class, 'mon_hoc_id');
    }
    //
}
