@extends('layouts.layoutmaster')
@push('styles')
<style>
    .form-box { max-width: 600px; background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #dee2e6; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 5px; color: #1e3a5f; }
    .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; }
    .btn-submit { background: #0d6efd; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
</style>
@endpush
@section('content')
    <h2 style="color: #1e3a5f; margin-top: 0;">Thêm Bài giảng mới</h2>
    
    @if ($errors->any())
        <div style="color: #842029; background: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            <ul style="margin: 0;">@foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
        </div>
    @endif

    <div class="form-box">
        <!-- enctype multipart/form-data là BẮT BUỘC để upload file -->
        <form action="{{ route('baigiang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Môn học (*)</label>
                <select name="mon_hoc_id" required>
                    <option value="">-- Chọn môn học --</option>
                    @foreach($monHocs as $mh)
                        <option value="{{ $mh->id }}">{{ $mh->ten_mon }}</option>
                    @endforeach
                </select>
            </div>
            
            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label>Thứ tự bài (*)</label>
                    <input type="number" name="thu_tu" value="1" required min="1">
                </div>
                <div class="form-group" style="flex: 3;">
                    <label>Tiêu đề bài giảng (*)</label>
                    <input type="text" name="tieu_de" placeholder="VD: Khái niệm cơ sở dữ liệu" required>
                </div>
            </div>

            <div class="form-group">
                <label>Link Video (nếu có)</label>
                <input type="url" name="video_url" placeholder="VD: https://youtube.com/...">
            </div>

            <div class="form-group">
                <label>File đính kèm (PDF, PPTX, DOCX - Tối đa 10MB)</label>
                <input type="file" name="file_dinh_kem" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip">
            </div>

            <button type="submit" class="btn-submit">Lưu Bài Giảng</button>
            <a href="{{ route('baigiang.index') }}" style="margin-left: 15px; color: #6c757d; text-decoration: none;">Hủy</a>
        </form>
    </div>
@endsection