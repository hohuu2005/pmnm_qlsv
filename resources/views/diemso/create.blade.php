@extends('layouts.layoutmaster')

@push('styles')
<style>
    .form-box { max-width: 600px; background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #e9ecef; box-shadow: 0 1px 3px rgba(0,0,0,0.05);}
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 5px; color: #1e3a5f; font-size: 14px; }
    .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; outline: none; font-size: 14px; }
    .btn-submit { background: #0d6efd; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
    .error-box { background: #f8d7da; color: #842029; padding: 12px; border-radius: 5px; margin-bottom: 15px; }
    .grid-3-col { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; }
</style>
@endpush

@section('content')
    <h2 style="color: #1e3a5f; margin-top: 0;">Nhập Điểm số</h2>

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
        <form action="{{ route('diemso.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Sinh viên (*)</label>
                <select name="sinh_vien_id" required>
                    <option value="">-- Chọn sinh viên --</option>
                    @foreach($sinhViens as $sv)
                        <option value="{{ $sv->id }}" {{ old('sinh_vien_id') == $sv->id ? 'selected' : '' }}>
                            {{ $sv->ho_ten }} - {{ $sv->email }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Môn học (*)</label>
                <select name="mon_hoc_id" required>
                    <option value="">-- Chọn môn học --</option>
                    @foreach($monHocs as $mh)
                        <option value="{{ $mh->id }}" {{ old('mon_hoc_id') == $mh->id ? 'selected' : '' }}>
                            {{ $mh->ma_mon }} - {{ $mh->ten_mon }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid-3-col">
                <div class="form-group">
                    <label>Điểm Chuyên cần</label>
                    <input type="number" step="0.1" min="0" max="10" name="diem_chuyen_can" value="{{ old('diem_chuyen_can') }}" placeholder="VD: 8.5">
                </div>
                <div class="form-group">
                    <label>Điểm Giữa kỳ</label>
                    <input type="number" step="0.1" min="0" max="10" name="diem_giua_ky" value="{{ old('diem_giua_ky') }}" placeholder="VD: 7.0">
                </div>
                <div class="form-group">
                    <label>Điểm Cuối kỳ</label>
                    <input type="number" step="0.1" min="0" max="10" name="diem_cuoi_ky" value="{{ old('diem_cuoi_ky') }}" placeholder="VD: 6.5">
                </div>
            </div>
            
            <p style="font-size: 12px; color: #6c757d; margin-bottom: 20px;">* Hệ thống sẽ tự động tính điểm tổng kết và xếp loại khi bạn nhập đủ 3 đầu điểm.</p>

            <div>
                <button type="submit" class="btn-submit">Lưu Điểm số</button>
                <a href="{{ route('diemso.index') }}" style="margin-left: 15px; text-decoration: none; color: #6c757d;">Hủy bỏ</a>
            </div>
        </form>
    </div>
@endsection