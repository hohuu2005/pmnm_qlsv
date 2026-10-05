@extends('layouts.layoutmaster')

@push('styles')
<style>
    .form-box { max-width: 600px; background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #e9ecef; box-shadow: 0 1px 3px rgba(0,0,0,0.05);}
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 5px; color: #1e3a5f; font-size: 14px; }
    .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; outline: none; font-size: 14px; }
    .btn-submit { background: #0d6efd; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
    .error-box { background: #f8d7da; color: #842029; padding: 12px; border-radius: 5px; margin-bottom: 15px; }
    .grid-2-col { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
</style>
@endpush

@section('content')
    <h2 style="color: #1e3a5f; margin-top: 0;">Thêm Môn học mới</h2>

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
        <form action="{{ route('monhoc.store') }}" method="POST">
            @csrf
            
            <div class="grid-2-col">
                <div class="form-group">
                    <label>Mã môn (*)</label>
                    <input type="text" name="ma_mon" value="{{ old('ma_mon') }}" required placeholder="VD: PM201">
                </div>
                <div class="form-group">
                    <label>Tên môn (*)</label>
                    <input type="text" name="ten_mon" value="{{ old('ten_mon') }}" required placeholder="VD: Công nghệ phần mềm">
                </div>
            </div>

            <div class="grid-2-col">
                <div class="form-group">
                    <label>Số tín chỉ (*)</label>
                    <input type="number" name="so_tin_chi" value="{{ old('so_tin_chi', 3) }}" required min="1" max="15">
                </div>
                <div class="form-group">
                    <label>Loại môn</label>
                    <select name="loai_mon">
                        <option value="Bắt buộc" {{ old('loai_mon') == 'Bắt buộc' ? 'selected' : '' }}>Bắt buộc</option>
                        <option value="Tự chọn" {{ old('loai_mon') == 'Tự chọn' ? 'selected' : '' }}>Tự chọn</option>
                    </select>
                </div>
            </div>

            <div class="grid-2-col">
                <div class="form-group">
                    <label>Khoa phụ trách</label>
                    <input type="text" name="khoa_phu_trach" value="{{ old('khoa_phu_trach') }}" >
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="trang_thai">
                        <option value="Đang giảng dạy" {{ old('trang_thai') == 'Đang giảng dạy' ? 'selected' : '' }}>Đang giảng dạy</option>
                        <option value="Tạm dừng" {{ old('trang_thai') == 'Tạm dừng' ? 'selected' : '' }}>Tạm dừng</option>
                    </select>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn-submit">Lưu Môn học</button>
                <a href="{{ route('monhoc.index') }}" style="margin-left: 15px; text-decoration: none; color: #6c757d;">Hủy bỏ</a>
            </div>
        </form>
    </div>
@endsection