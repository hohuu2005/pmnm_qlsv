<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonHoc;

class MonHocController extends Controller
{
    public function index(Request $request)
    {
        $query = Monhoc::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('ma_mon', 'like', "%$keyword%")
                  ->orWhere('ten_mon', 'like', "%$keyword%")
                  ->orWhere('khoa_phu_trach', 'like', "%$keyword%");
            });
        }
        if ($request->filled('loai_mon') && $request->loai_mon !== 'Tất cả') {
            $query->where('loai_mon', $request->loai_mon);
        }
        if ($request->filled('tin_chi')) {
            $query->where('so_tin_chi', $request->tin_chi);
        }
    $perPage = $request->input('per_page', 10);
    $monHocs = $query->orderBy('id', 'desc')->paginate($perPage);
    return view('monhoc.index', compact('monHocs'));
}
public function create()
{
    return view('monhoc.create');
}
public function store(Request $request)
{
    
    $request->validate([
        'ma_mon' => 'required|unique:mon_hocs,ma_mon',
        'ten_mon' => 'required',
        'so_tin_chi' => 'required|integer|min:1|max:15',
        'khoa_phu_trach' => 'nullable|string'
    ]);

    MonHoc::create($request->all());
    return redirect()->route('monhoc.index')->with('success', 'Đã thêm môn học thành công!');   
        }
        public function edit($id)
        {
            $monHoc = MonHoc::findOrFail($id);
            return view('monhoc.edit', compact('monHoc'));
        }
        public function update(Request $request, $id)
        {
            $request->validate([
                'ma_mon' => 'required|unique:mon_hocs,ma_mon,' . $id,
                'ten_mon' => 'required',
                'so_tin_chi' => 'required|integer|min:1|max:15',
                'khoa_phu_trach' => 'nullable|string'
            ]);

            $monHoc = MonHoc::findOrFail($id);
            $monHoc->update($request->all());

            return redirect()->route('monhoc.index')->with('success', 'Đã cập nhật môn học thành công!');
        }
        public function destroy($id)
        {
        try {
            $monHoc = MonHoc::findOrFail($id);
            $monHoc->delete();

            return redirect()->route('monhoc.index')->with('success', 'Đã xóa môn học thành công!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('monhoc.index')->with('error', 'Không thể xóa môn học này vì có liên kết với dữ liệu khác.');
        }
     }
}
    