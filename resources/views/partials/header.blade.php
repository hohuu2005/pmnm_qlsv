{{-- resources/views/partials/header.blade.php --}}
@push('styles')
<style>
    header{
        grid-area:header;
        display:flex;
        align-items:center;
        justify-content:space-between;
        padding:0 26px;
        background:var(--navy);
        border-bottom:2px solid var(--gold);
    }
    .brand{ display:flex; align-items:center; gap:12px; color:#F5F1E8; }
    .brand-mark{
        width:34px; height:34px; border-radius:50%;
        background:var(--gold);
        display:flex; align-items:center; justify-content:center;
        font-family:'Fraunces', serif; font-weight:700; font-size:15px; color:var(--navy);
    }
    .brand-text .title{ font-family:'Fraunces', serif; font-weight:700; font-size:17px; letter-spacing:.01em; }
    .brand-text .sub{ font-size:11px; color:#9FA8C9; letter-spacing:.06em; text-transform:uppercase; }

    .header-search{ flex:1; max-width:400px; margin:0 32px; position:relative; }
    .header-search input{
        width:100%; background:var(--navy-2); border:1px solid var(--navy-border);
        border-radius:8px; padding:9px 12px 9px 34px; color:#F5F1E8; font-size:13px;
        outline:none; transition:border-color .15s ease;
    }
    .header-search input:focus{ border-color:var(--gold); }
    .header-search input::placeholder{ color:#7A85AB; }
    .header-search svg{ position:absolute; left:11px; top:50%; transform:translateY(-50%); stroke:#7A85AB; }

    .header-user{ display:flex; align-items:center; gap:10px; padding-left:20px; border-left:1px solid var(--navy-border); }
    .avatar{
        width:34px; height:34px; border-radius:50%; background:var(--navy-2); border:1px solid var(--gold);
        display:flex; align-items:center; justify-content:center;
        font-family:'Fraunces', serif; font-size:13px; font-weight:700; color:var(--gold);
        text-transform: uppercase;
    }
    .header-user .name{ font-size:13px; font-weight:600; color:#F5F1E8; }
    .header-user .role{ font-size:11px; color:#9FA8C9; }
    
    /* Nút đăng xuất style matching với theme */
    .btn-logout {
        background: transparent; border: 1px solid var(--gold); color: var(--gold); 
        padding: 5px 12px; border-radius: 4px; font-size: 12px; cursor: pointer; 
        margin-left: 15px; transition: all 0.2s; font-weight: bold;
    }
    .btn-logout:hover {
        background: var(--gold); color: var(--navy);
    }
</style>
@endpush

<header>
    <div class="brand">
        <div class="brand-mark">QL</div>
        <div class="brand-text">
            <div class="title">Quản lý Sinh viên</div>
            <div class="sub">Hệ thống học vụ</div>
        </div>
    </div>

    @if(Auth::check())
    <div class="header-user">
        <!-- Tự động cắt chữ cái đầu tiên của tên làm Avatar -->
        <div class="avatar">{{ mb_substr(Auth::user()->name, 0, 1) }}</div>
        <div>
            <!-- Hiển thị tên động -->
            <div class="name">{{ Auth::user()->name }}</div>
            <!-- Dịch Role tiếng Anh sang chức danh tiếng Việt -->
            <div class="role">
                @if(Auth::user()->role == 'admin') Quản trị viên
                @elseif(Auth::user()->role == 'giang_vien') Giảng viên
                @else Sinh viên
                @endif
            </div>
        </div>
        
        <!-- Form Đăng xuất -->
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-logout">Đăng xuất</button>
        </form>
    </div>
    @endif
</header>