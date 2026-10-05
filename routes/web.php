<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SinhVienController;
use App\Http\Controllers\LopHocController;
use App\Http\Controllers\DiemSoController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MonHocController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BaiGiangController;
use App\Http\Controllers\BaiTapController;
use App\Http\Controllers\HoTroController;
use App\Http\Controllers\SinhVienPortalController;

// ==========================================
// ROUTE CÔNG KHAI (Không cần đăng nhập)
// ==========================================
Route::get('/gioi-thieu', function () {
    return '<h1>Đây là trang Giới thiệu</h1><p>Nội dung tùy ý ở đây</p>';
});

Route::get('/layout1', function () {
    return view('layout.layout1', [
        'title'        => 'Trang chủ LaptopShop',
        'content'      => 'Đây là nội dung được truyền từ Route sang view.',
        'contentAlert' => '<script>alert("Xin chào! Chào mừng bạn đến với LaptopShop.");</script>'
    ]);
});

// Route xử lý Đăng nhập / Đăng xuất
Route::get('/dang-nhap', [AuthController::class, 'login'])->name('login');
Route::post('/dang-nhap', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout');

// Route cấp tài khoản test (Để tạm thời dùng)
Route::get('/tao-admin', function() {
    \App\Models\User::updateOrCreate(
        ['email' => 'admin@huce.edu.vn'],
        ['name' => 'Quản trị viên', 'password' => \Illuminate\Support\Facades\Hash::make('123456'), 'role' => 'admin']
    );
    return "Tạo tài khoản Admin thành công! Email: admin@huce.edu.vn | Pass: 123456";
});

Route::get('/tao-sinh-vien', function() {
    \App\Models\User::updateOrCreate(
        ['email' => 'sinhvien@huce.edu.vn'],
        ['name' => 'Nguyễn Văn Sinh Viên', 'password' => \Illuminate\Support\Facades\Hash::make('123456'), 'role' => 'sinh_vien']
    );
    return "Tạo tài khoản Sinh viên thành công! Email: sinhvien@huce.edu.vn | Pass: 123456";
});

Route::get('/cap-tai-khoan', function() {
    \App\Models\User::updateOrCreate(
        ['email' => 'hochihuu2005@gmail.com'],
        ['name' => 'Hồ Chí Hữu', 'password' => \Illuminate\Support\Facades\Hash::make('123456'), 'role' => 'sinh_vien']
    );
    return "Tạo tài khoản thành công! Email: hochihuu2005@gmail.com | Pass: 123456";
});


// ==========================================
// KHU VỰC BẮT BUỘC ĐĂNG NHẬP (Lớp khiên 1)
// ==========================================
Route::middleware('auth')->group(function () {
    
    // Trang chủ & Hỗ trợ (Ai cũng vào được)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::prefix('ho-tro')->name('hotro.')->group(function () {
        Route::get('/huong-dan', [HoTroController::class, 'huongDan'])->name('huongdan');
        Route::get('/cau-hoi-thuong-gap', [HoTroController::class, 'faq'])->name('faq');
    });

    // ------------------------------------------
    // KHU VỰC CỦA ADMIN (Lớp khiên 2: Chỉ Admin)
    // ------------------------------------------
    Route::middleware('role:admin')->group(function () {
        
        // Quản lý Sinh viên
        Route::get('/sinh-vien', [SinhVienController::class, 'index'])->name('sinh-vien');
        Route::get('/sinh-vien/them', [SinhVienController::class, 'create']);
        Route::post('/sinh-vien/luu', [SinhVienController::class, 'store'])->name('sinhvien.store');
        Route::get('/sinh-vien/sua/{id}', [SinhVienController::class, 'edit']);
        Route::post('sinh-vien/cap-nhat/{id}', [SinhVienController::class, 'update']);
        Route::post('sinh-vien/xoa/{id}', [SinhVienController::class, 'destroy']);
        Route::get('/sinhvien-detail/{id?}', [SinhVienController::class, 'getID'])->where('id', '[0-9]+');
        Route::get('/sinhvien/show/{tuoi?}/{hoten?}', [SinhVienController::class, 'show'])->where('tuoi', '[0-9]+')->where('hoten', '[A-Za-z]+');

        // Quản lý Lớp học
        Route::get('/lophoc', [LopHocController::class, 'index'])->name('lophoc.index');
        Route::get('/lophoc/them', [LopHocController::class, 'create'])->name('lophoc.create');
        Route::post('/lophoc/luu', [LopHocController::class, 'store'])->name('lophoc.store');
        Route::get('/lophoc/sua/{id}', [LopHocController::class, 'edit'])->name('lophoc.edit');
        Route::post('/lophoc/cap-nhat/{id}', [LopHocController::class, 'update'])->name('lophoc.update');
        Route::post('/lophoc/xoa/{id}', [LopHocController::class, 'destroy'])->name('lophoc.destroy');

        // Quản lý Menu
        Route::get('menus', [MenuController::class, 'index'])->name('menu.index');
        Route::get('menus/them', [MenuController::class, 'create'])->name('menu.create');
        Route::post('menus/luu', [MenuController::class, 'store'])->name('menu.store');
        Route::get('/menu/sua/{id}', [MenuController::class, 'edit'])->name('menu.edit');
        Route::post('/menu/cap-nhat/{id}', [MenuController::class, 'update'])->name('menu.update');
        Route::post('/menu/xoa/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

        // Quản lý Môn học
        Route::prefix('mon-hoc')->name('monhoc.')->group(function () {
            Route::get('/', [MonHocController::class, 'index'])->name('index');
            Route::get('/them', [MonHocController::class, 'create'])->name('create');
            Route::post('/luu', [MonHocController::class, 'store'])->name('store');
            Route::get('/sua/{id}', [MonHocController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat/{id}', [MonHocController::class, 'update'])->name('update');
            Route::post('/xoa/{id}', [MonHocController::class, 'destroy'])->name('destroy');
        });
    });

    // ------------------------------------------
    // KHU VỰC HỌC VỤ (Lớp khiên 2: Admin + Giảng viên)
    // ------------------------------------------
    Route::middleware('role:admin,giang_vien')->group(function () {
        
        // Quản lý Điểm số
        Route::prefix('diem-so')->name('diemso.')->group(function () {
            Route::get('/', [DiemSoController::class, 'chonMonLop'])->name('chon_mon_lop');
            Route::get('/nhap-diem', [DiemSoController::class, 'nhapDiemGrid'])->name('nhap_diem_grid');
            Route::post('/luu-diem/{mon_hoc_id}', [DiemSoController::class, 'luuDiemGrid'])->name('luu_diem_grid');
        });
        
        // Quản lý Bài tập
        Route::prefix('bai-tap')->name('baitap.')->group(function () {
            Route::get('/', [BaiTapController::class, 'index'])->name('index');
            Route::get('/them', [BaiTapController::class, 'create'])->name('create');
            Route::post('/luu', [BaiTapController::class, 'store'])->name('store');
            Route::post('/xoa/{id}', [BaiTapController::class, 'destroy'])->name('destroy');
        });

        // Quản lý Bài giảng
        Route::prefix('bai-giang')->name('baigiang.')->group(function () {
            Route::get('/', [BaiGiangController::class, 'index'])->name('index');
            Route::get('/them', [BaiGiangController::class, 'create'])->name('create');
            Route::post('/luu', [BaiGiangController::class, 'store'])->name('store');
            Route::post('/xoa/{id}', [BaiGiangController::class, 'destroy'])->name('destroy');
        });
    });

    // ------------------------------------------
    // KHU VỰC SINH VIÊN (Lớp khiên 2: Chỉ Sinh viên)
    // ------------------------------------------
    Route::middleware('role:sinh_vien')->group(function () {
        Route::prefix('sinh-vien-portal')->name('sv.')->group(function () {
            Route::get('/tra-cuu-diem', [SinhVienPortalController::class, 'traCuuDiem'])->name('diem');
            Route::get('/bai-tap', [SinhVienPortalController::class, 'baiTap'])->name('baitap');
            Route::post('/nop-bai/{bai_tap_id}', [SinhVienPortalController::class, 'nopBai'])->name('nopbai');
        });
    });

});