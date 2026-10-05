<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     */
    // 1. Thêm tham số ...$roles để nhận danh sách quyền từ route
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // 2. Thêm dấu chấm phẩy
        }
        
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // 3. Đóng ngoặc và thêm dấu chấm phẩy
        return redirect()->route('dashboard')->with('error', 'Truy cập bị từ chối!');
    }
}