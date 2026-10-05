<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SinhVien;
use App\Models\DiemSo;
use App\Models\BaiTap;
use App\Models\NopBai;

class SinhVienPortalController extends Controller
{
    // 1. GIAO DIỆN TRA CỨU ĐIỂM
   public function traCuuDiem()
    {
        // Truy xuất hồ sơ sinh viên dựa trên Email của tài khoản đang đăng nhập
        $sinhVien = SinhVien::where('email', Auth::user()->email)->first(); 
        
        // Nếu không tìm thấy (ví dụ tài khoản admin nhảy nhầm vào đây, hoặc chưa nhập email cho sinh viên này)
        if(!$sinhVien) {
            return redirect()->route('dashboard')->with('error', 'Tài khoản của bạn chưa được liên kết với hồ sơ Sinh viên nào!');
        }

        // Lấy điểm của ĐÚNG sinh viên đó
        $diemSos = DiemSo::with('monHoc')->where('sinh_vien_id', $sinhVien->id)->get();
        
        return view('sinhvien_portal.diem', compact('diemSos', 'sinhVien'));
    }
    // 2. GIAO DIỆN DANH SÁCH BÀI TẬP VÀ NỘP BÀI
    public function baiTap()
    {
        $baiTaps = BaiTap::with(['monHoc', 'lopHoc'])->orderBy('han_nop', 'asc')->get();
        
        // Lấy danh sách ID các bài tập mà tài khoản này đã nộp để làm logic ẩn hiện nút "Nộp bài"
        $daNop = NopBai::where('user_id', Auth::id())->pluck('bai_tap_id')->toArray();

        return view('sinhvien_portal.baitap', compact('baiTaps', 'daNop'));
    }

    // 3. LOGIC XỬ LÝ UPLOAD FILE NỘP BÀI
    public function nopBai(Request $request, $bai_tap_id)
    {
        $request->validate([
            'file_nop' => 'required|file|mimes:zip,rar,pdf,doc,docx|max:15360',
        ]);

        $file = $request->file('file_nop');
        $filename = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/nopbai'), $filename);

        NopBai::create([
            'bai_tap_id' => $bai_tap_id,
            'user_id' => Auth::id(),
            'file_nop' => 'uploads/nopbai/' . $filename
        ]);

        return back()->with('success', 'Đã nộp bài tập thành công!');
    }
}