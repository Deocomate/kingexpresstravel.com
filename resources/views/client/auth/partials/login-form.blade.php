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

    <div class="relative flex py-4 items-center">
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="flex-shrink mx-4 text-sm text-gray-500">Hoặc đăng nhập với</span>
        <div class="flex-grow border-t border-gray-300"></div>
    </div>
    <a href="{{ route('auth.google.redirect') }}"
       class="w-full flex items-center justify-center gap-x-3 py-2.5 px-4 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" viewBox="0 0 48 48">
            <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12
            s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24
            s8.955,20,20,20s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
            <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039
            l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
            <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36
            c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
            <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571
            l6.19,5.238C43.021,36.251,44,34,44,30C44,22.659,43.862,21.35,43.611,20.083z"></path>
        </svg>
        <span>Đăng nhập với Google</span>
    </a>
</form>
