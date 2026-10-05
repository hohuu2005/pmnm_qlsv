@extends('layouts.layoutmaster')

@push('styles')
<style>
    .header-box { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    h1 { color: var(--navy); margin: 0; }
    .btn-add { background-color: #0d6efd; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; }
    table { border-collapse: collapse; width: 100%; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    th, td { text-align: left; padding: 12px; border-bottom: 1px solid var(--line); }
    th { background-color: #f8f9fa; color: #333; }
</style>
@endpush

@section('content')
    <div class="header-box">
        <h1>Quản lý Menu</h1>
        {{-- Nút chuyển hướng sang trang Form Thêm --}}
        <a href="{{ route('menu.create') }}" class="btn-add">+ Thêm Menu mới</a>
    </div>

    @if(session('success'))
        <div style="background: #d1e7dd; color: #0f5132; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên hiển thị</th>
                <th>Đường dẫn (Slug)</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach($menus as $menu)
            <tr>
                <td>{{ $menu->id }}</td>
                <td><strong>{{ $menu->tenhienthi }}</strong></td>
                <td>{{ $menu->slug }}</td>
                <td>
                    @if($menu->trangthai == 'Hoạt động')
                        <span style="color: green; font-weight: bold;">Hoạt động</span>
                    @else
                        <span style="color: red;">Đã ẩn</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('menu.edit', $menu->id) }}" style="background: #ffc107; color: #000; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 14px;">Sửa</a>
                    
                    <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa menu này?');">
                        @csrf
                        <button type="submit" style="background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; font-size: 14px;">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 15px;">
        {{ $menus->links() }}
    </div>
@endsection