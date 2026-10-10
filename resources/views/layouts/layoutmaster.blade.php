<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title ?? 'Quản lý Sinh viên' }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  /* ===== Biến dùng chung cho toàn bộ layout ===== */
  :root{
    --navy:          #16213E;
    --navy-2:        #1D2C52;
    --navy-border:   #2A3B68;
    --gold:          #C9A227;
    --gold-dim:      #3A331A;
    --paper:         #FBF9F4;
    --paper-2:       #F2EEE3;
    --ink:           #24262B;
    --ink-muted:     #6E7178;
    --line:          #E4DFD0;
    --radius:        10px;
  }

  *{ box-sizing:border-box; margin:0; padding:0; }

  /* ===== Khung grid tổng thể của trang ===== */
  body{
    background:var(--paper);
    color:var(--ink);
    font-family:'Inter', sans-serif;
    min-height:100vh;
    display:grid;
    grid-template-rows:68px 1fr 48px;
    grid-template-columns:250px 1fr;
    grid-template-areas:
      "header header"
      "sidebar main"
      "footer footer";
  }

  h1, h2, .serif{ font-family:'Fraunces', serif; }
  .mono{ font-family:'JetBrains Mono', monospace; }

  /* ===== Style cho vùng nội dung chính (main) ===== */
  main{ grid-area:main; padding:34px 38px; overflow-y:auto; }
  .page-title{ font-family:'Fraunces', serif; font-size:26px; font-weight:700; margin-bottom:6px; }
  .page-sub{ color:var(--ink-muted); font-size:13.5px; margin-bottom:26px; }
  .placeholder-box{
    border:1px dashed var(--line); background:var(--paper-2); border-radius:var(--radius);
    padding:44px 24px; text-align:center; color:var(--ink-muted); font-size:13.5px;
  }
  .placeholder-box code{
    display:inline-block; margin-top:10px; background:#fff; border:1px solid var(--line);
    padding:4px 10px; border-radius:6px; font-size:12px; color:var(--navy);
  }
  /* ===== Ánh xạ các thành phần vào đúng khu vực của Grid ===== */
  .header { grid-area: header; } /* Giả sử file header.blade.php dùng class .header */
  .sidebar { grid-area: sidebar; } /* Sidebar của em đang dùng class .sidebar */
  footer, .footer { grid-area: footer; }

  @media (max-width: 860px){
    body{ 
      grid-template-columns: 1fr; 
      /* Bỏ 'auto' của sidebar đi, chỉ giữ lại header, main, footer */
      grid-template-rows: 68px 1fr 48px;
      grid-template-areas: 
        "header" 
        "main" 
        "footer"; 
    }
    
    /* Ẩn hoàn toàn Sidebar trên màn hình nhỏ để nhường chỗ cho Form */
    aside, .sidebar {
      display: none !important;
    }
    
    main {
      padding: 20px 15px; /* Thu nhỏ lề của main để form rộng rãi hơn trên mobile */
    }
  }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    @include('partials.header')
    @include('partials.sidebar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('styles')
    @stack('scripts')

</body>
</html>