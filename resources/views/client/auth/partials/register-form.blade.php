<form action="{{ route('client.register.submit') }}" method="POST">
    @csrf
    <div class="space-y-4">
        <div>
            <label for="register-email" class="block text-sm font-medium text-gray-700">Email (*)</label>
            <input type="email" name="email" id="register-email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
        </div>
        <div>
            <label for="register-phone" class="block text-sm font-medium text-gray-700">Số điện thoại (*)</label>
            <input type="tel" name="phone" id="register-phone" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
        </div>
        <div>
            <label for="register-password" class="block text-sm font-medium text-gray-700">Mật khẩu (*)</label>
            <input type="password" name="password" id="register-password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
        </div>
        <div>
            <label for="register-password-confirmation" class="block text-sm font-medium text-gray-700">Xác nhận mật khẩu (*)</label>
            <input type="password" name="password_confirmation" id="register-password-confirmation" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
        </div>
    </div>
    <div class="mt-6">
        <button type="submit" class="w-full hover:cursor-pointer text-center bg-amber-400 text-white font-bold py-3 px-4 rounded-lg hover:bg-amber-500 transition-colors">
            Đăng ký
        </button>
    </div>
</form>
