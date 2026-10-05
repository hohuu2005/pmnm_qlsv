@extends('layouts.layoutmaster')

@push('styles')
<style>
    .page-container { background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); font-family: sans-serif; }
    h2 { color: #1e3a5f; margin-top: 0; font-size: 24px; }
    .btn-primary { background: #0d6efd; color: #fff; border: none; padding: 8px 15px; border-radius: 4px; text-decoration: none; display: inline-block; font-size: 14px; margin-bottom: 20px; }
    
    /* Box Bộ lọc Grid 4 cột */
    .filter-box { border: 1px solid #e9ecef; border-radius: 5px; padding: 15px; margin-bottom: 15px; }
    .filter-grid { display: grid; grid-template-columns: 2fr 1.5fr 2fr 1fr; gap: 20px; margin-bottom: 15px; }
    .filter-group label { display: block; font-size: 12px; color: #6c757d; margin-bottom: 8px; }
    .filter-group input, .filter-group select { width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; outline: none; }
    .filter-group input:focus, .filter-group select:focus { border-color: #86b7fe; }
    .siso-range { display: flex; align-items: center; gap: 10px; }
    
    /* Nút lọc */
    .btn-filter { background: #0d6efd; color: #fff; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-size: 13px; }
    .btn-clear { background: #fff; color: #6c757d; border: 1px solid #ced4da; padding: 7px 20px; border-radius: 4px; text-decoration: none; cursor: pointer; font-size: 13px; margin-left: 10px; }
    
    /* Bảng dữ liệu */
    .result-count { font-size: 13px; color: #6c757d; margin-bottom: 15px; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    th, td { padding: 12px 10px; border-bottom: 1px solid #dee2e6; text-align: left; }
    th { background: #f8f9fa; color: #495057; font-weight: bold; }
    .badge-active { color: #198754; }
    .badge-inactive { color: #6c757d; }
    .action-btn { padding: 4px 8px; border-radius: 4px; color: #fff; text-decoration: none; font-size: 12px; border: none; cursor: pointer; }
    .btn-edit { background: #0d6efd; }
    .btn-delete { background: #dc3545; margin-left: 5px; }
    /* CSS cho thanh phân trang */
    .pagination { display: flex; padding-left: 0; list-style: none; gap: 5px; margin-top: 10px; justify-content: flex-start; }
    .page-item .page-link { display: block; padding: 6px 12px; color: #0d6efd; text-decoration: none; background-color: #fff; border: 1px solid #dee2e6; border-radius: 4px; font-size: 13px; transition: 0.2s; }
    .page-item.active .page-link { color: #fff; background-color: #0d6efd; border-color: #0d6efd; }
    .page-item.disabled .page-link { color: #6c757d; pointer-events: none; background-color: #f8f9fa; border-color: #dee2e6; }
    .page-item .page-link:hover:not(.disabled) { background-color: #e9ecef; color: #0a58ca; }
    
    /* Ẩn dòng chữ "Showing 1 to 10..." mặc định nếu muốn gọn gàng */
    .d-flex.justify-content-between.flex-fill.d-sm-none { display: none; }
    .text-muted { font-size: 13px; color: #6c757d; margin-top: 10px; display: inline-block; }
</style>
@endpush

@section('content')
<div class="page-container">
    <h2>Danh sách lớp học</h2>
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
    <a href="{{ route('lophoc.create') }}" class="btn-primary">Thêm lớp học</a>

    {{-- Khối Tìm kiếm & Lọc --}}
    <form action="{{ route('lophoc.index') }}" method="GET" class="filter-box">
        <div class="filter-grid">
            <div class="filter-group">
                <label>Từ khóa</label>
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tên lớp, mã lớp, giáo viên...">
            </div>
            <div class="filter-group">
                <label>Trạng thái</label>
                <select name="status">
                    <option value="Tất cả">Tất cả</option>
                    <option value="Hoạt động" {{ request('status') == 'Hoạt động' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="Không hoạt động" {{ request('status') == 'Không hoạt động' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Sĩ số từ</label>
                <div class="siso-range">
                    <input type="number" name="size_min" value="{{ request('size_min') }}">
                    <span style="font-size: 12px; color: #6c757d;">đến</span>
                    <input type="number" name="size_max" value="{{ request('size_max') }}">
                </div>
            </div>
            <div class="filter-group">
                <label>Số dòng / trang</label>
                {{-- Tự động submit khi đổi số dòng --}}
                <select name="per_page" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>
        </div>
        <div>
            <button type="submit" class="btn-filter">Lọc</button>
            <a href="{{ route('lophoc.index') }}" class="btn-clear">Xóa lọc</a>
        </div>
    </form>

    {{-- Bộ đếm tổng số bản ghi --}}
    <div class="result-count">Tìm thấy {{ $lopHocs->total() ?? 0 }} lớp học.</div>

    {{-- Bảng hiển thị --}}
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>ID ▲</th>
                    <th>Tên lớp</th>
                    <th>Mã lớp</th>
                    <th>Giáo viên</th>
                    <th>Số điện thoại GVCN</th>
                    <th>Ghi chú</th>
                    <th>Sĩ số</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lopHocs as $lop)
                <tr>
                    <td>{{ $lop->id }}</td>
                    <td><a href="#" style="text-decoration: none; color: #0d6efd;">{{ $lop->ten_lop }}</a></td>
                    <td>{{ $lop->ma_lop }}</td>
                    <td>{{ $lop->giao_vien }}</td>
                    {{-- Dùng toán tử ?? để hiển thị rỗng nếu DB chưa có 2 cột này --}}
                    <td>{{ $lop->sdt_gvcn ?? '---' }}</td>
                    <td>{{ $lop->ghi_chu ?? '' }}</td>
                    <td>{{ $lop->si_so }}</td>
                    <td>
                        @if(($lop->trang_thai ?? 'Hoạt động') == 'Hoạt động')
                            <span class="badge-active">Hoạt động</span>
                        @else
                            <span class="badge-inactive">Không hoạt động</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('lophoc.edit', $lop->id) }}" class="action-btn btn-edit">Sửa</a>
                        
                        <form action="{{ route('lophoc.destroy', $lop->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa lớp học này?');">
                            @csrf
                            <button type="submit" class="action-btn btn-delete">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $lopHocs->withQueryString()->links() }}
    </div>
</div>
@endsection