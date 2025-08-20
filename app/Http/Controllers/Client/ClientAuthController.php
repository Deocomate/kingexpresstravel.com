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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('client.home'))
                ->with('success', 'Đăng nhập thành công!');
        }

        return back()->with('error', 'Email hoặc mật khẩu không chính xác.');
    }

    public function handleRegistration(Request $request): RedirectResponse
    {
        return back()->with('success', 'Đăng ký thành công (chức năng đang phát triển).');
    }

    public function handleForgotPassword(Request $request): RedirectResponse
    {
        return back()->with('success', 'Yêu cầu lấy lại mật khẩu đã được gửi (chức năng đang phát triển).');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('client.home')->with('success', 'Đăng xuất thành công!');
    }
}
