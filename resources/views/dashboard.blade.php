@extends('layouts.layoutmaster')
@push('styles')
<style>
    .dashboard-container { padding: 10px; }
    .stat-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px; }
    .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #0d6efd; display: flex; flex-direction: column; }
    .card.green { border-color: #198754; }
    .card.warning { border-color: #ffc107; }
    .card.purple { border-color: #6f42c1; }
    .card-title { font-size: 14px; color: #6c757d; font-weight: bold; text-transform: uppercase; margin-bottom: 10px; }
    .card-value { font-size: 28px; font-weight: bold; color: #1e3a5f; margin: 0; }
    
    .section-title { color: #1e3a5f; font-size: 18px; margin-bottom: 15px; border-bottom: 2px solid #dee2e6; padding-bottom: 10px; }
    .deadline-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05); font-size: 14px;}
    .deadline-table th, .deadline-table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #dee2e6; }
    .deadline-table th { background: #f8f9fa; color: #1e3a5f; }
    .text-danger { color: #dc3545; font-weight: bold; }
    .empty-state { text-align: center; padding: 30px; color: #6c757d; font-style: italic; }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <h2 style="color: #1e3a5f; margin-top: 0; margin-bottom: 25px;">Hệ thống Quản lý Học vụ</h2>
    
    <!-- Thống kê tổng quan -->
    <div class="stat-cards">
        <div class="card">
            <span class="card-title">Tổng Sinh viên</span>
            <h3 class="card-value">{{ $tongSinhVien }}</h3>
        </div>
        <div class="card green">
            <span class="card-title">Lớp Hành chính</span>
            <h3 class="card-value">{{ $tongLop }}</h3>
        </div>
        <div class="card purple">
            <span class="card-title">Môn học đang mở</span>
            <h3 class="card-value">{{ $tongMon }}</h3>
        </div>
        <div class="card warning">
            <span class="card-title">Bài tập đã giao</span>
            <h3 class="card-value">{{ $tongBaiTap }}</h3>
        </div>
    </div>

    <!-- Cảnh báo học vụ: Deadline -->
    <h3 class="section-title">⏱️ Bài tập sắp đến hạn nộp (Top 5)</h3>
    @if($baiTapSapHan->count() > 0)
        <table class="deadline-table">
            <thead>
                <tr>
                    <th>Lớp</th>
                    <th>Môn học</th>
                    <th>Tiêu đề bài tập</th>
                    <th>Hạn nộp</th>
                </tr>
            </thead>
            <tbody>
                @foreach($baiTapSapHan as $bt)
                <tr>
                    <td><strong>{{ $bt->lopHoc->ten_lop ?? $bt->lopHoc->ma_lop ?? 'N/A' }}</strong></td>
                    <td>{{ $bt->monHoc->ten_mon ?? 'N/A' }}</td>
                    <td>
                        @if(Auth::check() && Auth::user()->role == 'sinh_vien')
                            <a href="{{ route('sv.baitap') }}" style="color: #0d6efd; text-decoration: none; font-weight: bold;">{{ $bt->tieu_de }}</a>
                        @else
                            <a href="{{ route('baitap.index') }}" style="color: #0d6efd; text-decoration: none; font-weight: bold;">{{ $bt->tieu_de }}</a>
                        @endif
                    </td>
                    <td class="text-danger">{{ \Carbon\Carbon::parse($bt->han_nop)->format('H:i - d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            🎉 Tuyệt vời! Hiện tại không có bài tập nào sắp đến hạn nộp.
        </div>
    @endif
</div>
@endsection