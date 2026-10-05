@extends('layouts.layoutmaster')

@push('styles')
<style>
    .form-box { max-width: 500px; background: #fff; padding: 25px; border-radius: 8px; border: 1px solid var(--line); margin-top: 20px;}
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: var(--navy); }
    .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; outline: none; }
    .btn-submit { background: #198754; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
</style>
@endpush

@section('content')
    <h1>Chỉnh sửa Menu: {{ $menu->tenhienthi }}</h1>

    <div class="form-box">
        <form action="{{ route('menu.update', $menu->id) }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Tên hiển thị (*)</label>
                <input type="text" name="tenhienthi" value="{{ old('tenhienthi', $menu->tenhienthi) }}" required>
            </div>

            <div class="form-group">
                <label>Đường dẫn / Slug (*)</label>
                <input type="text" name="slug" value="{{ old('slug', $menu->slug) }}" required>
            </div>

            <div class="form-group">
                <label>Trạng thái</label>
                <select name="trangthai">
                    <option value="Hoạt động" {{ $menu->trangthai == 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="Không hoạt động" {{ $menu->trangthai == 'Không hoạt động' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn-submit">Cập nhật Menu</button>
                <a href="{{ route('menu.index') }}" style="margin-left: 15px; text-decoration: none; color: #6c757d;">Hủy bỏ</a>
            </div>
        </form>
    </div>
@endsection