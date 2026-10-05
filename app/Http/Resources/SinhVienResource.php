<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SinhVienResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ma_sinh_vien' => $this->ma_sv,
            'ho_ten' => $this->ho_ten,
            'thong_tin_lien_he' => [
                'email' => $this->email,
            ],
            // Tự động lấy tên lớp nếu có quan hệ, nếu không trả về null
            'lop_hoc' => $this->lopHoc->ten_lop ?? null, 
            'trang_thai' => $this->trang_thai,
        ];
    }
}
