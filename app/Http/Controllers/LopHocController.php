<?php

namespace App\Http\Controllers;

use App\Models\LopHoc;
use Illuminate\Http\Request;

class LopHocController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $lopHocs = LopHoc::paginate($perPage)->withQueryString();
         
        return view('lophoc.index', [
            'title' => 'Danh sách lớp học',
            'lopHocs' => $lopHocs


        ]);
    }
}