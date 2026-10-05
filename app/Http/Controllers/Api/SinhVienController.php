<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SinhVien;
use App\Http\Resources\SinhVienResource;
use App\Http\Requests\StoreSinhVienRequest;
use Illuminate\Http\Request;


class SinhVienController extends Controller
{
    // Middleware nên được đăng ký ở định nghĩa route (Route::middleware(...))
    // để tránh gọi các API không tồn tại trên base Controller.

    // GET: /api/sinh-vien (Lấy danh sách)
    public function index()
    {
        $sinhViens = SinhVien::with('lopHoc')->get();
        // Dùng collection() khi trả về nhiều bản ghi
        return SinhVienResource::collection($sinhViens);
    }

    // POST: /api/sinh-vien (Thêm mới)
    public function store(StoreSinhVienRequest $request)
    {
        // Dữ liệu đã được kiểm duyệt tự động ở StoreSinhVienRequest
        $sinhVien = SinhVien::create($request->validated());
        
        // Trả về duy nhất 1 bản ghi vừa tạo kèm mã 201 (Created)
        return response()->json([
            'message' => 'Tạo sinh viên thành công',
            'data' => new SinhVienResource($sinhVien)
        ], 201);
    }

    // GET: /api/sinh-vien/{id} (Xem chi tiết)
    public function show($id)
    {
        $sinhVien = SinhVien::findOrFail($id);
        return new SinhVienResource($sinhVien);
    }
}