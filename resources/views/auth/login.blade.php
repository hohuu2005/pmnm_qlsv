<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .login-box h2 { text-align: center; color: #1e3a5f; margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; outline: none; }
        .btn-login { width: 100%; background: #0d6efd; color: #fff; padding: 12px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px; }
        .error { color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>HUCE HỌC VỤ</h2>
        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email đăng nhập</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="VD: admin@huce.edu.vn">
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="password" required placeholder="Nhập mật khẩu">
            </div>
            <button type="submit" class="btn-login">Đăng nhập</button>
        </form>
    </div>
</body>
</html>