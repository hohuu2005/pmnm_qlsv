<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BaiGiang;
use App\Models\MonHoc;
use Illuminate\Support\Facades\File;

class BaiGiangController extends Controller
{
    public function index()
    {
        $baiGiangs = BaiGiang::with('monHoc')->orderBy('mon_hoc_id')->orderBy('thu_tu')->paginate(10);
        return view('baigiang.index', compact('baiGiangs'));
    }

    public function create()
    {
        $monHocs = MonHoc::all();
        return view('baigiang.create', compact('monHocs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mon_hoc_id' => 'required|exists:mon_hocs,id',
            'tieu_de' => 'required|string|max:255',
            'thu_tu' => 'required|integer|min:1',
            'file_dinh_kem' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:10240', // Max 10MB
        ]);

        $data = $request->all();

        // Xử lý upload file
        if ($request->hasFile('file_dinh_kem')) {
            $file = $request->file('file_dinh_kem');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/baigiang'), $filename);
            $data['file_dinh_kem'] = 'uploads/baigiang/' . $filename;
        }

        BaiGiang::create($data);
        return redirect()->route('baigiang.index')->with('success', 'Đã thêm bài giảng thành công!');
    }

    public function destroy($id)
    {
        $baiGiang = BaiGiang::findOrFail($id);
        
        // Xóa file vật lý trong thư mục public nếu có
        if ($baiGiang->file_dinh_kem && File::exists(public_path($baiGiang->file_dinh_kem))) {
            File::delete(public_path($baiGiang->file_dinh_kem));
        }
        
        $baiGiang->delete();
        return redirect()->route('baigiang.index')->with('success', 'Đã xóa bài giảng!');
    }
}