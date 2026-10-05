@extends('layouts.layoutmaster')
@push('styles')
<style>
    .page-container { background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6; }
    .btn-primary { background: #0d6efd; color: #fff; padding: 8px 15px; border-radius: 4px; text-decoration: none; display: inline-block; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th, td { padding: 12px; border-bottom: 1px solid #dee2e6; text-align: left; }
    th { background: #f8f9fa; color: #1e3a5f; }
    .btn-delete { background: #dc3545; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; }
</style>
@endpush
@section('content')
<div class="page-container">
    <h2 style="color: #1e3a5f; margin-top: 0;">Danh sách Bài giảng & Tài liệu</h2>
    
    {{-- Chỉ Admin hoặc Giảng viên mới thấy nút Thêm Bài giảng --}}
    @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'giang_vien']))
        <a href="{{ route('baigiang.create') }}" class="btn-primary">+ Thêm Bài giảng</a>
    @endif

    @if(session('success'))
        <div style="color: #0f5132; background: #d1e7dd; padding: 10px; border-radius: 5px; margin-bottom: 15px;">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Môn học</th>
                <th>Bài số</th>
                <th>Tiêu đề</th>
                <th>Tài liệu</th>
                
                {{-- Chỉ Admin hoặc Giảng viên mới thấy cột Thao tác --}}
                @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'giang_vien']))
                    <th>Thao tác</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($baiGiangs as $bg)
            <tr>
                <td><strong>{{ $bg->monHoc->ten_mon ?? 'N/A' }}</strong></td>
                <td>{{ $bg->thu_tu }}</td>
                <td>{{ $bg->tieu_de }}</td>
                <td>
                    @if($bg->file_dinh_kem)
                        <a href="{{ asset($bg->file_dinh_kem) }}" target="_blank" style="color: #0d6efd;">Tải File</a>
                    @else
                        -
                    @endif
                </td>
                
                {{-- Chỉ Admin hoặc Giảng viên mới thấy nút Xóa --}}
                @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'giang_vien']))
                    <td>
                        <form action="{{ route('baigiang.destroy', $bg->id) }}" method="POST" onsubmit="return confirm('Xóa bài giảng này?');">
                            @csrf
                            <button type="submit" class="btn-delete">Xóa</button>
                        </form>
                    </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection