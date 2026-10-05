@extends('layouts.layoutmaster')
@push('styles')
<style>
    .form-box { max-width: 700px; background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #dee2e6; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 5px; color: #1e3a5f; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; outline: none; font-family: inherit; }
    .btn-submit { background: #0d6efd; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; margin-top: 10px; }
</style>
@endpush
@section('content')
    <h2 style="color: #1e3a5f; margin-top: 0;">Giao Bài tập mới</h2>
    
    @if ($errors->any())
        <div style="color: #842029; background: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            <ul style="margin: 0;">@foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
        </div>
    @endif

    <div class="form-box">
        <form action="{{ route('baitap.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label>Lớp học (*)</label>
                    <select name="lop_hoc_id" required>
                        <option value="">-- Chọn lớp --</option>
                        @foreach($lopHocs as $lop)
                            <option value="{{ $lop->id }}">{{ $lop->ten_lop ?? $lop->ma_lop }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Môn học (*)</label>
                    <select name="mon_hoc_id" required>
                        <option value="">-- Chọn môn học --</option>
                        @foreach($monHocs as $mh)
                            <option value="{{ $mh->id }}">{{ $mh->ten_mon }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Tiêu đề bài tập (*)</label>
                <input type="text" name="tieu_de" placeholder="VD: Bài tập thực hành chương 1" required>
            </div>

            <div class="form-group">
                <label>Nội dung / Yêu cầu</label>
                <textarea name="noi_dung" rows="4" placeholder="Nhập yêu cầu chi tiết của bài tập..."></textarea>
            </div>

            <div class="form-group">
                <label>Hạn nộp (Deadline) (*)</label>
                <input type="datetime-local" name="han_nop" required>
            </div>

            <div class="form-group">
                <label>File đính kèm (Đề bài, tài liệu tham khảo - ZIP, PDF, DOCX)</label>
                <input type="file" name="file_de_bai" accept=".pdf,.doc,.docx,.zip,.rar">
            </div>

            <button type="submit" class="btn-submit">Giao Bài Tập</button>
            <a href="{{ route('baitap.index') }}" style="margin-left: 15px; color: #6c757d; text-decoration: none;">Hủy</a>
        </form>
    </div>
@endsection