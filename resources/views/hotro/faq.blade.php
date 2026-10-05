@extends('layouts.layoutmaster')
@push('styles')
<style>
    .page-container { background: #fff; padding: 30px; border-radius: 8px; border: 1px solid #dee2e6; max-width: 800px; }
    details { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; margin-bottom: 15px; padding: 10px 15px; transition: all 0.3s; }
    details[open] { background: #fff; border-color: #0d6efd; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    summary { font-weight: bold; color: #1e3a5f; cursor: pointer; outline: none; list-style: none; font-size: 15px; }
    summary::-webkit-details-marker { display: none; }
    summary::before { content: "➕"; margin-right: 10px; font-size: 12px; }
    details[open] summary::before { content: "➖"; }
    details p { margin-top: 15px; color: #555; line-height: 1.6; border-top: 1px dashed #ccc; padding-top: 15px; }
</style>
@endpush
@section('content')
<div class="page-container">
    <h2 style="color: #1e3a5f; margin-top: 0; margin-bottom: 25px;">❓ Câu hỏi thường gặp (FAQ)</h2>
    
    <details>
        <summary>Tôi nhập điểm sai, có thể sửa lại được không?</summary>
        <p>Hoàn toàn được. Bạn chỉ cần truy cập lại mục <strong>Điểm số</strong>, chọn đúng Môn học và Lớp đó, hệ thống sẽ tải lại điểm cũ. Bạn gõ điểm mới đè lên và bấm "Lưu bảng điểm" là dữ liệu sẽ được cập nhật lại.</p>
    </details>

    <details>
        <summary>Dung lượng tối đa khi tải lên tài liệu bài giảng là bao nhiêu?</summary>
        <p>Hệ thống hiện đang giới hạn dung lượng tải lên là <strong>10MB</strong> đối với Bài giảng (PDF, Word, PPT) và <strong>15MB</strong> đối với đề Bài tập. Vui lòng nén file (.zip) nếu dung lượng lớn hơn mức cho phép.</p>
    </details>

    <details>
        <summary>Hệ thống tính điểm tổng kết như thế nào?</summary>
        <p>Hệ thống tự động tính điểm dựa trên trọng số mặc định: Chuyên cần (10%) + Giữa kỳ (30%) + Cuối kỳ (60%). Nếu điểm tổng kết >= 4.0, trạng thái sẽ là "Đạt", ngược lại là "Học lại".</p>
    </details>

    <details>
        <summary>Làm sao để sinh viên biết được bài tập nào sắp hết hạn?</summary>
        <p>Ngay khi đăng nhập vào hệ thống, mục <strong>Cảnh báo học vụ</strong> trên màn hình Tổng quan sẽ luôn hiển thị Top 5 bài tập sắp đến thời hạn nộp nhất kèm theo ngày giờ chi tiết.</p>
    </details>
</div>
@endsection