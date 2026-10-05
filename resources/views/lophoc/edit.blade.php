@extends('layouts.layoutmaster')

@push('styles')
<style>
    .form-box { max-width: 600px; background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #e9ecef; box-shadow: 0 1px 3px rgba(0,0,0,0.05);}
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 5px; color: #1e3a5f; font-size: 14px; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; outline: none; font-size: 14px; }
    .btn-submit { background: #198754; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
    .grid-2-col { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
</style>
@endpush

@section('content')
    <h2 style="color: #1e3a5f; margin-top: 0;">Chỉnh sửa Lớp học: {{ $lophoc->ma_lop }}</h2>

    <div class="form-box">
        <form action="{{ route('lophoc.update', $lophoc->id) }}" method="POST">
            @csrf
            
            <div class="grid-2-col">
                <div class="form-group">
                    <label>Mã lớp (*)</label>
                    <input type="text" name="ma_lop" value="{{ old('ma_lop', $lophoc->ma_lop) }}" required>
                </div>
                <div class="form-group">
                    <label>Tên lớp (*)</label>
                    <input type="text" name="ten_lop" value="{{ old('ten_lop', $lophoc->ten_lop) }}" required>
                </div>
            </div>

            <div class="grid-2-col">
                <div class="form-group">
                    <label>Giáo viên chủ nhiệm (*)</label>
                    <input type="text" name="giao_vien" value="{{ old('giao_vien', $lophoc->giao_vien) }}" required>
                </div>
                <div class="form-group">
                    <label>Số điện thoại GVCN</label>
                    <input type="text" name="sdt_gvcn" value="{{ old('sdt_gvcn', $lophoc->sdt_gvcn) }}">
                </div>
            </div>

            <div class="grid-2-col">
                <div class="form-group">
                    <label>Sĩ số dự kiến (*)</label>
                    <input type="number" name="si_so" value="{{ old('si_so', $lophoc->si_so) }}" required min="1">
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="trang_thai">
                        <option value="Hoạt động" {{ $lophoc->trang_thai == 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="Không hoạt động" {{ $lophoc->trang_thai == 'Không hoạt động' ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Ghi chú</label>
                <textarea name="ghi_chu" rows="3">{{ old('ghi_chu', $lophoc->ghi_chu) }}</textarea>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn-submit">Cập nhật Lớp học</button>
                <a href="{{ route('lophoc.index') }}" style="margin-left: 15px; text-decoration: none; color: #6c757d;">Hủy bỏ</a>
            </div>
        </form>
    </div>
@endsection