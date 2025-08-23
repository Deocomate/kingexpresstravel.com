@props(['orders'])

@php
    $orderStatusClasses = [
        'PENDING'   => 'bg-yellow-100 text-yellow-800',
        'CONFIRMED' => 'bg-blue-100 text-blue-800',
        'COMPLETED' => 'bg-green-100 text-green-800',
        'CANCELLED' => 'bg-red-100 text-red-800',
    ];
    $orderStatusTexts = [
        'PENDING'   => 'Chờ xử lý',
        'CONFIRMED' => 'Đã xác nhận',
        'COMPLETED' => 'Đã hoàn thành',
        'CANCELLED' => 'Đã hủy',
    ];
    $paymentStatusClasses = [
        'PENDING'   => 'bg-yellow-100 text-yellow-800',
        'SUCCESS'   => 'bg-green-100 text-green-800',
        'FAILED'    => 'bg-red-100 text-red-800',
        'CANCELLED' => 'bg-gray-100 text-gray-800',
    ];
    $paymentStatusTexts = [
        'PENDING'   => 'Chờ thanh toán',
        'SUCCESS'   => 'Đã thanh toán',
        'FAILED'    => 'Thanh toán thất bại',
        'CANCELLED' => 'Đã hủy',
    ];
@endphp

@forelse($orders as $order)
    <div class="border border-gray-200 rounded-lg overflow-hidden animate-fade-in">
        <div class="bg-gray-50 px-4 py-3 flex flex-wrap gap-2 justify-between items-center text-sm">
            <div>
                <span class="font-bold text-gray-800">Mã đơn hàng: #{{ $order->id }}</span>
                <span class="text-gray-500 ml-4">Ngày đặt: {{ optional($order->created_at)->format('d/m/Y') }}</span>
            </div>
            <div class="flex items-center gap-x-2">
                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $orderStatusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $orderStatusTexts[$order->status] ?? $order->status }}
                </span>
                @if($order->payment)
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $paymentStatusClasses[optional($order->payment)->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $paymentStatusTexts[optional($order->payment)->status] ?? optional($order->payment)->status }}
                    </span>
                @endif
            </div>
        </div>
        <div class="p-4">
            <div class="flex flex-col md:flex-row gap-4">
                <img src="{{ optional($order->tour)->thumbnail ?? 'https://placehold.co/150x100/e2e8f0/e2e8f0?text=Tour' }}" alt="{{ optional($order->tour)->name ?? '' }}" class="w-full md:w-36 h-28 object-cover rounded-md flex-shrink-0">
                <div class="flex-grow">
                    <a href="{{ $order->tour ? route('client.tour.show', $order->tour) : '#' }}" class="font-bold text-gray-800 hover:text-[var(--color-primary)] transition-colors">
                        {{ optional($order->tour)->name ?? '[Tour đã bị xóa]' }}
                    </a>
                    <div class="mt-2 text-sm text-gray-600 space-y-1">
                        <p><i class="fa-regular fa-calendar-days w-5 text-gray-500"></i>Ngày đi: <strong>{{ optional($order->departure_date)->format('d/m/Y') ?? 'N/A' }}</strong></p>
                        <p><i class="fa-solid fa-users w-5 text-gray-500"></i>Hành khách: <strong>{{ $order->adult_quantity }}</strong> người lớn, <strong>{{ $order->child_quantity }}</strong> trẻ em</p>
                        @if(optional($order->payment)->status === 'SUCCESS' && optional($order->payment)->paid_at)
                            <p class="text-green-700"><i class="fa-solid fa-clock w-5 text-gray-500"></i>Thanh toán lúc: <strong>{{ optional(optional($order->payment)->paid_at)->format('d/m/Y H:i') }}</strong></p>
                        @endif
                    </div>
                </div>
                <div class="text-left md:text-right flex-shrink-0">
                    <p class="text-sm text-gray-600">Tổng tiền</p>
                    <p class="text-xl font-bold text-red-600">{{ number_format($order->total_price ?? 0) }} đ</p>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200 bg-white px-4 py-3 flex justify-end items-center">
            @if($order->status === 'PENDING' && optional($order->payment)->status !== 'SUCCESS')
                <button type="button"
                        data-modal-target="cancel-order-modal"
                        data-action-url="{{ route('client.order.cancel', $order) }}"
                        class="cancel-order-button inline-block bg-red-100 text-red-700 font-bold py-2 px-4 rounded-lg hover:bg-red-200 transition-colors text-sm">
                    Hủy tour
                </button>
            @endif
        </div>
    </div>
@empty
    @if(!request()->ajax())
        <div class="text-center py-12">
            <i class="fa-solid fa-receipt text-6xl text-gray-300"></i>
            <p class="mt-4 text-gray-500">Bạn chưa đặt tour nào.</p>
            <a href="{{ route('client.tours') }}" class="mt-4 inline-block bg-[var(--color-primary)] text-white font-bold py-2 px-6 rounded-lg hover:bg-[var(--color-primary-dark)] transition-colors">
                Khám phá ngay
            </a>
        </div>
    @endif
@endforelse
