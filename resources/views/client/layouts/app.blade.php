<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <meta name="description"
          content="@yield('description', 'King Express Travel - Khám phá niềm vui của bạn ở bất cứ đâu.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;700;800&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Mulish', 'ui-sans-serif', 'system-ui', 'sans-serif', 'Apple Color Emoji', 'Segoe UI Emoji',
                            'Segoe UI Symbol', 'Noto Color Emoji'],
                    },
                    colors: {
                        primary: '#f59e0b',
                        'primary-dark': '#d97706',
                        'primary-accent': '#fbbf24',
                        'primary-light': '#fffbeb',
                        'primary-subtle-hover': '#fef3c7',
                        'text-on-primary': '#ffffff',
                    },
                },
            },
        };
    </script>

    <style>
        :root {
            --font-sans: 'Mulish', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol',
            'Noto Color Emoji';

            --color-primary: #f59e0b;
            --color-primary-dark: #d97706;
            --color-primary-accent: #fbbf24;
            --color-primary-light: #fffbeb;
            --color-primary-subtle-hover: #fef3c7;
            --color-text-on-primary: #ffffff;
        }

        /* Prevent horizontal scroll */
        html, body {
            overflow-x: hidden;
            width: 100%;
        }

        body {
            font-family: var(--font-sans);
        }

        .custom-toast.swal2-popup {
            font-size: 0.875rem;
            padding: 0.75rem 1.25rem;
        }

        .custom-toast .swal2-title {
            font-size: 1em;
        }

        .custom-toast .swal2-icon {
            width: 1.25em;
            height: 1.25em;
            margin: 0 0.5em 0 0;
        }

        .custom-toast .swal2-icon .swal2-icon-content {
            font-size: 1em;
        }

        /* General slider arrow style */
        .slider-nav-btn,
        .main-carousel-nav-btn {
            color: var(--color-primary);
            background: #fff;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
            transition: opacity .3s, transform .25s;
        }

        .slider-nav-btn:after,
        .main-carousel-nav-btn:after {
            font-size: 18px;
            font-weight: 600;
        }

        .slider-nav-btn:hover,
        .main-carousel-nav-btn:hover {
            transform: scale(1.05);
        }

        .swiper-button-disabled {
            opacity: 0;
            pointer-events: none;
        }

        /* [IMPROVED] Header Navigation Styles */
        .main-nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .main-nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--color-primary);
            transform-origin: bottom right;
            transition: transform 0.3s ease-out;
        }

        .main-nav-link:hover::after,
        .main-nav-link.active::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        /* [IMPROVED] Mega Menu Animation & Style */
        .mega-menu-wrapper {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: opacity 0.2s ease-out, transform 0.2s ease-out, visibility 0s linear 0.2s;
            pointer-events: none;
        }

        .group:hover .mega-menu-wrapper {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            transition: opacity 0.2s ease-out, transform 0.2s ease-out, visibility 0s linear 0s;
            pointer-events: auto;
        }

        .mega-menu-parent-item.active {
            background-color: #ffffff;
            color: var(--color-primary-dark);
            font-weight: 700;
            border-right: 3px solid var(--color-primary);
        }

        .mega-menu-parent-item:not(.active) {
            border-right: 3px solid transparent;
        }

        .mega-menu-children-panel {
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(5px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">

<div id="app-wrapper" class="flex flex-col min-h-screen">
    @include('client.layouts.partials.header')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('client.layouts.partials.footer')
</div>

<!-- Auth Modals -->
<x-client.modal id="login-modal" title="Đăng nhập"
                subtitle="Đăng nhập tài khoản Du Lịch Việt và khám phá niềm vui của bạn ở bất cứ đâu">
    @include('client.auth.partials.login-form')
</x-client.modal>
<x-client.modal id="register-modal" title="Đăng ký"
                subtitle="Nhận tài khoản Du Lịch Việt và khám phá niềm vui của bạn ở bất cứ đâu">
    @include('client.auth.partials.register-form')
</x-client.modal>
<x-client.modal id="forgot-password-modal" title="Quên mật khẩu"
                subtitle="Nhập email của bạn để nhận mật khẩu mới từ hệ thống Du Lịch Việt">
    @include('client.auth.partials.forgot-password-form')
</x-client.modal>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
<script src="{{ asset('js/client-app.js') }}" defer></script>

@stack('scripts')

<script>
    document.addEventListener('DOMContentLoaded', () => {
        AOS.init({duration: 800, once: true});

        @if (session('registration_error') && $errors->any())
        window.openModal('register-modal');
        @elseif ($errors->any())
        window.openModal('login-modal');
        @endif

        @if (session('success'))
        window.showSuccessToast(@json(session('success')));
        @endif

        @if (session('error'))
        window.showErrorToast(@json(session('error')));
        @endif
    });
</script>

</body>
</html>
