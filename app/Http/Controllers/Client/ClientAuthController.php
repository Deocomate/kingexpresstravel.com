<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAuthController extends Controller
{
    public function handleLogin(Request $request): RedirectResponse
    {
        // Logic xử lý đăng nhập sẽ được thêm sau
        return back()->with('success', 'Đăng nhập thành công (chức năng đang phát triển).');
    }

    public function handleRegistration(Request $request): RedirectResponse
    {
        // Logic xử lý đăng ký sẽ được thêm sau
        return back()->with('success', 'Đăng ký thành công (chức năng đang phát triển).');
    }

    public function handleForgotPassword(Request $request): RedirectResponse
    {
        // Logic xử lý quên mật khẩu sẽ được thêm sau
        return back()->with('success', 'Yêu cầu lấy lại mật khẩu đã được gửi (chức năng đang phát triển).');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('client.home');
    }
}
