@extends('client.layouts.app')

@section('title', 'Đặt lại mật khẩu')
@section('description', 'Đặt lại mật khẩu cho tài khoản King Express Travel của bạn.')

@section('content')
    <div class="py-12 md:py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6 md:p-8">
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-gray-800">Đặt lại mật khẩu</h1>
                    <p class="mt-2 text-gray-600">Vui lòng nhập mật khẩu mới của bạn.</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}" class="mt-8 space-y-5">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token ?? '' }}">

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email (*)</label>
                        <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required
                               readonly
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed focus:outline-none focus:ring-0">
                        @error('email') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu mới (*)</label>
                        <input id="password" type="password" name="password" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                        @error('password') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Xác nhận mật
                            khẩu (*)</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="w-full hover:cursor-pointer text-center bg-[var(--color-primary-accent)] text-white font-bold py-3 px-4 rounded-lg hover:bg-[var(--color-primary)] transition-colors">
                            Đặt lại mật khẩu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
