<form action="{{ route('client.register.submit') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 gap-y-3"> {{-- Giảm gap-y từ 4 xuống 3 --}}
        <div>
            <label for="register-name" class="block text-sm font-medium text-gray-700">Họ và tên (*)</label>
            <input type="text" name="name" id="register-name" required value="{{ old('name') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] text-sm"> {{-- Thêm text-sm --}}
            @error('name') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="register-email" class="block text-sm font-medium text-gray-700">Email (*)</label>
            <input type="email" name="email" id="register-email" required value="{{ old('email') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] text-sm">
            @error('email') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="register-phone" class="block text-sm font-medium text-gray-700">Số điện thoại (*)</label>
            <input type="tel" name="phone" id="register-phone" required value="{{ old('phone') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] text-sm">
            @error('phone') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="register-password" class="block text-sm font-medium text-gray-700">Mật khẩu (*)</label>
            <input type="password" name="password" id="register-password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] text-sm">
            @error('password') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="register-password-confirmation" class="block text-sm font-medium text-gray-700">Xác nhận mật khẩu (*)</label>
            <input type="password" name="password_confirmation" id="register-password-confirmation" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)] text-sm">
        </div>
    </div>
    <div class="mt-5"> {{-- Giảm mt từ 6 xuống 5 --}}
        <button type="submit" class="w-full hover:cursor-pointer text-center bg-[var(--color-primary-accent)] text-white font-bold py-2.5 px-4 rounded-lg hover:bg-[var(--color-primary)] transition-colors text-sm"> {{-- Giảm py từ 3 xuống 2.5, thêm text-sm --}}
            Đăng ký
        </button>
    </div>

    <div class="relative flex py-3 items-center"> {{-- Giảm py từ 4 xuống 3 --}}
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="flex-shrink mx-4 text-xs text-gray-500">Hoặc đăng ký với</span> {{-- Giảm text-sm xuống text-xs --}}
        <div class="flex-grow border-t border-gray-300"></div>
    </div>

    <a href="{{ route('auth.google.redirect') }}"
       class="w-full flex items-center justify-center gap-x-2 py-2 px-3 border border-gray-300 rounded-md text-xs font-semibold text-gray-700 hover:bg-gray-100 transition-colors"> {{-- Giảm py từ 2.5 xuống 2, px từ 4 xuống 3, text-sm xuống text-xs, gap-x từ 3 xuống 2 --}}
        <svg class="w-4 h-4" viewBox="0 0 48 48"> {{-- Giảm kích thước icon từ w-5 h-5 xuống w-4 h-4 --}}
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
        <span>Tiếp tục với Google</span>
    </a>

    <div class="mt-3 text-center text-xs"> {{-- Giảm mt từ 4 xuống 3, text-sm xuống text-xs --}}
        <span class="text-gray-600">Bạn đã có tài khoản?</span>
        <button type="button" data-modal-switch="login-modal"
                class="font-medium hover:cursor-pointer text-[var(--color-primary)] hover:underline">
            Đăng nhập ngay
        </button>
    </div>
</form>
