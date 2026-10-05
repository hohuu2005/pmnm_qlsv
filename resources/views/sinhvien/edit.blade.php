@extends('layouts.layoutmaster')

@push('styles')
<style>
    .form-box{
        max-width: 480px;
        background: var(--paper-2);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        padding: 28px;
    }
    .form-group{ margin-bottom: 18px; }
    .form-group label{
        display:block;
        font-size:13px;
        font-weight:600;
        margin-bottom:6px;
        color: var(--ink);
    }
    .form-group input{
        width:100%;
        padding:10px 12px;
        border:1px solid var(--line);
        border-radius:8px;
        font-size:13.5px;
        font-family:'Inter', sans-serif;
        outline:none;
        transition:border-color .15s ease;
    }
    .form-group input:focus{ border-color:var(--gold); }
    .form-group input:read-only { background-color: #e9ecef; cursor: not-allowed; }
    .btn-submit{
        background: var(--navy);
        color:#F5F1E8;
        border:none;
        padding:10px 22px;
        border-radius:8px;
        font-size:13.5px;
        font-weight:600;
        cursor:pointer;
        transition:background .15s ease;
    }
    .btn-submit:hover{ background: var(--navy-2); }
    .error-box{
        background:#FBEAEA;
        border:1px solid #E8B4B4;
        color:#A33;
        padding:12px 14px;
        border-radius:8px;
        font-size:13px;
        margin-bottom:18px;
    }
    .error-box ul{ margin-left:18px; margin-top:4px; }
</style>
@endpush

@section('content')
    <div class="page-title">Sửa thông tin sinh viên</div>
    <div class="page-sub">Cập nhật thông tin cho sinh viên: <strong>{{ $sinhvien->ho_ten }}</strong></div>

    @if ($errors->any())
        <div class="error-box">
            <strong>Có lỗi xảy ra:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-box">
        <form action="/sinh-vien/cap-nhat/{{ $sinhvien->id }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="ho_ten">Họ và tên (*)</label>
                <input type="text" id="ho_ten" name="ho_ten" value="{{ old('ho_ten', $sinhvien->ho_ten) }}" required>
            </div>

            <div class="form-group">
                <label for="ngay_sinh">Ngày sinh</label>
                {{-- Đổi thành type="date" và liên kết với biến ngay_sinh --}}
                <input type="date" id="ngay_sinh" name="ngay_sinh" value="{{ old('ngay_sinh', $sinhvien->ngay_sinh) }}">
            </div>

            <div class="form-group">
                <label for="email">Email (Không được phép sửa)</label>
                {{-- Dùng readonly thay vì disabled để form vẫn gửi được dữ liệu này lên --}}
                <input type="email" id="email" name="email" value="{{ $sinhvien->email }}" readonly>
            </div>

            <button type="submit" class="btn-submit">Cập nhật</button>
            <a href="/sinh-vien" style="margin-left: 15px; text-decoration: none; color: #555; font-size: 14px;">Hủy bỏ</a>
        </form>
    </div>
@endsection