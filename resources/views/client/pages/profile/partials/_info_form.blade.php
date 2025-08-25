@props(['user'])

<div class="bg-white p-6 md:p-8 rounded-lg shadow-sm border border-gray-200">
    <h1 class="text-2xl font-bold text-gray-800">Tài khoản</h1>

    <form action="{{ route('client.profile.update') }}" method="POST" class="mt-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-5">
            <div class="flex items-center gap-x-4">
                <div class="relative w-24 h-24">
                    <div id="avatar-placeholder" class="w-24 h-24 rounded-full bg-[var(--color-primary)] flex items-center justify-center text-white text-4xl font-bold {{ $user->avatar ? 'hidden' : '' }}">
                        {{ strtoupper(substr($user->name ?? 'A', 0, 2)) }}
                    </div>
                    <img id="avatar-preview" class="w-24 h-24 rounded-full object-cover {{ !$user->avatar ? 'hidden' : '' }}" src="{{ $user->avatar ?? '' }}" alt="Avatar">
                </div>
                <div>
                    <label for="avatar_file" class="cursor-pointer px-4 py-2 text-sm font-semibold bg-gray-100 text-gray-700 rounded-md border border-gray-300 hover:bg-gray-200">
                        <span>Thay đổi ảnh</span>
                        <input type="file" name="avatar_file" id="avatar_file" class="hidden" accept="image/*">
                    </label>
                    <p class="text-xs text-gray-500 mt-2">JPG, GIF or PNG. 1MB max.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-8">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" value="{{ $user->email ?? '' }}" disabled class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed">
                    <div class="mt-2 text-sm">
                        @if($user->hasVerifiedEmail())
                            <span class="text-green-600 font-semibold"><i class="fa-solid fa-circle-check"></i> Đã xác minh</span>
                        @else
                            <span class="text-yellow-600 font-semibold"><i class="fa-solid fa-triangle-exclamation"></i> Chưa xác minh</span>
                            <button type="button" id="verify-email-button" class="ml-2 font-semibold text-[var(--color-primary)] hover:underline disabled:text-gray-400 disabled:no-underline disabled:cursor-not-allowed cursor-pointer">Gửi email xác minh</button>
                            <span id="cooldown-timer" class="ml-2 text-gray-500 hidden"></span>
                        @endif
                    </div>
                </div>
                <div class="md:col-span-4 flex items-end">
                    <div class="flex items-center">
                        <input id="change_password" name="change_password" type="checkbox" value="1" class="h-4 w-4 rounded border-gray-300 text-[var(--color-primary)] focus:ring-[var(--color-primary-accent)]">
                        <label for="change_password" class="ml-2 block text-sm text-gray-900">Đổi mật khẩu</label>
                    </div>
                </div>
            </div>

            <div id="password_fields" class="hidden space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu mới</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Xác nhận mật khẩu mới</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Họ và tên</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone ?? '') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                </div>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                <input type="text" name="address" id="address" value="{{ old('address', $user->address ?? '') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="w-auto hover:cursor-pointer text-center bg-[var(--color-primary-accent)] text-white font-bold py-2.5 px-8 rounded-lg hover:bg-[var(--color-primary)] transition-colors flex items-center">
                <i class="fa-solid fa-floppy-disk mr-2"></i>
                Lưu
            </button>
        </div>
    </form>
</div>
