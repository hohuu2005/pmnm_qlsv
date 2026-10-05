@extends('layouts.layoutmaster')
@push('styles')
<style>
    .page-container { background: #fff; padding: 30px; border-radius: 8px; border: 1px solid #dee2e6; max-width: 800px; }
    .guide-section { margin-bottom: 25px; }
    .guide-section h3 { color: #0d6efd; border-bottom: 1px solid #eee; padding-bottom: 10px; }
    .guide-section p { line-height: 1.6; color: #444; }
    .guide-step { background: #f8f9fa; padding: 15px; border-left: 4px solid #0d6efd; margin-bottom: 10px; border-radius: 4px; }
</style>
@endpush
@section('content')
<div class="page-container">
    <h2 style="color: #1e3a5f; margin-top: 0; margin-bottom: 20px;">📖 Hướng dẫn sử dụng hệ thống</h2>
    
    <div class="guide-section">
        <h3>1. Quản lý Lớp học và Sinh viên</h3>
        <p>Hệ thống quản lý theo mô hình Lớp hành chính. Để bắt đầu, bạn cần:</p>
        <div class="guide-step"><strong>Bước 1:</strong> Truy cập <b>Quản lý lớp học</b> để tạo danh mục các lớp (VD: 68PM2).</div>
        <div class="guide-step"><strong>Bước 2:</strong> Vào <b>Sinh viên</b> -> Thêm sinh viên và phân bổ vào lớp tương ứng.</div>
    </div>

    <div class="guide-section">
        <h3>2. Giao Bài tập và Tài liệu</h3>
        <p>Giảng viên có thể tải lên tài liệu học tập và bài tập cho sinh viên:</p>
        <div class="guide-step"><strong>Bài giảng:</strong> Upload file PDF, PPTX gắn với từng Môn học để sinh viên tải về.</div>
        <div class="guide-step"><strong>Bài tập:</strong> Chọn Môn, Chọn Lớp, đặt Hạn nộp (Deadline) và upload đề bài. Bài tập sắp đến hạn sẽ hiển thị ngoài màn hình Tổng quan.</div>
    </div>

    <div class="guide-section">
        <h3>3. Nhập điểm hàng loạt (Grid)</h3>
        <p>Tính năng hỗ trợ nhập điểm nhanh chóng như Excel:</p>
        <div class="guide-step">Truy cập <b>Điểm số</b> -> Chọn Môn học và Lớp -> Bảng danh sách sinh viên sẽ hiện ra. Bạn chỉ cần nhập điểm thành phần, hệ thống tự động tính Tổng kết và phân loại Đạt/Trượt.</div>
    </div>
</div>
@endsection