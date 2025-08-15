<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return to_route('admin.login');
    }


    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->remember != null;

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return to_route("admin.dashboard.index");
        }

        return back()->withErrors([
            'error' => 'Đăng nhập thất bại',
        ])->onlyInput('email');
    }
}
