<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <meta name="description" content="@yield('description', 'King Express Travel - Khám phá niềm vui của bạn ở bất cứ đâu.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
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
        .slider-container .swiper-button-next,
        .slider-container .swiper-button-prev {
            color: var(--color-primary);
            background-color: white;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            transition: opacity 0.3s;
        }
        .slider-container .swiper-button-next:after,
        .slider-container .swiper-button-prev:after {
            font-size: 18px;
            font-weight: bold;
        }
        .slider-container .swiper-button-prev {
            left: -22px;
        }
        .slider-container .swiper-button-next {
            right: -22px;
        }
        .swiper-button-disabled {
            opacity: 0;
            cursor: auto;
            pointer-events: none;
        }
        .main-carousel .swiper-button-prev {
            left: 20px;
        }
        .main-carousel .swiper-button-next {
            right: 20px;
        }
        @media (max-width: 768px) {
            .slider-container .swiper-button-prev,
            .slider-container .swiper-button-next {
                display: none;
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

<x-client.modal id="login-modal" title="Đăng nhập" subtitle="Đăng nhập tài khoản Du Lịch Việt và khám phá niềm vui của bạn ở bất cứ đâu">
    @include('client.auth.partials.login-form')
</x-client.modal>

<x-client.modal id="register-modal" title="Đăng ký" subtitle="Nhận tài khoản Du Lịch Việt và khám phá niềm vui của bạn ở bất cứ đâu">
    @include('client.auth.partials.register-form')
</x-client.modal>

<x-client.modal id="forgot-password-modal" title="Quên mật khẩu" subtitle="Nhập email của bạn để nhận mật khẩu mới từ hệ thống Du Lịch Việt">
    @include('client.auth.partials.forgot-password-form')
</x-client.modal>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@stack('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('registration_error') && $errors->any())
        window.openModal('register-modal');
        @elseif ($errors->any())
        window.openModal('login-modal');
        @endif

        @if (session('success'))
        window.showSuccessToast("{{ session('success') }}");
        @endif

        @if (session('error'))
        window.showErrorToast("{{ session('error') }}");
        @endif
    });
</script>

</body>
</html>
