@extends('layouts.layoutmaster')

@push('styles')
<style>
    .form-box{ max-width: 480px; background: var(--paper-2); border: 1px solid var(--line); border-radius: var(--radius); padding: 28px; }
    .form-group{ margin-bottom: 18px; }
    .form-group label{ display:block; font-size:13px; font-weight:600; margin-bottom:6px; color: var(--ink); }
    .form-group input, .form-group select { width:100%; padding:10px 12px; border:1px solid var(--line); border-radius:8px; font-size:13.5px; outline:none; transition:border-color .15s ease; }
    .form-group input:focus, .form-group select:focus { border-color:var(--gold); }
    .btn-submit{ background: var(--navy); color:#F5F1E8; border:none; padding:10px 22px; border-radius:8px; font-size:13.5px; font-weight:600; cursor:pointer; }
    .btn-submit:hover{ background: var(--navy-2); }
    .error-box{ background:#FBEAEA; border:1px solid #E8B4B4; color:#A33; padding:12px 14px; border-radius:8px; font-size:13px; margin-bottom:18px; }
    .error-box ul{ margin-left:18px; margin-top:4px; }
</style>
@endpush

@section('content')
    <div class="page-title">Thêm sinh viên</div>
    <div class="page-sub">Nhập hồ sơ sinh viên mới vào hệ thống.</div>

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
        <form action="{{ route('sinhvien.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="ma_sv">Mã sinh viên (*)</label>
                <input type="text" id="ma_sv" name="ma_sv" value="{{ old('ma_sv') }}" required placeholder="VD: 6854321">
            </div>

            <div class="form-group">
                <label for="ho_ten">Họ và tên (*)</label>
                <input type="text" id="ho_ten" name="ho_ten" value="{{ old('ho_ten') }}" required placeholder="Nguyễn Văn A">
            </div>

            <div class="form-group">
                <label for="ngay_sinh">Ngày sinh (*)</label>
                <input type="date" id="ngay_sinh" name="ngay_sinh" value="{{ old('ngay_sinh') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email liên hệ (*)</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="ten@example.com">
            </div>

            <div class="form-group">
                <label for="lop_hoc_id">Xếp vào lớp (*)</label>
                <select id="lop_hoc_id" name="lop_hoc_id" required>
                    <option value="">-- Chọn lớp học --</option>
                    @foreach($lophocs as $lop)
                        <option value="{{ $lop->id }}" {{ old('lop_hoc_id') == $lop->id ? 'selected' : '' }}>
                            {{ $lop->ma_lop }} - {{ $lop->ten_lop }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-submit">Lưu hồ sơ sinh viên</button>
            <a href="/sinh-vien" style="margin-left: 15px; text-decoration: none; color: #555; font-size: 14px;">Hủy bỏ</a>
        </form>
    </div>
@endsection