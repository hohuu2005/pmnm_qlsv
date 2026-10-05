@extends('layouts.layoutmaster')

@push('styles')
<style>
    .page-container { background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); font-family: sans-serif; }
    h2 { color: #1e3a5f; margin-top: 0; font-size: 24px; }
    .btn-primary { background: #0d6efd; color: #fff; border: none; padding: 8px 15px; border-radius: 4px; text-decoration: none; display: inline-block; font-size: 14px; margin-bottom: 20px; }
    .filter-box { border: 1px solid #e9ecef; border-radius: 5px; padding: 15px; margin-bottom: 15px; display: flex; gap: 10px; align-items: center; }
    .filter-box input { padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; outline: none; width: 300px; }
    .btn-filter { background: #0d6efd; color: #fff; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-size: 13px; }
    .btn-clear { background: #fff; color: #6c757d; border: 1px solid #ced4da; padding: 7px 20px; border-radius: 4px; text-decoration: none; cursor: pointer; font-size: 13px; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    th, td { padding: 12px 10px; border-bottom: 1px solid #dee2e6; text-align: left; white-space: nowrap; }
    th { background: #f8f9fa; color: #495057; font-weight: bold; border-top: 1px solid #dee2e6; }
    .badge-dat { color: #0f5132; background: #d1e7dd; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;}
    .badge-truot { color: #842029; background: #f8d7da; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;}
    .action-btn { padding: 4px 8px; border-radius: 4px; color: #fff; text-decoration: none; font-size: 12px; border: none; cursor: pointer; }
    .btn-edit { background: #0d6efd; }
    .btn-delete { background: #dc3545; margin-left: 5px; }
    
    @media (max-width: 768px) {
        .filter-box { flex-direction: column; align-items: stretch; }
        .filter-box input { width: 100%; }
        .table-responsive { overflow-x: auto; }
    }
</style>
@endpush

@section('content')
<div class="page-container">
    <h2>Quản lý Điểm số</h2>
    <a href="{{ route('diemso.create') }}" class="btn-primary">Nhập điểm mới</a>

    @if(session('success'))
        <div style="background: #d1e7dd; color: #0f5132; padding: 12px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #badbcc;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('diemso.index') }}" method="GET" class="filter-box">
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm tên sinh viên hoặc tên môn học...">
        <button type="submit" class="btn-filter">Lọc</button>
        <a href="{{ route('diemso.index') }}" class="btn-clear">Xóa lọc</a>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Sinh viên</th>
                    <th>Môn học</th>
                    <th>Chuyên cần (10%)</th>
                    <th>Giữa kỳ (30%)</th>
                    <th>Cuối kỳ (60%)</th>
                    <th>Tổng kết</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($diemsos as $ds)
                <tr>
                    <td style="font-weight: bold; color: #1e3a5f;">{{ $ds->sinhVien->ho_ten ?? 'N/A' }}</td>
                    <td>{{ $ds->monHoc->ten_mon ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $ds->diem_chuyen_can ?? '-' }}</td>
                    <td style="text-align: center;">{{ $ds->diem_giua_ky ?? '-' }}</td>
                    <td style="text-align: center;">{{ $ds->diem_cuoi_ky ?? '-' }}</td>
                    <td style="font-weight: bold; text-align: center;">{{ $ds->diem_tong_ket ?? '-' }}</td>
                    <td>
                        @if($ds->trang_thai == 'Đạt')
                            <span class="badge-dat">Đạt</span>
                        @elseif($ds->trang_thai == 'Học lại')
                            <span class="badge-truot">Học lại</span>
                        @else
                            <span style="color: #6c757d; font-size: 12px;">Chưa hoàn thành</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('diemso.edit', $ds->id) }}" class="action-btn btn-edit">Sửa</a>
                        <form action="{{ route('diemso.destroy', $ds->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa bản ghi này?');">
                            @csrf
                            <button type="submit" class="action-btn btn-delete">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #6c757d; padding: 20px;">Chưa có dữ liệu điểm số.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 20px;">
        {{ $diemsos->withQueryString()->links() }}
    </div>
</div>
@endsection