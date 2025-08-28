<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['google_id' => $googleUser->getId()],
                [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(uniqid()),
                    'email_verified_at' => now(),
                    'account_type' => 'GOOGLE',
                ]
            );

            Auth::login($user, true);

            return redirect()->route('client.home')->with('success', 'Đăng nhập thành công!');

        } catch (\Exception $e) {
            return redirect()->route('client.home')->with('error', 'Đăng nhập bằng Google thất bại. Vui lòng thử lại.');
        }
    }
}
