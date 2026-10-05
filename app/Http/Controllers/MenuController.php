<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('id', 'desc')->paginate(10);

        return view('menu.index', compact('menus'));

}

    public function create()
    {
        return view('menu.add');
    }
    public function store(Request $request)
    {
        $request->validate([
            'tenhienthi' => 'required|max:255',
            'slug' => 'required|unique:menus,slug',
            'trangthai' => 'required'
        ], [
            'slug.unique' => 'Slug đã tồn tại. Vui lòng chọn một slug khác.',
        ]);
        Menu::create([
            'tenhienthi' => $request->tenhienthi,
            'slug' => $request->slug,
            'trangthai' => $request->trangthai,
        ]);
        return redirect()->route('menu.index')->with('success', 'Menu đã được thêm thành công.');
    }
    // 4. Mở form chỉnh sửa Menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id); // Tìm menu theo ID, nếu không có sẽ báo lỗi 404
        return view('menu.edit', compact('menu'));
    }

    // 5. Cập nhật dữ liệu vào Database
    public function update(Request $request, $id)
    {
        $request->validate([
            'tenhienthi' => 'required|max:255',
            // Kiểm tra unique nhưng bỏ qua ID hiện tại đang sửa
            'slug'       => 'required|unique:menus,slug,' . $id, 
            'trangthai'  => 'required'
        ], [
            'slug.unique' => 'Đường dẫn (Slug) này đã tồn tại!'
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update([
            'tenhienthi' => $request->tenhienthi,
            'slug'       => $request->slug,
            'trangthai'  => $request->trangthai
        ]);

        return redirect()->route('menu.index')->with('success', 'Cập nhật Menu thành công!');
    }

    // 6. Xóa Menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Đã xóa Menu!');
    }
    
}