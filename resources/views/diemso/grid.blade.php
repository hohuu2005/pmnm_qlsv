@extends('layouts.layoutmaster')
@push('styles')
<style>
    .page-container { background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6; }
    .table-grid { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 13px; }
    .table-grid th, .table-grid td { border: 1px solid #dee2e6; padding: 10px; text-align: center; }
    .table-grid th { background: #f8f9fa; color: #1e3a5f; }
    .table-grid input { width: 70px; padding: 6px; text-align: center; border: 1px solid #ced4da; border-radius: 4px; }
    .btn-save { background: #198754; color: #fff; padding: 10px 24px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; margin-top: 20px; }
    .badge-dat { background: #d1e7dd; color: #0f5132; padding: 4px 8px; border-radius: 4px; font-weight: bold; }
    .badge-truot { background: #f8d7da; color: #842029; padding: 4px 8px; border-radius: 4px; font-weight: bold; }
</style>
@endpush
@section('content')
<div class="page-container">
    <h2 style="color: #1e3a5f; margin-top: 0;">Bảng Điểm</h2>
    <p>Môn: <strong>{{ $monHoc->ten_mon }}</strong> | Lớp: <strong>{{ $lopHoc->ten_lop ?? $lopHoc->ma_lop }}</strong></p>

    @if(session('success')) 
        <div style="background: #d1e7dd; color: #0f5132; padding: 12px; border-radius: 5px; margin-bottom: 15px;">{{ session('success') }}</div> 
    @endif

    <form action="{{ route('diemso.luu_diem_grid', $monHoc->id) }}" method="POST">
        @csrf
        <div style="overflow-x: auto;">
            <table class="table-grid">
                <thead>
                    <tr>
                        <th style="text-align: left;">Sinh viên</th>
                        <th>Chuyên cần (10%)</th>
                        <th>Giữa kỳ (30%)</th>
                        <th>Cuối kỳ (60%)</th>
                        <th>Tổng kết</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sinhViens as $sv)
                    @php $diem = $diemSos->get($sv->id); @endphp
                    <tr>
                        <td style="text-align: left;">{{ $sv->id }} - <strong>{{ $sv->ho_ten }}</strong></td>
                        <td><input type="number" step="0.1" min="0" max="10" name="diem[{{ $sv->id }}][cc]" value="{{ $diem->diem_chuyen_can ?? '' }}"></td>
                        <td><input type="number" step="0.1" min="0" max="10" name="diem[{{ $sv->id }}][gk]" value="{{ $diem->diem_giua_ky ?? '' }}"></td>
                        <td><input type="number" step="0.1" min="0" max="10" name="diem[{{ $sv->id }}][ck]" value="{{ $diem->diem_cuoi_ky ?? '' }}"></td>
                        <td><strong>{{ $diem->diem_tong_ket ?? '-' }}</strong></td>
                        <td>
                            @if(isset($diem->trang_thai))
                                <span class="{{ $diem->trang_thai == 'Đạt' ? 'badge-dat' : 'badge-truot' }}">{{ $diem->trang_thai }}</span>
                            @else
                                <span style="color: #6c757d; font-size: 12px;">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6">Lớp học này chưa có sinh viên nào.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn-save">💾 Lưu Bảng Điểm</button>
        <a href="{{ route('diemso.chon_mon_lop') }}" style="margin-left: 15px; color: #6c757d; text-decoration: none;">Đổi Môn/Lớp</a>
    </form>
</div>
@endsection