<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SinhVien;
use App\Models\LopHoc; // Đổi thành App\Models\Lop nếu cần
use App\Models\MonHoc;
use App\Models\BaiTap;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Đếm tổng số lượng dữ liệu
        $tongSinhVien = SinhVien::count();
        $tongLop = LopHoc::count(); // Đổi thành Lop::count() nếu cần
        $tongMon = MonHoc::count();
        $tongBaiTap = BaiTap::count();

        // Lấy 5 bài tập sắp đến hạn nộp (từ thời điểm hiện tại trở đi)
        $baiTapSapHan = BaiTap::with(['monHoc', 'lopHoc'])
            ->where('han_nop', '>=', Carbon::now())
            ->orderBy('han_nop', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact('tongSinhVien', 'tongLop', 'tongMon', 'tongBaiTap', 'baiTapSapHan'));
    }
}