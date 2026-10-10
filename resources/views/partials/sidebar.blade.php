<style>
    /* CSS chuẩn theo mẫu HUCE.Web */
    .sidebar { 
        background-color: #1e3a5f; 
        color: #fff; 
        width: 260px; 
        min-height: 100vh; 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        flex-shrink: 0; /* QUAN TRỌNG: Ngăn sidebar bị ép nhỏ làm vỡ form */
    }
    .sidebar .logo { font-size: 22px; font-weight: bold; padding: 20px; background-color: #162b48; color: #f8c146; }
    .sidebar .logo span { color: #fff; }
    .nav-group-label { font-size: 11px; text-transform: uppercase; color: #8ba1b8; margin: 25px 20px 10px; font-weight: bold; letter-spacing: 1px; }
    .nav-list { list-style: none; padding: 0; margin: 0; }
    .nav-list li a { display: block; padding: 12px 20px; color: #d1dfed; text-decoration: none; font-size: 14px; transition: 0.2s; border-left: 3px solid transparent; }
    .nav-list li a:hover, .nav-list li.active a { background-color: #2a4d7a; color: #fff; border-left-color: #f8c146; }

    /* XỬ LÝ CO GIÃN TRÊN MÀN HÌNH NHỎ (Dưới 768px) */
    @media (max-width: 768px) {
        .sidebar {
            width: 100%; /* Bung chiều ngang 100% để Form rớt xuống dưới */
            min-height: auto; 
            padding-bottom: 20px;
        }
        .nav-list {
            display: flex; /* Dàn menu thành các cột ngang */
            flex-wrap: wrap;
        }
        .nav-list li {
            width: 50%; /* 2 Menu trên cùng 1 hàng cho tiết kiệm diện tích */
        }
        .nav-group-label {
            margin: 15px 20px 5px;
        }
    }
</style>

{{-- Lấy dữ liệu Menu động từ Database --}}
@php
    $dynamicMenus = \App\Models\Menu::where('trangthai', 'Hoạt động')->orderBy('id', 'asc')->get();
@endphp

<div class="sidebar">
    <div class="logo">HUCE<span>.Web</span></div>
    
    {{-- CHUNG: Ai cũng xem được --}}
    <div class="nav-group-label">CHUNG</div>
    <ul class="nav-list">
        <li><a href="{{ route('dashboard') }}">Tổng quan</a></li>
    </ul>

    {{-- KHÔNG GIAN HỌC TẬP: Chỉ dành cho Sinh viên --}}
    @if(Auth::check() && Auth::user()->role == 'sinh_vien')
        <div class="nav-group-label">HỌC TẬP</div>
        <ul class="nav-list">
            <li><a href="{{ route('sv.diem') }}">Tra cứu điểm</a></li>
            <li><a href="{{ route('baigiang.index') }}">Tài liệu môn học</a></li>
            <li><a href="{{ route('sv.baitap') }}">Nộp bài tập</a></li>
        </ul>
    @endif

    {{-- QUẢN LÝ HỌC VỤ: Dành cho Admin và Giảng viên --}}
    @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'giang_vien']))
        <div class="nav-group-label">DANH MỤC HỌC VỤ</div>
        <ul class="nav-list">
            <li><a href="{{ url('/sinh-vien') }}">Sinh viên</a></li>
            <li><a href="{{ route('baigiang.index') }}">Bài giảng</a></li>
            <li><a href="{{ route('baitap.index') }}">Bài tập</a></li>
            <li><a href="{{ route('diemso.chon_mon_lop') }}">Điểm số</a></li>
            <li><a href="#">Tài liệu</a></li>
            {{-- Môn học chỉ Admin mới được quyền thêm/sửa/xóa --}}
            @if(Auth::user()->role == 'admin')
                <li><a href="{{ route('monhoc.index') }}">Môn học</a></li>
            @endif
        </ul>
    @endif

    {{-- QUẢN TRỊ HỆ THỐNG: Chỉ dành cho Admin --}}
    @if(Auth::check() && Auth::user()->role == 'admin')
        <div class="nav-group-label">QUẢN TRỊ</div>
        <ul class="nav-list">
            <li class="{{ request()->routeIs('lophoc.*') ? 'active' : '' }}">
                <a href="{{ route('lophoc.index') }}">Quản lý lớp học</a>
            </li>
            <li class="{{ request()->routeIs('menu.*') ? 'active' : '' }}">
                <a href="{{ route('menu.index') }}">Quản lý menu</a>
            </li>
        </ul>
    @endif

    {{-- HỖ TRỢ: Ai cũng xem được --}}
    <div class="nav-group-label">HỖ TRỢ</div>
    <ul class="nav-list">
        <li><a href="{{ route('hotro.huongdan') }}">Hướng dẫn</a></li>
        <li><a href="{{ route('hotro.faq') }}">Câu hỏi thường gặp</a></li>
    </ul>

    {{-- MENU ĐỘNG --}}
    @if($dynamicMenus->count() > 0)
        <div class="nav-group-label">MỞ RỘNG</div>
        <ul class="nav-list">
            @foreach($dynamicMenus as $menu)
                <li>
                    <a href="{{ url('/' . $menu->slug) }}">
                        {{ $menu->tenhienthi }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>