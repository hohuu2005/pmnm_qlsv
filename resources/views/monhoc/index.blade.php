@extends('layouts.layoutmaster')

@push('styles')
<style>
    .page-container { background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); font-family: sans-serif; }
    h2 { color: #1e3a5f; margin-top: 0; font-size: 24px; }
    .btn-primary { background: #0d6efd; color: #fff; border: none; padding: 8px 15px; border-radius: 4px; text-decoration: none; display: inline-block; font-size: 14px; margin-bottom: 20px; }
    
    .filter-box { border: 1px solid #e9ecef; border-radius: 5px; padding: 15px; margin-bottom: 15px; }
    .filter-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 20px; margin-bottom: 15px; }
    .filter-group label { display: block; font-size: 12px; color: #6c757d; margin-bottom: 8px; }
    .filter-group input, .filter-group select { width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; outline: none; }
    
    .btn-filter { background: #0d6efd; color: #fff; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-size: 13px; }
    .btn-clear { background: #fff; color: #6c757d; border: 1px solid #ced4da; padding: 7px 20px; border-radius: 4px; text-decoration: none; cursor: pointer; font-size: 13px; margin-left: 10px; }
    
    .result-count { font-size: 13px; color: #6c757d; margin-bottom: 15px; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    th, td { padding: 12px 10px; border-bottom: 1px solid #dee2e6; text-align: left; }
    th { background: #f8f9fa; color: #495057; font-weight: bold; border-top: 1px solid #dee2e6; }
    
    .badge-bb { color: #842029; background: #f8d7da; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;}
    .badge-tc { color: #0f5132; background: #d1e7dd; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;}
    
    .action-btn { padding: 4px 8px; border-radius: 4px; color: #fff; text-decoration: none; font-size: 12px; border: none; cursor: pointer; }
    .btn-edit { background: #0d6efd; }
    .btn-delete { background: #dc3545; margin-left: 5px; }
    th, td {
        white-space: nowrap;
    }
</style>
@endpush

@section('content')
<div class="page-container">
    <h2>Danh sách Môn học</h2>
    <a href="{{ route('monhoc.create') }}" class="btn-primary">Thêm môn học</a>

    @if(session('success'))
        <div style="background: #d1e7dd; color: #0f5132; padding: 12px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #badbcc;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #f8d7da; color: #842029; padding: 12px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #f5c2c7;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('monhoc.index') }}" method="GET" class="filter-box">
        <div class="filter-grid">
            <div class="filter-group">
                <label>Từ khóa</label>
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Mã môn, tên môn, khoa...">
            </div>
            <div class="filter-group">
                <label>Loại môn</label>
                <select name="loai_mon">
                    <option value="Tất cả">Tất cả</option>
                    <option value="Bắt buộc" {{ request('loai_mon') == 'Bắt buộc' ? 'selected' : '' }}>Bắt buộc</option>
                    <option value="Tự chọn" {{ request('loai_mon') == 'Tự chọn' ? 'selected' : '' }}>Tự chọn</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Số tín chỉ</label>
                <input type="number" name="tin_chi" value="{{ request('tin_chi') }}" placeholder="VD: 3">
            </div>
            <div class="filter-group">
                <label>Số dòng / trang</label>
                <select name="per_page" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>
        </div>
        <div>
            <button type="submit" class="btn-filter">Lọc</button>
            <a href="{{ route('monhoc.index') }}" class="btn-clear">Xóa lọc</a>
        </div>
    </form>

    <div class="result-count">Tìm thấy {{ $monHocs->total() }} môn học.</div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>ID ▲</th>
                    <th>Mã môn</th>
                    <th>Tên môn</th>
                    <th>Số tín chỉ</th>
                    <th>Loại môn</th>
                    <th>Khoa phụ trách</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($monHocs as $mh)
                <tr>
                    <td>{{ $mh->id }}</td>
                    <td style="font-weight: bold; color: #1e3a5f;">{{ $mh->ma_mon }}</td>
                    <td>{{ $mh->ten_mon }}</td>
                    <td style="text-align: center;">{{ $mh->so_tin_chi }}</td>
                    <td>
                        @if($mh->loai_mon == 'Bắt buộc')
                            <span class="badge-bb">Bắt buộc</span>
                        @else
                            <span class="badge-tc">Tự chọn</span>
                        @endif
                    </td>
                    <td>{{ $mh->khoa_phu_trach ?? '---' }}</td>
                    <td>
                        @if($mh->trang_thai == 'Đang giảng dạy')
                            <span style="color: #198754;">Đang giảng dạy</span>
                        @else
                            <span style="color: #6c757d;">Tạm dừng</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('monhoc.edit', $mh->id) }}" class="action-btn btn-edit">Sửa</a>
                        <form action="{{ route('monhoc.destroy', $mh->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa môn học này?');">
                            @csrf
                            <button type="submit" class="action-btn btn-delete">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #6c757d; padding: 20px;">Chưa có dữ liệu môn học.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $monHocs->withQueryString()->links() }}
    </div>
</div>
@endsection