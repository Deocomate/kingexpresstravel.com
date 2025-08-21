@extends('client.layouts.app')

@section('title', 'Liên hệ - King Express Travel')
@section('description', 'Liên hệ với King Express Travel để được tư vấn và hỗ trợ về các tour du lịch. Chúng tôi luôn sẵn sàng lắng nghe và giải đáp mọi thắc mắc của bạn.')

@section('content')
    <div class="py-6 md:py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <h1 class="text-3xl font-bold text-gray-800">Thông tin liên hệ</h1>
                    <p class="mt-2 text-gray-600">
                        Nếu quý khách có thắc mắc hay đóng góp xin vui lòng điền vào Form dưới đây và gửi cho chúng tôi. Xin chân thành cảm ơn!
                    </p>

                    <form action="{{ route('client.contact.submit') }}" method="POST" class="mt-6 space-y-4">
                        @csrf
                        <div>
                            <label for="service_type" class="block text-sm font-medium text-gray-700">Loại dịch vụ</label>
                            <select id="service_type" name="service_type" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                <option>Liên hệ thông tin Tour Trong Nước</option>
                                <option>Liên hệ thông tin Tour Nước Ngoài</option>
                                <option>Góp ý chất lượng dịch vụ</option>
                                <option>Dịch vụ khác</option>
                            </select>
                        </div>

                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700">Họ tên (*)</label>
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name', auth()->user()->name ?? '') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email (*)</label>
                                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email ?? '') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Điện thoại (*)</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                            </div>
                        </div>

                        <div>
                            <label for="note" class="block text-sm font-medium text-gray-700">Ghi chú</label>
                            <input type="text" name="note" id="note" value="{{ old('note') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Nội dung (*)</label>
                            <textarea name="message" id="message" rows="5" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">{{ old('message') }}</textarea>
                        </div>

                        <div class="text-left">
                            <button type="submit" class="w-auto hover:cursor-pointer text-center bg-[var(--color-primary-accent)] text-white font-bold py-3 px-10 rounded-md hover:bg-[var(--color-primary)] transition-colors uppercase">
                                Gửi
                            </button>
                        </div>
                    </form>
                </div>

                <div class="space-y-6 text-sm text-gray-700">
                    @if($contactInfo)
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="font-bold text-base text-[var(--color-primary-dark)] uppercase">{{ $contactInfo->company_name ?? 'Thông tin công ty' }}</h3>
                            <div class="mt-4 space-y-2">
                                <p><i class="fa-solid fa-phone w-5 text-center mr-2 text-gray-500"></i><strong>Điện thoại:</strong> {{ $contactInfo->phone }}</p>
                                <p><i class="fa-solid fa-envelope w-5 text-center mr-2 text-gray-500"></i><strong>Email:</strong> {{ $contactInfo->email }}</p>
                            </div>
                        </div>

                        @foreach($contactInfo->branches as $branch)
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="font-bold text-base text-[var(--color-primary-dark)] uppercase flex items-center gap-x-2">
                                    <span>{{ $branch->branch_name }}</span>
                                    @if($branch->is_main)
                                        <span class="text-xs font-semibold text-white bg-[var(--color-primary)] px-2 py-0.5 rounded-full">Trụ sở chính</span>
                                    @endif
                                </h3>
                                <div class="mt-4 space-y-2">
                                    @if($branch->address)
                                        <p><i class="fa-solid fa-location-dot w-5 text-center mr-2 text-gray-500"></i><strong>Địa chỉ:</strong> {{ $branch->address }}</p>
                                    @endif
                                    @if($branch->phone)
                                        <p><i class="fa-solid fa-phone w-5 text-center mr-2 text-gray-500"></i><strong>Điện thoại:</strong> {{ $branch->phone }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="font-bold text-base text-[var(--color-primary-dark)] uppercase">Bạn cần trợ giúp?</h3>
                            <div class="mt-4 space-y-2">
                                @if($contactInfo->phone)
                                    <p><i class="fa-solid fa-headphones-simple w-5 text-center mr-2 text-gray-500"></i><strong>Hotline:</strong> {{ $contactInfo->phone }}</p>
                                @endif
                                @if($contactInfo->zalo)
                                    <p><i class="fa-solid fa-comment-dots w-5 text-center mr-2 text-gray-500"></i><strong>Zalo:</strong> {{ $contactInfo->zalo }}</p>
                                @endif
                                @if($contactInfo->email)
                                    <p><i class="fa-solid fa-envelope w-5 text-center mr-2 text-gray-500"></i><strong>Email:</strong> {{ $contactInfo->email }}</p>
                                @endif
                                @if($contactInfo->working_hours)
                                    <p><i class="fa-regular fa-clock w-5 text-center mr-2 text-gray-500"></i><strong>Thời gian:</strong> {{ $contactInfo->working_hours }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <p class="text-gray-500">Thông tin liên hệ đang được cập nhật.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
