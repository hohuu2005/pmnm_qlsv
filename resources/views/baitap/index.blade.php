@extends('layouts.layoutmaster')
@push('styles')
<style>
    .page-container { background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6; }
    .btn-primary { background: #0d6efd; color: #fff; padding: 8px 15px; border-radius: 4px; text-decoration: none; display: inline-block; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th, td { padding: 12px; border-bottom: 1px solid #dee2e6; text-align: left; }
    th { background: #f8f9fa; color: #1e3a5f; }
    .btn-delete { background: #dc3545; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; }
    .deadline { color: #dc3545; font-weight: bold; }
</style>
@endpush
@section('content')
<div class="page-container">
    <h2 style="color: #1e3a5f; margin-top: 0;">Quản lý Bài tập</h2>
    <a href="{{ route('baitap.create') }}" class="btn-primary">+ Giao bài tập mới</a>

    @if(session('success'))
        <div style="color: #0f5132; background: #d1e7dd; padding: 10px; border-radius: 5px; margin-bottom: 15px;">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Lớp</th>
                <th>Môn học</th>
                <th>Tiêu đề bài tập</th>
                <th>Hạn nộp</th>
                <th>Đề bài</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($baiTaps as $bt)
            <tr>
                <td><strong>{{ $bt->lopHoc->ten_lop ?? $bt->lopHoc->ma_lop ?? 'N/A' }}</strong></td>
                <td>{{ $bt->monHoc->ten_mon ?? 'N/A' }}</td>
                <td>{{ $bt->tieu_de }}</td>
                <td class="deadline">{{ \Carbon\Carbon::parse($bt->han_nop)->format('d/m/Y H:i') }}</td>
                <td>
                    @if($bt->file_de_bai)
                        <a href="{{ asset($bt->file_de_bai) }}" target="_blank" style="color: #0d6efd; font-weight: bold;">📥 Tải đề</a>
                    @else
                        -
                    @endif
                </td>
                <td>
                    <form action="{{ route('baitap.destroy', $bt->id) }}" method="POST" onsubmit="return confirm('Xóa bài tập này?');">
                        @csrf
                        <button type="submit" class="btn-delete">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection