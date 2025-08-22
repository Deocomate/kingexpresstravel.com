<div class="sticky top-36 space-y-6">
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-md">
        <div class="space-y-3 text-sm text-gray-700">
            <p><i class="fa-regular fa-clock w-5 text-gray-500"></i> Thời gian:
                <strong>{{ $tour->duration ?? 'N/A' }}</strong></p>
            <p><i class="fa-regular fa-calendar-check w-5 text-gray-500"></i> Khởi hành: <strong>Hàng ngày</strong></p>
            <p><i class="fa-solid fa-car w-5 text-gray-500"></i> Vận chuyển:
                <strong>{{ $tour->transport_mode ?? 'N/A' }}</strong></p>
            <p><i class="fa-solid fa-map-pin w-5 text-gray-500"></i> Xuất phát:
                <strong>{{ $tour->departure_point ?? 'N/A' }}</strong></p>

            @if(isset($tour->destinations) && !$tour->destinations->isEmpty())
                <div>
                    <p class="flex items-start">
                        <i class="fa-solid fa-route w-5 text-gray-500 mt-1"></i>
                        <span class="flex-1">Điểm đến:
                            <strong>{{ $tour->destinations->pluck('name')->join(' - ') }}</strong>
                        </span>
                    </p>
                </div>
            @endif
        </div>
        <div class="mt-5 text-center">
            <p class="text-sm text-gray-600">Giá chỉ từ</p>
            <p class="text-3xl font-extrabold text-red-600">{{ number_format($tour->price_adult ?? 0) }} đ</p>
            <p class="text-xs text-gray-500">/ khách</p>
        </div>
        <div class="mt-5">
            <button
                class="w-full bg-[var(--color-primary)] text-white font-bold py-3 px-4 rounded-lg hover:bg-[var(--color-primary-dark)] transition-colors uppercase">
                Đặt ngay
            </button>
        </div>
    </div>
</div>
