<?php

namespace App\Http\Controllers;

use App\Models\LopHoc;
use Illuminate\Http\Request;

class LopHocController extends Controller
{
    public function index(Request $request)
    {
        // 1. Khởi tạo query builder
        $query = LopHoc::query();

        // 2. Lọc theo Từ khóa (Tên lớp, Mã lớp, Giáo viên)
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('ten_lop', 'like', "%{$keyword}%")
                  ->orWhere('ma_lop', 'like', "%{$keyword}%")
                  ->orWhere('giao_vien', 'like', "%{$keyword}%");
            });
        }

        // 3. Lọc theo Trạng thái
        if ($request->filled('status') && $request->status !== 'Tất cả') {
            $query->where('trang_thai', $request->status);
        }

        // 4. Lọc theo khoảng Sĩ số (Từ - Đến)
        if ($request->filled('size_min')) {
            $query->where('si_so', '>=', $request->size_min);
        }
        if ($request->filled('size_max')) {
            $query->where('si_so', '<=', $request->size_max);
        }

        // 5. Xử lý phân trang (Số dòng / trang)
        // Mặc định là 10 nếu người dùng chưa chọn
        $perPage = $request->input('per_page', 10);
        
        // Thực thi truy vấn và phân trang
        $lopHocs = $query->orderBy('id', 'desc')->paginate($perPage);

        // 6. Trả về View cùng với dữ liệu
        return view('lophoc.index', compact('lopHocs'));
    }
    public function create()
    {
        return view('lophoc.add');
    }
    public function store(Request $request)
    {
        $request->validate([
            'ma_lop'     => 'required|unique:lop_hocs,ma_lop',
            'ten_lop'    => 'required',
            'giao_vien'  => 'required',
            'si_so'      => 'required|integer|min:1',
            'sdt_gvcn'   => 'nullable|string|max:15',
            'trang_thai' => 'required'
        ], [
            'ma_lop.unique' => 'Mã lớp này đã tồn tại trong hệ thống!'
        ]);

        LopHoc::create([
            'ma_lop'     => $request->ma_lop,
            'ten_lop'    => $request->ten_lop,
            'giao_vien'  => $request->giao_vien,
            'sdt_gvcn'   => $request->sdt_gvcn,
            'ghi_chu'    => $request->ghi_chu,
            'si_so'      => $request->si_so,
            'trang_thai' => $request->trang_thai
        ]);

        return redirect()->route('lophoc.index')->with('success', 'Thêm lớp học thành công!');
    }
    public function edit($id)
    {
        $lophoc = LopHoc::findOrFail($id);
        return view('lophoc.edit', compact('lophoc'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // Bỏ qua kiểm tra unique đối với chính bản ghi đang sửa
            'ma_lop'     => 'required|unique:lop_hocs,ma_lop,' . $id,
            'ten_lop'    => 'required',
            'giao_vien'  => 'required',
            'si_so'      => 'required|integer|min:1',
            'sdt_gvcn'   => 'nullable|string|max:15',
            'trang_thai' => 'required'
        ], [
            'ma_lop.unique' => 'Mã lớp này đã tồn tại trong hệ thống!'
        ]);

        $lophoc = LopHoc::findOrFail($id);
        $lophoc->update([
            'ma_lop'     => $request->ma_lop,
            'ten_lop'    => $request->ten_lop,
            'giao_vien'  => $request->giao_vien,
            'sdt_gvcn'   => $request->sdt_gvcn,
            'ghi_chu'    => $request->ghi_chu,
            'si_so'      => $request->si_so,
            'trang_thai' => $request->trang_thai
        ]);

        return redirect()->route('lophoc.index')->with('success', 'Cập nhật lớp học thành công!');
    }

    public function destroy($id)
    {
        try {
            $lophoc = LopHoc::findOrFail($id);
            $lophoc->delete();

            
        
            return redirect()->route('lophoc.index')->with('error', 'Không thể xóa lớp học này vì có liên kết với dữ liệu khác.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
              return redirect()->route('lophoc.index')->with('error', 'Không thể xóa lớp học này vì có liên kết với dữ liệu khác.');     
    }
    return redirect()->route('lophoc.index')->with('error', 'Đã xảy ra lỗi khi xóa lớp học.');
    }
}
}