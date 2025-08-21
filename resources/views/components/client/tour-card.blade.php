@props(['tour'])

@if($tour)
    <div
        class="bg-white rounded-lg shadow-md overflow-hidden group transition-all duration-300 hover:shadow-xl hover:-translate-y-1 h-full flex flex-col">
        <a href="{{ route('client.tour.show', $tour) }}" title="{{ $tour->name ?? '' }}" class="block flex flex-col flex-grow">
            <div class="relative">
                <img class="w-full h-48 object-cover"
                     src="{{ $tour->thumbnail ?? '/userfiles/images/placeholder.jpg' }}"
                     alt="{{ $tour->name ?? 'Hình ảnh tour' }}" loading="lazy">
                <div
                    class="absolute top-2 left-2 bg-white/90 text-gray-800 text-xs font-semibold px-2 py-1 rounded-md flex items-center gap-x-1">
                    <i class="fa-solid fa-location-dot text-[var(--color-primary)]"></i>
                    <span>{{ $tour->destinations->first()->name ?? 'Nhiều nơi' }}</span>
                </div>
            </div>
            <div class="p-4 flex flex-col flex-grow">
                <h3 class="font-bold text-gray-800 text-base leading-tight h-12 overflow-hidden group-hover:text-[var(--color-primary)] transition-colors [display:-webkit-box] [-webkit-line-clamp:2] [-webkit-box-orient:vertical]">
                    {{ $tour->name ?? 'Tên tour đang được cập nhật' }}
                </h3>
                <div class="mt-3 text-sm text-gray-600 space-y-2 flex-grow">
                    <p><i class="fa-regular fa-clock w-4 mr-1 text-gray-500"></i> Lịch trình:
                        <strong>{{ $tour->duration ?? 'N/A' }}</strong></p>
                    <p><i class="fa-regular fa-calendar-check w-4 mr-1 text-gray-500"></i> Khởi hành: <strong>Liên
                            hệ</strong></p>
                    <p><i class="fa-solid fa-users w-4 mr-1 text-gray-500"></i> Số chỗ còn nhận:
                        <strong>{{ $tour->remaining_slots ?? 'N/A' }}</strong></p>
                </div>
                <div class="mt-4 text-right">
                    <span
                        class="text-xl font-extrabold text-red-600">{{ number_format($tour->price_adult ?? 0) }} đ</span>
                </div>
            </div>
        </a>
    </div>
@endif
