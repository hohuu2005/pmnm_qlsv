@extends('layouts.layoutmaster')

@push('styles')
<style>
    .form-box { max-width: 500px; background: #fff; padding: 25px; border-radius: 8px; border: 1px solid var(--line); margin-top: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);}
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: var(--navy); }
    .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; outline: none; }
    .form-group input:focus, .form-group select:focus { border-color: #0d6efd; }
    .btn-submit { background: #0d6efd; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
    .btn-submit:hover { background: #0b5ed7; }
    .error-box { background: #f8d7da; color: #842029; padding: 12px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #f5c2c7; }
</style>
@endpush

@section('content')
    <h1 style="color: var(--navy);">Thêm Menu Mới</h1>
    <p>Khởi tạo đường dẫn điều hướng cho hệ thống.</p>

    {{-- Hiển thị lỗi nếu Validate thất bại (VD: trùng Slug) --}}
    @if ($errors->any())
        <div class="error-box">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-box">
        <form action="{{ route('menu.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Tên hiển thị (*)</label>
                <input type="text" name="tenhienthi" value="{{ old('tenhienthi') }}" required placeholder="VD: Giới thiệu">
            </div>

            <div class="form-group">
                <label>Đường dẫn / Slug (*)</label>
                <input type="text" name="slug" value="{{ old('slug') }}" required placeholder="VD: gioi-thieu">
                <small style="color: #6c757d; margin-top: 5px; display: block;">Slug viết thường, không dấu, cách nhau bằng dấu gạch ngang.</small>
            </div>

            <div class="form-group">
                <label>Trạng thái</label>
                <select name="trangthai">
                    <option value="Hoạt động">Hoạt động</option>
                    <option value="Không hoạt động">Không hoạt động</option>
                </select>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn-submit">Lưu Menu</button>
                <a href="{{ route('menu.index') }}" style="margin-left: 15px; text-decoration: none; color: #6c757d;">Hủy bỏ</a>
            </div>
        </form>
    </div>
@endsection