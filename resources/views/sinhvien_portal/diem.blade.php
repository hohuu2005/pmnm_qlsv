@extends('layouts.layoutmaster')
@push('styles')
<style>
    .page-container { background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #dee2e6; }
    .student-info { background: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #1e3a5f; }
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th, td { padding: 12px; border-bottom: 1px solid #dee2e6; text-align: left; }
    th { background: #f8f9fa; color: #1e3a5f; }
    .badge { padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; }
    .bg-success { background: #d1e7dd; color: #0f5132; }
    .bg-danger { background: #f8d7da; color: #842029; }
</style>
@endpush
@section('content')
<div class="page-container">
    <h2 style="color: #1e3a5f; margin-top: 0;">Tra cứu Kết quả Học tập</h2>
    
    <div class="student-info">
        Họ và tên: <strong>{{ $sinhVien->ho_ten }}</strong> | 
        Mã SV: <strong>{{ $sinhVien->ma_sv ?? $sinhVien->id }}</strong> | 
        Lớp: <strong>{{ $sinhVien->lopHoc->ten_lop ?? $sinhVien->lopHoc->ma_lop ?? 'N/A' }}</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th>Môn học</th>
                <th>Chuyên cần (10%)</th>
                <th>Giữa kỳ (30%)</th>
                <th>Cuối kỳ (60%)</th>
                <th>Tổng kết</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @forelse($diemSos as $diem)
            <tr>
                <td><strong>{{ $diem->monHoc->ten_mon ?? 'N/A' }}</strong></td>
                <td>{{ $diem->diem_chuyen_can ?? '-' }}</td>
                <td>{{ $diem->diem_giua_ky ?? '-' }}</td>
                <td>{{ $diem->diem_cuoi_ky ?? '-' }}</td>
                <td><strong>{{ $diem->diem_tong_ket ?? '-' }}</strong></td>
                <td>
                    @if($diem->trang_thai == 'Đạt')
                        <span class="badge bg-success">Đạt</span>
                    @elseif($diem->trang_thai == 'Học lại')
                        <span class="badge bg-danger">Học lại</span>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6">Chưa có dữ liệu điểm.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection