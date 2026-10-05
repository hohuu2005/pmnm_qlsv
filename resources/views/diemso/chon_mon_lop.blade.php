@extends('layouts.layoutmaster')
@push('styles')
<style>
    .page-container { background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #dee2e6; max-width: 600px;}
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: bold; margin-bottom: 8px; color: #1e3a5f; }
    .form-group select { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; }
    .btn-submit { background: #0d6efd; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; }
</style>
@endpush
@section('content')
<div class="page-container">
    <h2 style="color: #1e3a5f; margin-top: 0;">Truy cập Bảng điểm</h2>
    @if(session('error')) <div style="color: red; margin-bottom: 15px;">{{ session('error') }}</div> @endif
    
    <form action="{{ route('diemso.nhap_diem_grid') }}" method="GET">
        <div class="form-group">
            <label>1. Chọn Môn học</label>
            <select name="mon_hoc_id" required>
                <option value="">-- Môn học --</option>
                @foreach($monHocs as $mh)
                    <option value="{{ $mh->id }}">{{ $mh->ten_mon }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>2. Chọn Lớp học</label>
            <select name="lop_hoc_id" required>
                <option value="">-- Lớp hành chính --</option>
                @foreach($lopHocs as $lop)
                    <option value="{{ $lop->id }}">{{ $lop->ten_lop ?? $lop->ma_lop }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-submit">Mở Bảng Điểm ➔</button>
    </form>
</div>
@endsection