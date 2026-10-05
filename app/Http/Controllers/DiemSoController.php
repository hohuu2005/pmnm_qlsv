<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiemSo;
use App\Models\SinhVien;
use App\Models\MonHoc;
use App\Models\LopHoc; // Đổi thành App\Models\Lop nếu Model của bạn tên là Lop

class DiemSoController extends Controller
{
    // Màn hình 1: Chọn Môn học và Lớp hành chính
    public function chonMonLop()
    {
        $monHocs = MonHoc::all();
        $lopHocs = LopHoc::all(); // Đổi thành Lop::all() nếu dùng model Lop
        return view('diemso.chon_mon_lop', compact('monHocs', 'lopHocs'));
    }

    // Màn hình 2: Bảng Grid điểm của lớp
    public function nhapDiemGrid(Request $request)
    {
        $mon_hoc_id = $request->query('mon_hoc_id');
        $lop_hoc_id = $request->query('lop_hoc_id');

        if (!$mon_hoc_id || !$lop_hoc_id) {
            return redirect()->route('diemso.chon_mon_lop')->with('error', 'Vui lòng chọn đầy đủ Môn học và Lớp học.');
        }

        $monHoc = MonHoc::findOrFail($mon_hoc_id);
        $lopHoc = LopHoc::findOrFail($lop_hoc_id);

        // LẤY SINH VIÊN THEO LỚP HỌC (Sửa 'lop_hoc_id' nếu cột khóa ngoại của bạn tên khác)
        $sinhViens = SinhVien::where('lop_hoc_id', $lopHoc->id)->get();

        // Lấy điểm hiện tại của các sinh viên này trong môn học đã chọn
        $studentIds = $sinhViens->pluck('id');
        $diemSos = DiemSo::where('mon_hoc_id', $monHoc->id)
                         ->whereIn('sinh_vien_id', $studentIds)
                         ->get()
                         ->keyBy('sinh_vien_id');

        return view('diemso.grid', compact('monHoc', 'lopHoc', 'sinhViens', 'diemSos'));
    }

    // Xử lý lưu điểm
    public function luuDiemGrid(Request $request, $mon_hoc_id)
    {
        $diemData = $request->input('diem');

        if (!$diemData) {
            return redirect()->back()->with('error', 'Không có dữ liệu điểm để lưu.');
        }

        foreach ($diemData as $sinh_vien_id => $diem) {
            if ($diem['cc'] !== null || $diem['gk'] !== null || $diem['ck'] !== null) {
                
                $tong_ket = null;
                $trang_thai = 'Chưa hoàn thành';

                if ($diem['cc'] !== null && $diem['gk'] !== null && $diem['ck'] !== null) {
                    $tong = ($diem['cc'] * 0.1) + ($diem['gk'] * 0.3) + ($diem['ck'] * 0.6);
                    $tong_ket = round($tong, 2);
                    $trang_thai = $tong_ket >= 4.0 ? 'Đạt' : 'Học lại';
                }

                // Lưu trực tiếp vào sinh_vien_id và mon_hoc_id (bỏ qua lop_hoc_phan)
                DiemSo::updateOrCreate(
                    [
                        'mon_hoc_id' => $mon_hoc_id, 
                        'sinh_vien_id' => $sinh_vien_id
                    ],
                    [
                        'diem_chuyen_can' => $diem['cc'],
                        'diem_giua_ky' => $diem['gk'],
                        'diem_cuoi_ky' => $diem['ck'],
                        'diem_tong_ket' => $tong_ket,
                        'trang_thai' => $trang_thai
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Đã lưu và cập nhật bảng điểm thành công!');
    }
}