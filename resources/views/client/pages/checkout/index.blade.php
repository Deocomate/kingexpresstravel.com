@extends('client.layouts.app')

@section('title', 'Thanh toán - ' . ($tour->name ?? ''))
@section('description', 'Hoàn tất thông tin đặt tour ' . ($tour->name ?? '') . ' và sẵn sàng cho chuyến đi của bạn.')

@section('content')
    <div class="bg-gray-100 py-6 md:py-10">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 uppercase text-center mb-8">Thanh toán & Đặt tour</h1>

            <form action="{{ route('client.checkout.store', $tour) }}" method="POST" id="checkout-form">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div class="lg:col-span-7 space-y-8">
                        <div class="bg-white p-6 md:p-8 rounded-lg shadow-sm border border-gray-200">
                            <h2 class="text-xl font-bold text-gray-800 mb-6">Thông tin liên hệ</h2>

                            @if (session('error'))
                                <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="space-y-4">
                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-gray-700">Họ và tên (*)</label>
                                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $user->name ?? '') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email (*)</label>
                                        <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700">Điện thoại (*)</label>
                                        <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone ?? '') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                    </div>
                                </div>
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                                    <input type="text" name="address" id="address" value="{{ old('address', $user->address ?? '') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                </div>
                                <div>
                                    <label for="note" class="block text-sm font-medium text-gray-700">Ghi chú thêm</label>
                                    <textarea name="note" id="note" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">{{ old('note') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 md:p-8 rounded-lg shadow-sm border border-gray-200">
                            <h2 class="text-xl font-bold text-gray-800 mb-6">Phương thức thanh toán</h2>
                            <div class="space-y-4">
                                <label for="payment_office" class="flex items-center p-4 border rounded-lg cursor-pointer has-[:checked]:bg-[var(--color-primary-light)] has-[:checked]:border-[var(--color-primary)]">
                                    <input type="radio" id="payment_office" name="payment_method" value="office" class="h-4 w-4 text-[var(--color-primary)] border-gray-300 focus:ring-[var(--color-primary-accent)]" checked>
                                    <span class="ml-3 flex flex-col">
                                        <span class="font-semibold text-gray-800">Thanh toán tại văn phòng</span>
                                        <span class="text-sm text-gray-500">Quý khách vui lòng đến văn phòng King Express Travel để hoàn tất thanh toán.</span>
                                    </span>
                                </label>
                                <label for="payment_vnpay" class="flex items-center p-4 border rounded-lg cursor-pointer has-[:checked]:bg-[var(--color-primary-light)] has-[:checked]:border-[var(--color-primary)]">
                                    <input type="radio" id="payment_vnpay" name="payment_method" value="vnpay" class="h-4 w-4 text-[var(--color-primary)] border-gray-300 focus:ring-[var(--color-primary-accent)]">
                                    <span class="ml-3 flex flex-col">
                                        <span class="font-semibold text-gray-800">Thanh toán qua VNPAY</span>
                                        <span class="text-sm text-gray-500">Thanh toán an toàn, tiện lợi qua cổng VNPAY (Thẻ ATM, Visa, Master, QR Code).</span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-5">
                        <div class="sticky top-28 space-y-6">
                            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                                <h2 class="text-xl font-bold text-gray-800 mb-4">Thông tin tour</h2>
                                <div class="flex items-start gap-x-4">
                                    <img src="{{ $tour->thumbnail ?? 'https://placehold.co/120x90' }}" alt="{{ $tour->name }}" class="w-32 h-24 object-cover rounded-md flex-shrink-0">
                                    <div>
                                        <h3 class="font-bold text-gray-800 leading-tight">{{ $tour->name }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">Mã tour: {{ $tour->tour_code }}</p>
                                    </div>
                                </div>
                                <div class="mt-4 space-y-2 text-sm text-gray-700 border-t pt-4">
                                    <p><i class="fa-regular fa-clock w-5 text-gray-500"></i> Thời gian: <strong>{{ $tour->duration ?? 'N/A' }}</strong></p>
                                    <p><i class="fa-solid fa-map-pin w-5 text-gray-500"></i> Nơi khởi hành: <strong>{{ $tour->departure_point ?? 'N/A' }}</strong></p>
                                    <p><i class="fa-solid fa-route w-5 text-gray-500"></i> Điểm đến: <strong>{{ $tour->destinations->pluck('name')->join(', ') ?: 'N/A' }}</strong></p>
                                    <p><i class="fa-solid fa-users w-5 text-gray-500"></i> Số chỗ còn nhận: <strong>{{ $tour->remaining_slots ?? 'N/A' }}</strong></p>
                                </div>
                                <div class="mt-4">
                                    <label for="departure_date" class="block text-sm font-medium text-gray-700">Ngày khởi hành (*)</label>
                                    <input type="date" name="departure_date" id="departure_date" value="{{ old('departure_date', now()->addWeek()->format('Y-m-d')) }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                </div>
                            </div>

                            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                                <h2 class="text-xl font-bold text-gray-800 mb-4">Số lượng hành khách</h2>
                                <div class="space-y-3" id="quantity-section">
                                    @php
                                        $prices = [
                                            'adult' => ['label' => 'Người lớn (>11 tuổi)', 'price' => $tour->price_adult ?? 0],
                                            'child' => ['label' => 'Trẻ em (5-11 tuổi)', 'price' => $tour->price_child ?? 0],
                                            'toddler' => ['label' => 'Trẻ nhỏ (2-5 tuổi)', 'price' => $tour->price_toddler ?? 0],
                                            'infant' => ['label' => 'Em bé (<2 tuổi)', 'price' => $tour->price_infant ?? 0],
                                        ];
                                    @endphp

                                    @foreach($prices as $key => $details)
                                        <div class="flex justify-between items-center" data-price="{{ $details['price'] }}">
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $details['label'] }}</p>
                                                <p class="text-sm text-red-600 font-semibold">{{ number_format($details['price']) }} đ</p>
                                            </div>
                                            <div class="flex items-center gap-x-2">
                                                <button type="button" class="quantity-btn minus-btn w-8 h-8 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100">-</button>
                                                <input type="number" name="{{ $key }}_quantity" value="{{ old($key.'_quantity', $key === 'adult' ? 1 : 0) }}" min="0" class="quantity-input w-12 text-center border-gray-300 rounded-md focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                                <button type="button" class="quantity-btn plus-btn w-8 h-8 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100">+</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-6 border-t pt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-semibold text-gray-800">Tổng cộng</span>
                                        <span id="total-price" class="text-2xl font-extrabold text-red-600">0 đ</span>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <button type="submit" class="w-full hover:cursor-pointer text-center bg-[var(--color-primary)] text-white font-bold py-3 px-4 rounded-lg hover:bg-[var(--color-primary-dark)] transition-colors uppercase">
                                        Hoàn tất đặt tour
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quantitySection = document.getElementById('quantity-section');
            const totalPriceEl = document.getElementById('total-price');
            const departureDateInput = document.getElementById('departure_date');

            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            departureDateInput.min = `${yyyy}-${mm}-${dd}`;


            function calculateTotal() {
                let total = 0;
                quantitySection.querySelectorAll('[data-price]').forEach(item => {
                    const price = parseFloat(item.dataset.price) || 0;
                    const quantity = parseInt(item.querySelector('.quantity-input').value) || 0;
                    total += price * quantity;
                });
                totalPriceEl.textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total);
            }

            quantitySection.addEventListener('click', function (e) {
                const target = e.target;
                if (target.classList.contains('quantity-btn')) {
                    const input = target.parentElement.querySelector('.quantity-input');
                    let value = parseInt(input.value);

                    if (target.classList.contains('plus-btn')) {
                        value++;
                    } else if (target.classList.contains('minus-btn')) {
                        value = Math.max(0, value - 1);
                    }

                    if (input.name === 'adult_quantity') {
                        value = Math.max(1, value);
                    }

                    input.value = value;
                    calculateTotal();
                }
            });

            quantitySection.addEventListener('input', function(e) {
                if (e.target.classList.contains('quantity-input')) {
                    if (e.target.name === 'adult_quantity' && parseInt(e.target.value) < 1) {
                        e.target.value = 1;
                    }
                    if (parseInt(e.target.value) < 0) {
                        e.target.value = 0;
                    }
                    calculateTotal();
                }
            });

            calculateTotal();
        });
    </script>
@endpush
