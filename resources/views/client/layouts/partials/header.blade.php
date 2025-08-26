<header class="sticky top-0 z-30">
    <div class="bg-[var(--color-primary)] text-[var(--color-text-on-primary)]">
        <div class="container mx-auto px-4 flex justify-between items-center h-12">
            <div class="flex items-center gap-x-6">
                <a href="tel:19001177"
                   class="flex items-center gap-x-2 text-sm font-semibold hover:text-[var(--color-primary-subtle-hover)] transition-colors cursor-pointer">
                    <i class="fa-solid fa-phone-volume"></i>
                    <span>Hotline: 1900 1177</span>
                </a>
            </div>

            <div class="hidden md:flex items-center justify-center flex-grow">
                <div class="w-full max-w-lg">
                    <form action="{{ route('client.tours') }}" method="GET" class="relative"
                          id="autocomplete-search-form" data-suggestions-url="{{ route('api.search.suggestions') }}">
                        <input
                            type="search"
                            name="search"
                            id="autocomplete-search-input"
                            placeholder="Bạn muốn đi du lịch ở đâu?"
                            class="w-full bg-white text-gray-800 placeholder-gray-500 rounded-md py-2 pl-4 pr-10 focus:outline-none focus:ring-2 focus:ring-[var(--color-primary-accent)]"
                            autocomplete="off"
                        >
                        <button type="submit"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-[var(--color-primary)] hover:text-[var(--color-primary-dark)] cursor-pointer"
                                aria-label="Tìm kiếm">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <div id="autocomplete-results"
                             class="hidden absolute top-full left-0 w-full bg-white rounded-b-md shadow-lg mt-1 z-50 overflow-hidden">
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex items-center gap-x-6">
                <a href="{{ route('client.contact') }}"
                   class="hidden sm:flex items-center gap-x-2 text-sm font-semibold hover:text-[var(--color-primary-subtle-hover)] transition-colors cursor-pointer">
                    <i class="fa-solid fa-file-pen"></i>
                    <span>Phiếu góp ý</span>
                </a>

                <div class="relative">
                    @guest
                        <button type="button" id="guest-account-button"
                                class="flex items-center gap-x-2 text-sm font-semibold hover:text-[var(--color-primary-subtle-hover)] transition-colors cursor-pointer">
                            <i class="fa-regular fa-user"></i>
                            <span>Tài khoản</span>
                        </button>
                        <div id="guest-dropdown"
                             class="hidden absolute top-full right-0 mt-3 w-48 bg-white rounded-md shadow-lg py-2 z-20 text-center">
                            <button type="button" data-modal-target="login-modal"
                                    class="hover:cursor-pointer text-center bg-[var(--color-primary-accent)] text-[var(--color-text-on-primary)] font-bold py-2 px-6 rounded-lg hover:bg-[var(--color-primary)] transition-colors mx-auto block w-[90%]">
                                Đăng nhập
                            </button>
                            <p class="text-xs text-gray-600 mt-2">
                                Bạn chưa có tài khoản?
                                <button type="button" data-modal-switch="register-modal"
                                        class="font-bold hover:cursor-pointer text-[var(--color-primary)] hover:underline">
                                    Đăng ký ngay
                                </button>
                            </p>
                        </div>
                    @endguest

                    @auth
                        <button type="button" id="account-button"
                                class="flex items-center gap-x-2 text-sm font-semibold hover:text-[var(--color-primary-subtle-hover)] transition-colors cursor-pointer">
                            @if(Auth::user()->avatar)
                                <img class="w-8 h-8 rounded-full object-cover" src="{{ Auth::user()->avatar }}"
                                     alt="{{ Auth::user()->name }}">
                            @else
                                <div
                                    class="w-8 h-8 rounded-full bg-[var(--color-primary-dark)] flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
                                </div>
                            @endif
                            <span>{{ Auth::user()->name }}</span>
                        </button>
                        <div id="account-dropdown"
                             class="hidden absolute top-full right-0 mt-3 w-48 bg-white rounded-md shadow-lg py-2 z-20">
                            <a href="{{ route('client.profile') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-[var(--color-primary-light)]">Trang
                                cá nhân</a>
                            <a href="{{ route('client.profile.history') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-[var(--color-primary-light)]">Lịch
                                sử đặt tour</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('client.logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-[var(--color-primary-light)]">
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- Main Navigation Bar --}}
    <div class="bg-white shadow-md relative">
        <div class="container mx-auto px-4 flex justify-between items-center h-20">
            <a href="{{ route('client.home') }}" title="Trang chủ {{ config('app.name', 'KingExpressTravel') }}"
               class="py-2">
                <span
                    class="text-4xl font-extrabold italic bg-gradient-to-b from-[var(--color-primary-accent)] to-[var(--color-primary-dark)] bg-clip-text text-transparent tracking-tight">
                    King Express
                </span>
            </a>

            {{-- Desktop Menu --}}
            <nav class="hidden lg:flex items-center static">
                <ul class="flex items-center gap-x-6">
                    <li><a href="{{ route('client.home') }}"
                           class="block text-base leading-6 font-bold uppercase py-[15px] hover:text-[var(--color-primary)] transition-colors cursor-pointer {{ request()->routeIs('client.home') ? 'text-[var(--color-primary)]' : 'text-[#555]' }}">Trang
                            chủ</a></li>
                    <li class="group relative">
                        <a href="{{ route('client.tours') }}"
                           class="relative inline-block text-base leading-6 font-bold uppercase py-[15px] px-2
              hover:text-[var(--color-primary)] transition-colors cursor-pointer
              {{ request()->routeIs('client.tours*') ? 'text-[var(--color-primary)]' : 'text-[#555]' }}
              before:content-[''] before:absolute before:left-0 before:top-full
              before:w-full before:h-2 before:bg-transparent before:pointer-events-auto before:z-10">
                            Du lịch
                        </a>

                        @if(isset($tourCategoriesForMenu) && $tourCategoriesForMenu->isNotEmpty())
                            <div
                                class="absolute top-full left-[-222%] -translate-x-1/2 w-screen max-w-7xl
                   hidden group-hover:block transition-all duration-300 z-30 pointer-events-none">
                                <div class="mt-2 pointer-events-auto">
                                    <div class="bg-white rounded-lg shadow-2xl overflow-hidden border border-gray-200">
                                        <div class="flex" id="mega-menu-container">
                                            <div class="w-1/4 lg:w-1/5 bg-gray-50 border-r border-gray-200">
                                                <ul class="py-2">
                                                    @foreach($tourCategoriesForMenu as $parentCategory)
                                                        <li>
                                                            <a href="{{ route('client.tours', ['category' => $parentCategory->slug]) }}"
                                                               data-category-target="children-{{ $parentCategory->id }}"
                                                               class="mega-menu-parent-item flex justify-between items-center px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-[var(--color-primary-light)] hover:text-[var(--color-primary-dark)] transition-colors">
                                                                <span>{{ $parentCategory->name }}</span>
                                                                @if($parentCategory->children->isNotEmpty())
                                                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="w-3/4 lg:w-4/5 p-6">
                                                @foreach($tourCategoriesForMenu as $parentCategory)
                                                    <div id="children-{{ $parentCategory->id }}"
                                                         class="mega-menu-children-panel hidden">
                                                        <div
                                                            class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-8 gap-y-6">
                                                            @if($parentCategory->children->isNotEmpty())
                                                                @foreach($parentCategory->children as $childCategory)
                                                                    <div class="space-y-2">
                                                                        <a href="{{ route('client.tours', ['category' => $childCategory->slug]) }}"
                                                                           class="text-sm font-bold text-gray-800 hover:text-[var(--color-primary)] transition-colors block pb-2 border-b border-gray-200">
                                                                            {{ $childCategory->name }}
                                                                        </a>
                                                                        @if($childCategory->children->isNotEmpty())
                                                                            <ul class="space-y-2">
                                                                                @foreach($childCategory->children as $grandChildCategory)
                                                                                    <li>
                                                                                        <a href="{{ route('client.tours', ['category' => $grandChildCategory->slug]) }}"
                                                                                           class="text-sm text-gray-600 hover:text-[var(--color-primary)] transition-colors block">
                                                                                            {{ $grandChildCategory->name }}
                                                                                        </a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div id="mega-menu-placeholder"
                                                     class="text-gray-400 h-full flex items-center justify-center">
                                                    <p>Chọn một danh mục bên trái để khám phá các tour du lịch hấp
                                                        dẫn.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </li>

                    <li><a href="{{ route('client.news') }}"
                           class="block text-base leading-6 font-bold uppercase py-[15px] hover:text-[var(--color-primary)] transition-colors cursor-pointer {{ request()->routeIs('client.news') ? 'text-[var(--color-primary)]' : 'text-[#555]' }}">Tin
                            tức và Sự kiện</a></li>
                    <li><a href="{{ route('client.about') }}"
                           class="block text-base leading-6 font-bold uppercase py-[15px] hover:text-[var(--color-primary)] transition-colors cursor-pointer {{ request()->routeIs('client.about') ? 'text-[var(--color-primary)]' : 'text-[#555]' }}">Giới
                            thiệu</a></li>
                    <li><a href="{{ route('client.contact') }}"
                           class="block text-base leading-6 font-bold uppercase py-[15px] hover:text-[var(--color-primary)] transition-colors cursor-pointer {{ request()->routeIs('client.contact') ? 'text-[var(--color-primary)]' : 'text-[#555]' }}">Liên
                            hệ</a></li>
                </ul>
            </nav>

            <div class="lg:hidden">
                <button id="mobile-menu-button"
                        class="text-gray-700 hover:text-[var(--color-primary)] focus:outline-none" aria-label="Mở menu"
                        aria-expanded="false">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <div id="mobile-menu"
             class="hidden lg:hidden absolute top-full left-0 w-full bg-white shadow-md z-20 transition-all duration-300 ease-in-out max-h-0 overflow-hidden">
            <nav class="container mx-auto px-4 py-4">
                <ul class="flex flex-col gap-y-2">
                    <li><a href="{{ route('client.home') }}"
                           class="block text-base leading-6 font-bold text-[#555] uppercase py-2 hover:text-[var(--color-primary)] transition-colors text-center cursor-pointer {{ request()->routeIs('client.home') ? 'text-[var(--color-primary)]' : 'text-[#555]' }}">Trang
                            chủ</a></li>
                    <li><a href="{{ route('client.tours') }}"
                           class="block text-base leading-6 font-bold text-[#555] uppercase py-2 hover:text-[var(--color-primary)] transition-colors text-center cursor-pointer {{ request()->routeIs('client.tours') ? 'text-[var(--color-primary)]' : 'text-[#555]' }}">Du
                            lịch</a></li>
                    <li><a href="{{ route('client.news') }}"
                           class="block text-base leading-6 font-bold text-[#555] uppercase py-2 hover:text-[var(--color-primary)] transition-colors text-center cursor-pointer {{ request()->routeIs('client.news') ? 'text-[var(--color-primary)]' : 'text-[#555]' }}">Tin
                            tức và Sự kiện</a></li>
                    <li><a href="{{ route('client.about') }}"
                           class="block text-base leading-6 font-bold text-[#555] uppercase py-2 hover:text-[var(--color-primary)] transition-colors text-center cursor-pointer {{ request()->routeIs('client.about') ? 'text-[var(--color-primary)]' : 'text-[#555]' }}">Giới
                            thiệu</a></li>
                    <li><a href="{{ route('client.contact') }}"
                           class="block text-base leading-6 font-bold text-[#555] uppercase py-2 hover:text-[var(--color-primary)] transition-colors text-center cursor-pointer {{ request()->routeIs('client.contact') ? 'text-[var(--color-primary)]' : 'text-[#555]' }}">Liên
                            hệ</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
