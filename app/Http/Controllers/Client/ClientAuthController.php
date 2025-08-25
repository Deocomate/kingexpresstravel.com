<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;

class ClientAuthController extends Controller
{
    // ... (các phương thức handleLogin, handleRegistration không đổi) ...
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        if ($validator->fails()) {
            $response = back()
                ->withErrors($validator)
                ->withInput()
                ->with('registration_error', true);

            if ($validator->errors()->has('email')) {
                return $response->with('error', $validator->errors()->first('email'));
            }

            if ($validator->errors()->has('password')) {
                return $response->with('error', $validator->errors()->first('password'));
            }

            return $response;
        }

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('client.home')->with('success', 'Đăng ký thành công! Chào mừng bạn.');
    }

    public function handleForgotPassword(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Chúng tôi đã gửi link lấy lại mật khẩu qua email của bạn!');
        }

        return back()->withErrors(['email' => __($status)])->with('error', 'Không thể gửi link. Vui lòng thử lại.');
    }

    public function showResetForm(Request $request): View|RedirectResponse
    {
        $token = $request->route('token');

        $tokenRecord = DB::table(config('auth.passwords.users.table'))
            ->where('email', $request->query('email'))
            ->first();

        if (!$tokenRecord || !Hash::check($token, $tokenRecord->token)) {
            return redirect()->route('client.home')->with('error', 'Liên kết đặt lại mật khẩu không hợp lệ hoặc đã được sử dụng.');
        }

        $expiresAt = Carbon::parse($tokenRecord->created_at)->addMinutes(config('auth.passwords.users.expire', 5));
        if (Carbon::now()->gt($expiresAt)) {
            return redirect()->route('client.home')->with('error', 'Liên kết đặt lại mật khẩu đã hết hạn. Vui lòng yêu cầu lại.');
        }

        return view('client.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', '')
        ]);
    }

    public function handleResetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('client.home')->with('success', 'Đặt lại mật khẩu thành công!');
        }

        return back()->withInput($request->only('email'))
            ->with('error', 'Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn. Vui lòng thử lại.');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('client.home')->with('success', 'Đăng xuất thành công!');
    }
}
