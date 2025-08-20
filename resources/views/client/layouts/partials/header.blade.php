<header>
    {{-- Top Bar --}}
    <div class="bg-amber-500 text-white">
        <div class="container mx-auto px-4 flex justify-between items-center h-12">
            <div class="flex items-center gap-x-6">
                <a href="tel:19001177" class="flex items-center gap-x-2 text-sm font-semibold hover:text-yellow-200 transition-colors">
                    <i class="fa-solid fa-phone-volume"></i>
                    <span>Hotline: 1900 1177</span>
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </a>
            </div>

            <div class="hidden md:flex items-center justify-center flex-grow">
                <form action="#" method="GET" class="w-full max-w-lg">
                    <div class="relative">
                        <input
                            type="search"
                            name="keyword"
                            placeholder="Bạn muốn đi du lịch ở đâu?"
                            class="w-full bg-yellow-50 text-gray-800 placeholder-gray-500 rounded-md py-2 pl-4 pr-10 focus:outline-none focus:ring-2 focus:ring-yellow-300"
                        >
                        <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3 text-amber-500 hover:text-amber-600" aria-label="Tìm kiếm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex items-center gap-x-6">
                <a href="#" class="hidden sm:flex items-center gap-x-2 text-sm font-semibold hover:text-yellow-200 transition-colors">
                    <i class="fa-solid fa-file-pen"></i>
                    <span>Phiếu góp ý</span>
                </a>
                <a href="#" class="flex items-center gap-x-2 text-sm font-semibold hover:text-yellow-200 transition-colors">
                    <i class="fa-regular fa-user"></i>
                    <span>Tài khoản</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Main Navigation Bar --}}
    <div class="bg-white shadow-md relative">
        <div class="container mx-auto px-4 flex justify-between items-center h-20">
            <a href="{{ route('client.home') }}" title="Trang chủ {{ config('app.name', 'KingExpressTravel') }}">
                <img src="https://via.placeholder.com/180x50.png?text={{ urlencode(config('app.name', 'KingExpressTravel')) }}" alt="{{ config('app.name', 'KingExpressTravel') }} Logo" class="h-12">
            </a>

            {{-- Desktop Menu --}}
            <nav class="hidden lg:flex items-center">
                <ul class="flex items-center gap-x-6">
                    <li><a href="{{ route('client.home') }}" class="block text-base leading-6 font-bold uppercase py-[15px] hover:text-amber-500 transition-colors {{ request()->routeIs('client.home') ? 'text-amber-500' : 'text-[#555]' }}">Trang chủ</a></li>
                    <li><a href="{{ route('client.tours') }}" class="block text-base leading-6 font-bold uppercase py-[15px] hover:text-amber-500 transition-colors {{ request()->routeIs('client.tours') ? 'text-amber-500' : 'text-[#555]' }}">Du lịch</a></li>
                    <li><a href="{{ route('client.news') }}" class="block text-base leading-6 font-bold uppercase py-[15px] hover:text-amber-500 transition-colors {{ request()->routeIs('client.news') ? 'text-amber-500' : 'text-[#555]' }}">Tin tức và Sự kiện</a></li>
                    <li><a href="{{ route('client.about') }}" class="block text-base leading-6 font-bold uppercase py-[15px] hover:text-amber-500 transition-colors {{ request()->routeIs('client.about') ? 'text-amber-500' : 'text-[#555]' }}">Giới thiệu</a></li>
                    <li><a href="{{ route('client.contact') }}" class="block text-base leading-6 font-bold uppercase py-[15px] hover:text-amber-500 transition-colors {{ request()->routeIs('client.contact') ? 'text-amber-500' : 'text-[#555]' }}">Liên hệ</a></li>
                </ul>
            </nav>

            {{-- Mobile Menu Button --}}
            <div class="lg:hidden">
                <button id="mobile-menu-button" class="text-gray-700 hover:text-amber-500 focus:outline-none" aria-label="Mở menu" aria-expanded="false">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="lg:hidden absolute top-full left-0 w-full bg-white shadow-md z-20 transition-all duration-300 ease-in-out max-h-0 overflow-hidden">
            <nav class="container mx-auto px-4 py-4">
                <ul class="flex flex-col gap-y-2">
                    <li><a href="{{ route('client.home') }}" class="block text-base leading-6 font-bold text-[#555] uppercase py-2 hover:text-amber-500 transition-colors text-center {{ request()->routeIs('client.home') ? 'text-amber-500' : 'text-[#555]' }}">Trang chủ</a></li>
                    <li><a href="{{ route('client.tours') }}" class="block text-base leading-6 font-bold text-[#555] uppercase py-2 hover:text-amber-500 transition-colors text-center {{ request()->routeIs('client.tours') ? 'text-amber-500' : 'text-[#555]' }}">Du lịch</a></li>
                    <li><a href="{{ route('client.news') }}" class="block text-base leading-6 font-bold text-[#555] uppercase py-2 hover:text-amber-500 transition-colors text-center {{ request()->routeIs('client.news') ? 'text-amber-500' : 'text-[#555]' }}">Tin tức và Sự kiện</a></li>
                    <li><a href="{{ route('client.about') }}" class="block text-base leading-6 font-bold text-[#555] uppercase py-2 hover:text-amber-500 transition-colors text-center {{ request()->routeIs('client.about') ? 'text-amber-500' : 'text-[#555]' }}">Giới thiệu</a></li>
                    <li><a href="{{ route('client.contact') }}" class="block text-base leading-6 font-bold text-[#555] uppercase py-2 hover:text-amber-500 transition-colors text-center {{ request()->routeIs('client.contact') ? 'text-amber-500' : 'text-[#555]' }}">Liên hệ</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
