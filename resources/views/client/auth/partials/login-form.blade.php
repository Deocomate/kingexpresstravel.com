<form action="{{ route('client.login.submit') }}" method="POST" class="relative">
    @csrf

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="space-y-4">
        <div class="relative">
            <label for="login-email" class="block text-sm font-medium text-gray-700">Email (*)</label>
            <input type="email" name="email" id="login-email" required value="{{ old('email') }}"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
        </div>
        <div class="relative">
            <label for="login-password" class="block text-sm font-medium text-gray-700">Mật khẩu (*)</label>
            <input type="password" name="password" id="login-password" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
        </div>
    </div>
    <div class="mt-4 flex justify-between items-center text-sm">
        <div class="flex items-center">
            <input id="remember" name="remember" type="checkbox"
                   class="h-4 w-4 rounded border-gray-300 text-[var(--color-primary)] focus:ring-[var(--color-primary-accent)]">
            <label for="remember" class="ml-2 block text-gray-900">Ghi nhớ</label>
        </div>
        <button type="button" data-modal-switch="forgot-password-modal"
                class="font-medium hover:cursor-pointer text-[var(--color-primary)] hover:underline">Quên mật khẩu?
        </button>
    </div>
    <div class="mt-6">
        <button type="submit"
                class="w-full hover:cursor-pointer text-center bg-[var(--color-primary-accent)] text-white font-bold py-3 px-4 rounded-lg hover:bg-[var(--color-primary)] transition-colors">
            Đăng nhập
        </button>
    </div>
    <div class="mt-4 text-center text-sm">
        <span class="text-gray-600">Bạn chưa có tài khoản?</span>
        <button type="button" data-modal-switch="register-modal"
                class="font-medium hover:cursor-pointer text-[var(--color-primary)] hover:underline">
            Đăng ký ngay
        </button>
    </div>
</form>
