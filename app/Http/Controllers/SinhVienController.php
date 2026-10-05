<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SinhVien;
use App\Models\LopHoc;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SinhVienController extends Controller
{
    // 1. Hiển thị danh sách sinh viên từ CSDL
    public function index(Request $request)
    {
        $query = \App\Models\SinhVien::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('ho_ten', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhere('ma_sv', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('ngay_sinh_tu')){
            $query->where('ngay_sinh', '>=', $request->ngay_sinh_tu);
        }
        if ($request->filled('ngay_sinh_den')){
            $query->where('ngay_sinh', '<=', $request->ngay_sinh_den);
        }
        
        $perPage = $request->input('per_page', 10);
        $sinhViens = $query->orderBy('id', 'desc')->paginate($perPage);
        
        return view('sinhvien.index', compact('sinhViens'));
    }

    // 2. Mở form thêm sinh viên
    public function create()
    {
        $lophocs = \App\Models\LopHoc::all();
        return view('sinhvien.add', compact('lophocs'));
    }

    // 3. Xử lý dữ liệu từ form và lưu vào Database
    public function store(Request $request)
    {
        $request->validate([
            'ma_sv'      => 'required|unique:sinh_viens,ma_sv',
            'ho_ten'     => 'required|min:3|max:50',
            'ngay_sinh'  => 'required|date',
            'email'      => 'required|email|unique:users,email',
            'lop_hoc_id' => 'required|exists:lop_hocs,id'
        ], [
            'ma_sv.unique' => 'Mã sinh viên này đã tồn tại trong hệ thống!',
            'email.unique' => 'Email này đã được sử dụng!'
        ]);

        // Tự động sinh tài khoản đăng nhập
        User::create([
            'name' => $request->ho_ten,
            'email' => $request->email,
            'password' => Hash::make('123456'), // Mật khẩu mặc định
            'role' => 'sinh_vien'
        ]);

        // Khởi tạo và gán dữ liệu hồ sơ sinh viên
        $sv = new SinhVien();
        $sv->ma_sv      = $request->ma_sv;
        $sv->ho_ten     = $request->ho_ten;
        $sv->ngay_sinh  = $request->ngay_sinh;
        $sv->email      = $request->email;
        $sv->lop_hoc_id = $request->lop_hoc_id;
        $sv->trang_thai = 'Đang học'; // Mặc định khi mới thêm
        $sv->save();

        return redirect('/sinh-vien')->with('success', 'Thêm sinh viên thành công! Mật khẩu mặc định: 123456');
    }

    // 4. Mở form sửa
    public function edit($id)
    {
        $sinhvien = SinhVien::findOrFail($id);
        return view('sinhvien.edit', compact('sinhvien'));
    }

    // 5. Cập nhật dữ liệu
    public function update(Request $request, $id)
    {
        $request->validate([
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|email',
            'ngay_sinh' => 'nullable|date',
        ]);
        
        $sinhVien = \App\Models\SinhVien::findOrFail($id);
        $sinhVien->update([
            'ma_sv' => $request->ma_sv ?? $sinhVien->ma_sv,
            'ho_ten' => $request->ho_ten,
            'email' => $request->email,
            'ngay_sinh' => $request->ngay_sinh,
        ]);

        return redirect('/sinh-vien')->with('success', 'Cập nhật thông tin thành công!');
    }

    // 6. Xóa sinh viên
    public function destroy($id)
    {
        $sv = SinhVien::findOrFail($id);
        $sv->delete();
        return redirect('/sinh-vien')->with('success','Sinh viên đã được xóa thành công!');
    }

    // 7. Xem chi tiết (Tùy chọn)
    public function show($id)
    {
        $sinhvien = SinhVien::find($id);

        if ($sinhvien) {
            return "Thông tin sinh viên: Tên: " . $sinhvien->ho_ten . ", Tuổi: " . $sinhvien->tuoi . ", Email: " . $sinhvien->email;
        } else {
            return "Không tìm thấy sinh viên với ID: " . $id;
        }
    }
}