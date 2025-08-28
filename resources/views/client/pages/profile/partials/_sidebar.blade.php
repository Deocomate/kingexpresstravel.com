@props(['user'])

<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
    <div class="flex items-center gap-x-4">
        <div class="relative w-16 h-16">
            @if($user->avatar)
                <img class="w-16 h-16 rounded-full object-cover" src="{{ $user->avatar }}" alt="{{ $user->name ?? '' }}">
            @else
                <div class="w-16 h-16 rounded-full bg-[var(--color-primary)] flex items-center justify-center text-white text-2xl font-bold">
                    {{ strtoupper(substr($user->name ?? 'A', 0, 2)) }}
                </div>
            @endif
        </div>
        <div>
            <h2 class="font-bold text-gray-800">{{ $user->name ?? '' }}</h2>
            <p class="text-sm text-gray-500">Thành viên đồng (0)</p>
        </div>
    </div>
    <nav class="mt-6 space-y-2">
        <a href="{{ route('client.profile') }}" class="flex items-center gap-x-3 px-4 py-3 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('client.profile') ? 'bg-[var(--color-primary-light)] text-[var(--color-primary-dark)]' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-800' }}">
            <i class="fa-solid fa-user-pen w-5 text-center"></i>
            <span>Hồ sơ cá nhân</span>
        </a>
        <a href="{{ route('client.profile.history') }}" class="flex items-center gap-x-3 px-4 py-3 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('client.profile.history') ? 'bg-[var(--color-primary-light)] text-[var(--color-primary-dark)]' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-800' }}">
            <i class="fa-solid fa-receipt w-5 text-center"></i>
            <span>Đơn hàng của tôi</span>
        </a>
        @if($user->account_type === 'LOCAL')
            <a href="{{ route('client.profile.change-password') }}" class="flex items-center gap-x-3 px-4 py-3 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('client.profile.change-password') ? 'bg-[var(--color-primary-light)] text-[var(--color-primary-dark)]' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-800' }}">
                <i class="fa-solid fa-lock w-5 text-center"></i>
                <span>Đổi mật khẩu</span>
            </a>
        @endif
        <a href="#" class="flex items-center gap-x-3 px-4 py-3 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors">
            <i class="fa-solid fa-star-half-stroke w-5 text-center"></i>
            <span>Đánh giá chuyến đi</span>
        </a>
        <a href="#" class="flex items-center gap-x-3 px-4 py-3 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors">
            <i class="fa-solid fa-heart w-5 text-center"></i>
            <span>Danh sách yêu thích</span>
        </a>
        <div class="border-t border-gray-200 my-2"></div>
        <form method="POST" action="{{ route('client.logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-x-3 px-4 py-3 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition-colors">
                <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
                <span>Thoát</span>
            </button>
        </form>
    </nav>
</div>
