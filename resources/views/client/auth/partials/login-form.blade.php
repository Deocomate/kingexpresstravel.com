<form action="{{ route('client.login.submit') }}" method="POST">
    @csrf
    <div class="space-y-4">
        <div>
            <label for="login-email" class="block text-sm font-medium text-gray-700">Email (*)</label>
            <input type="email" name="email" id="login-email" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
        </div>
        <div>
            <label for="login-password" class="block text-sm font-medium text-gray-700">Mật khẩu (*)</label>
            <input type="password" name="password" id="login-password" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
        </div>
    </div>
    <div class="mt-6">
        <button type="submit"
                class="w-full hover:cursor-pointer text-center bg-[var(--color-primary-accent)] text-white font-bold py-3 px-4 rounded-lg hover:bg-[var(--color-primary)] transition-colors">
            Đăng nhập
        </button>
    </div>
    <div class="mt-4 flex justify-between items-center text-sm">
        <button type="button" data-modal-switch="forgot-password-modal"
                class="font-medium hover:cursor-pointer text-[var(--color-primary)] hover:underline">Quên mật khẩu?
        </button>
        <button type="button" data-modal-switch="register-modal" class="font-medium hover:cursor-pointer text-[var(--color-primary)] hover:underline">Đăng
            ký
        </button>
    </div>
</form>
