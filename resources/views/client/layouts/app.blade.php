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

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">

{{-- This wrapper contains all visible page content --}}
<div id="app-wrapper" class="flex flex-col min-h-screen">
    @include('client.layouts.partials.header')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('client.layouts.partials.footer')
</div>

{{-- Modals should be direct children of body, outside the main wrapper --}}
<x-client.modal id="login-modal" title="Đăng nhập" subtitle="Đăng nhập tài khoản Du Lịch Việt và khám phá niềm vui của bạn ở bất cứ đâu">
    @include('client.auth.partials.login-form')
</x-client.modal>

<x-client.modal id="register-modal" title="Đăng ký" subtitle="Nhận tài khoản Du Lịch Việt và khám phá niềm vui của bạn ở bất cứ đâu">
    @include('client.auth.partials.register-form')
</x-client.modal>

<x-client.modal id="forgot-password-modal" title="Quên mật khẩu" subtitle="Nhập email của bạn để nhận mật khẩu mới từ hệ thống Du Lịch Việt">
    @include('client.auth.partials.forgot-password-form')
</x-client.modal>

@stack('scripts')
</body>
</html>
