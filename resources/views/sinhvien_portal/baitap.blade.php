@extends('layouts.layoutmaster')
@push('styles')
<style>
    .page-container { background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #dee2e6; }
    .assignment-card { border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-bottom: 20px; transition: 0.2s; }
    .assignment-card:hover { box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .title { font-size: 18px; color: #1e3a5f; font-weight: bold; margin-bottom: 10px; margin-top:0;}
    .meta { font-size: 13px; color: #6c757d; margin-bottom: 15px; }
    .deadline { color: #dc3545; font-weight: bold; }
    .btn-download { background: #6f42c1; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px; display: inline-block;}
    .upload-box { background: #f8f9fa; padding: 15px; border-radius: 6px; margin-top: 15px; border: 1px dashed #ced4da;}
    .btn-submit { background: #0d6efd; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-weight: bold;}
    .badge-done { background: #d1e7dd; color: #0f5132; padding: 6px 12px; border-radius: 4px; font-weight: bold; display: inline-block; margin-top: 15px;}
</style>
@endpush
@section('content')
<div class="page-container">
    <h2 style="color: #1e3a5f; margin-top: 0; margin-bottom: 25px;">Danh sách Bài tập</h2>
    
    @if(session('success'))
        <div style="color: #0f5132; background: #d1e7dd; padding: 10px; border-radius: 5px; margin-bottom: 20px;">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div style="color: #842029; background: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
            <ul style="margin: 0;">@foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
        </div>
    @endif

    @foreach($baiTaps as $bt)
    <div class="assignment-card">
        <h3 class="title">{{ $bt->tieu_de }}</h3>
        <div class="meta">
            Môn học: <strong>{{ $bt->monHoc->ten_mon ?? 'N/A' }}</strong> | 
            Hạn nộp: <span class="deadline">{{ \Carbon\Carbon::parse($bt->han_nop)->format('H:i - d/m/Y') }}</span>
        </div>
        
        <p>{{ $bt->noi_dung }}</p>
        
        @if($bt->file_de_bai)
            <a href="{{ asset($bt->file_de_bai) }}" target="_blank" class="btn-download">📥 Tải Đề bài</a>
        @endif

        {{-- Kiểm tra nếu sinh viên đã nộp bài này --}}
        @if(in_array($bt->id, $daNop))
            <div class="badge-done">✅ Đã nộp bài</div>
        @else
            {{-- Form nộp bài --}}
            <div class="upload-box">
                <form action="{{ route('sv.nopbai', $bt->id) }}" method="POST" enctype="multipart/form-data" style="display:flex; align-items:center; gap: 10px;">
                    @csrf
                    <input type="file" name="file_nop" required accept=".zip,.rar,.pdf,.doc,.docx" style="font-size: 13px;">
                    <button type="submit" class="btn-submit">🚀 Nộp bài</button>
                </form>
            </div>
        @endif
    </div>
    @endforeach
</div>
@endsection