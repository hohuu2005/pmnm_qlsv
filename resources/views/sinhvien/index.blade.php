@extends('layouts.layoutmaster')

@push('styles')
<style>
    .page-container { background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); font-family: sans-serif; }
    h2 { color: #1e3a5f; margin-top: 0; font-size: 24px; }
    .btn-primary { background: #0d6efd; color: #fff; border: none; padding: 8px 15px; border-radius: 4px; text-decoration: none; display: inline-block; font-size: 14px; margin-bottom: 20px; }
    
    .filter-box { border: 1px solid #e9ecef; border-radius: 5px; padding: 15px; margin-bottom: 15px; }
    .filter-grid { display: grid; grid-template-columns: 2fr 1.5fr 1fr; gap: 20px; margin-bottom: 15px; }
    .filter-group label { display: block; font-size: 12px; color: #6c757d; margin-bottom: 8px; }
    .filter-group input, .filter-group select { width: 100%; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 13px; outline: none; }
    .filter-group input:focus, .filter-group select:focus { border-color: #86b7fe; }
    
    .btn-filter { background: #0d6efd; color: #fff; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-size: 13px; }
    .btn-clear { background: #fff; color: #6c757d; border: 1px solid #ced4da; padding: 7px 20px; border-radius: 4px; text-decoration: none; cursor: pointer; font-size: 13px; margin-left: 10px; }
    
    .result-count { font-size: 13px; color: #6c757d; margin-bottom: 15px; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    th, td { padding: 12px 10px; border-bottom: 1px solid #dee2e6; text-align: left; }
    th { background: #f8f9fa; color: #495057; font-weight: bold; border-top: 1px solid #dee2e6; }
    .action-btn { padding: 4px 8px; border-radius: 4px; color: #fff; text-decoration: none; font-size: 12px; border: none; cursor: pointer; }
    .btn-edit { background: #0d6efd; }
    .btn-delete { background: #dc3545; margin-left: 5px; }
</style>
@endpush

@section('content')
<div class="page-container">
    <h2>Danh sách sinh viên</h2>
    <a href="{{ url('/sinh-vien/them') }}" class="btn-primary">Thêm sinh viên</a>

    @if(session('success'))
        <div style="background: #d1e7dd; color: #0f5132; padding: 12px; border-radius: 5px; margin-bottom: 15px; border: 1px solid #badbcc;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ url('/sinh-vien') }}" method="GET" class="filter-box">
        <div class="filter-grid">
            <div class="filter-group">
                <label>Từ khóa</label>
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tên sinh viên, email, mã số...">
            </div>
            
            <div class="filter-group">
                <label>Ngày sinh (Từ - Đến)</label>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="date" name="ngay_sinh_tu" value="{{ request('ngay_sinh_tu') }}">
                    <span style="font-size: 12px; color: #6c757d;">-</span>
                    <input type="date" name="ngay_sinh_den" value="{{ request('ngay_sinh_den') }}">
                </div>
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
            <a href="{{ url('/sinh-vien') }}" class="btn-clear">Xóa lọc</a>
        </div>
    </form>

    <div class="result-count">Tìm thấy {{ $sinhViens->total() ?? 0 }} sinh viên.</div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>ID ▲</th>
                    <th>Mã SV</th>
                    <th>Họ tên</th>
                    <th>Ngày Sinh</th>
                    <th>Email</th>
                    <th>Lớp học</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sinhViens as $sv)
                <tr>
                    <td>{{ $sv->id }}</td>
                    <td>{{ $sv->ma_sv ?? '---' }}</td>
                    <td style="font-weight: 600; color: #1e3a5f;">{{ $sv->ho_ten ?? $sv->hoten ?? '---' }}</td>
                    
                    {{-- Sử dụng Carbon để format ngày sinh chuẩn Việt Nam DD/MM/YYYY --}}
                    <td>{{ $sv->ngay_sinh ? \Carbon\Carbon::parse($sv->ngay_sinh)->format('d/m/Y') : '---' }}</td>
                    
                    <td>{{ $sv->email }}</td>
                    
                    <td>
                        @if($sv->lopHoc)
                            <span style="color: #0d6efd;">{{ $sv->lopHoc->ma_lop }}</span>
                        @else
                            <span style="color: #6c757d;">Chưa xếp lớp</span>
                        @endif
                    </td>
                    
                    <td>
                        <a href="{{ url('/sinh-vien/sua/' . $sv->id) }}" class="action-btn btn-edit">Sửa</a>
                        <form action="{{ url('/sinh-vien/xoa/' . $sv->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Xóa sinh viên này?');">
                            @csrf
                            <button type="submit" class="action-btn btn-delete">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #6c757d; padding: 20px;">Không có dữ liệu sinh viên.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $sinhViens->withQueryString()->links() }}
    </div>
</div>
@endsection