@extends('client.layouts.app')

@section('title', 'Đổi mật khẩu')

@section('content')
    <div class="bg-gray-100 py-6 md:py-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <aside class="lg:col-span-3">
                    @include('client.pages.profile.partials._sidebar', ['user' => $user])
                </aside>

                <div class="lg:col-span-9">
                    <div class="bg-white p-6 md:p-8 rounded-lg shadow-sm border border-gray-200">
                        <h1 class="text-2xl font-bold text-gray-800">Đổi mật khẩu</h1>
                        <p class="mt-1 text-sm text-gray-500">Để đảm bảo an toàn, vui lòng không chia sẻ mật khẩu cho người khác.</p>

                        <form action="{{ route('client.profile.update-password') }}" method="POST" class="mt-6">
                            @csrf
                            @method('PUT')

                            <div class="space-y-5 max-w-md">
                                <div>
                                    <label for="old_password" class="block text-sm font-medium text-gray-700">Mật khẩu cũ (*)</label>
                                    <input type="password" name="old_password" id="old_password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu mới (*)</label>
                                    <input type="password" name="password" id="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Xác nhận mật khẩu mới (*)</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                </div>
                            </div>

                            <div class="mt-8">
                                <button type="submit" class="w-auto hover:cursor-pointer text-center bg-[var(--color-primary-accent)] text-white font-bold py-2.5 px-8 rounded-lg hover:bg-[var(--color-primary)] transition-colors flex items-center">
                                    <i class="fa-solid fa-floppy-disk mr-2"></i>
                                    Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
