<form action="{{ route('client.forgot-password.submit') }}" method="POST">
    @csrf
    <div class="space-y-4">
        <div>
            <label for="forgot-email" class="block text-sm font-medium text-gray-700">Email (*)</label>
            <input type="email" name="email" id="forgot-email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
        </div>
    </div>
    <div class="mt-6">
        <button type="submit" class="w-full hover:cursor-pointer text-center bg-amber-400 text-white font-bold py-3 px-4 rounded-lg hover:bg-amber-500 transition-colors">
            Lấy lại mật khẩu
        </button>
    </div>
</form>
