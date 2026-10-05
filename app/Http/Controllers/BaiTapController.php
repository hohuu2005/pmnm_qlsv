<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BaiTap;
use App\Models\MonHoc;
use App\Models\LopHoc;
use Illuminate\Support\Facades\File;

class BaiTapController extends Controller
{
    public function index()
    {
        $baiTaps = BaiTap::with(['monHoc', 'lopHoc'])->orderBy('id', 'desc')->paginate(10);
        return view('baitap.index', compact('baiTaps'));
    }

    public function create()
    {
        $monHocs = MonHoc::all();
        $lopHocs = LopHoc::all(); // Đổi thành Lop::all() nếu cần
        return view('baitap.create', compact('monHocs', 'lopHocs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mon_hoc_id' => 'required',
            'lop_hoc_id' => 'required',
            'tieu_de' => 'required|string|max:255',
            'han_nop' => 'required|date',
            'file_de_bai' => 'nullable|file|mimes:pdf,doc,docx,zip,rar|max:15360', 
        ]);

        $data = $request->all();

        if ($request->hasFile('file_de_bai')) {
            $file = $request->file('file_de_bai');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/baitap'), $filename);
            $data['file_de_bai'] = 'uploads/baitap/' . $filename;
        }

        BaiTap::create($data);
        return redirect()->route('baitap.index')->with('success', 'Đã giao bài tập mới thành công!');
    }

    public function destroy($id)
    {
        $baiTap = BaiTap::findOrFail($id);
        
        if ($baiTap->file_de_bai && File::exists(public_path($baiTap->file_de_bai))) {
            File::delete(public_path($baiTap->file_de_bai));
        }
        
        $baiTap->delete();
        return redirect()->route('baitap.index')->with('success', 'Đã xóa bài tập!');
    }
}