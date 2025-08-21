@extends('client.layouts.app')

@section('title', $tour->name ?? 'Chi tiết Tour')
@section('description', $tour->short_description ?? 'Khám phá chi tiết tour du lịch hấp dẫn với lịch trình đầy đủ, dịch vụ bao gồm và những điểm nhấn không thể bỏ lỡ.')

@section('content')
    <div class="bg-white">
        <div class="container mx-auto px-4 py-6 md:py-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-8">
                    <div class="space-y-4">
                        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">{{ $tour->name ?? 'Tên tour đang cập nhật' }}</h1>
                        <div class="flex items-center gap-x-4 text-sm text-gray-500">
                            <span>Mã tour: <strong>{{ $tour->tour_code ?? 'N/A' }}</strong></span>
                            <span class="h-4 border-l border-gray-300"></span>
                            <span>Đánh giá:
                                <span class="text-yellow-500">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-regular fa-star-half-stroke"></i>
                                </span>
                                <strong>4.5/5</strong>
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 rounded-lg overflow-hidden">
                        <img src="{{ $tour->thumbnail ?? 'https://placehold.co/800x500/e2e8f0/e2e8f0?text=King+Express' }}"
                             alt="Ảnh bìa {{ $tour->name ?? '' }}" class="w-full h-auto object-cover">
                    </div>

                    <div class="sticky top-20 z-10 bg-white py-3 border-b border-gray-200 mt-6 hidden md:block">
                        <nav id="tour-nav" class="flex items-center gap-x-6">
                            <a href="#diem-nhan" class="tour-nav-item text-gray-600 font-semibold hover:text-[var(--color-primary)] transition-colors">Điểm nhấn</a>
                            <a href="#lich-trinh" class="tour-nav-item text-gray-600 font-semibold hover:text-[var(--color-primary)] transition-colors">Lịch trình</a>
                            <a href="#dich-vu" class="tour-nav-item text-gray-600 font-semibold hover:text-[var(--color-primary)] transition-colors">Dịch vụ</a>
                            <a href="#hinh-anh" class="tour-nav-item text-gray-600 font-semibold hover:text-[var(--color-primary)] transition-colors">Hình ảnh</a>
                        </nav>
                    </div>

                    <div class="mt-8 space-y-10">
                        <section id="diem-nhan">
                            <h2 class="text-xl font-bold text-gray-800 border-l-4 border-[var(--color-primary)] pl-3 mb-4">ĐIỂM NHẤN HÀNH TRÌNH</h2>
                            <div class="prose max-w-none text-gray-700">
                                {!! $tour->characteristic ?? '<p>Thông tin đang được cập nhật.</p>' !!}
                            </div>
                        </section>

                        <section id="lich-trinh">
                            <h2 class="text-xl font-bold text-gray-800 border-l-4 border-[var(--color-primary)] pl-3 mb-4">LỊCH TRÌNH CHI TIẾT</h2>
                            @if(!empty($tour->tour_schedule) && is_array($tour->tour_schedule))
                                <div class="space-y-6">
                                    @foreach($tour->tour_schedule as $schedule)
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 w-24 text-center">
                                                <div class="bg-[var(--color-primary-light)] text-[var(--color-primary-dark)] font-bold py-2 px-3 rounded-md">
                                                    {{ $schedule['title'] ?? 'Ngày' }}
                                                </div>
                                            </div>
                                            <div class="ml-6 prose max-w-none text-gray-700">
                                                {!! $schedule['content'] ?? '<p>Nội dung đang được cập nhật.</p>' !!}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-600">Lịch trình chi tiết đang được cập nhật. Vui lòng liên hệ để biết thêm thông tin.</p>
                            @endif
                        </section>

                        <section id="dich-vu">
                            <h2 class="text-xl font-bold text-gray-800 border-l-4 border-[var(--color-primary)] pl-3 mb-4">DỊCH VỤ & GHI CHÚ</h2>
                            <div class="prose max-w-none text-gray-700">
                                {!! $tour->services_note ?? '<p>Thông tin đang được cập nhật.</p>' !!}
                            </div>
                        </section>

                        <section id="hinh-anh">
                            <h2 class="text-xl font-bold text-gray-800 border-l-4 border-[var(--color-primary)] pl-3 mb-4">HÌNH ẢNH TOUR</h2>
                            @if(!empty($tour->images) && is_array($tour->images))
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($tour->images as $image)
                                        <a href="{{ $image }}" data-fancybox="gallery">
                                            <img src="{{ $image }}" alt="Hình ảnh tour" class="rounded-lg object-cover w-full h-40 hover:opacity-80 transition-opacity">
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-600">Album ảnh đang được cập nhật.</p>
                            @endif
                        </section>
                    </div>
                </div>

                <aside class="lg:col-span-4">
                    <div class="sticky top-24 space-y-6">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                            <h2 class="text-xl font-bold text-gray-800">{{ $tour->name ?? 'Tên tour' }}</h2>
                            <div class="mt-4 space-y-3 text-sm text-gray-700">
                                <p><i class="fa-solid fa-tag w-5 text-gray-500"></i> Mã tour: <strong>{{ $tour->tour_code ?? 'N/A' }}</strong></p>
                                <p><i class="fa-regular fa-clock w-5 text-gray-500"></i> Thời gian: <strong>{{ $tour->duration ?? 'N/A' }}</strong></p>
                                <p><i class="fa-regular fa-calendar-check w-5 text-gray-500"></i> Khởi hành: <strong>Hàng ngày</strong></p>
                                <p><i class="fa-solid fa-car w-5 text-gray-500"></i> Vận chuyển: <strong>{{ $tour->transport_mode ?? 'N/A' }}</strong></p>
                                <p><i class="fa-solid fa-map-pin w-5 text-gray-500"></i> Xuất phát: <strong>{{ $tour->departure_point ?? 'N/A' }}</strong></p>
                            </div>
                            <div class="mt-5 text-center">
                                <p class="text-sm text-gray-600">Giá chỉ từ</p>
                                <p class="text-3xl font-extrabold text-red-600">{{ number_format($tour->price_adult ?? 0) }} đ</p>
                                <p class="text-xs text-gray-500">/ khách</p>
                            </div>
                            <div class="mt-5">
                                <button class="w-full bg-[var(--color-primary)] text-white font-bold py-3 px-4 rounded-lg hover:bg-[var(--color-primary-dark)] transition-colors uppercase">
                                    Đặt ngay
                                </button>
                            </div>
                        </div>

                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                            <h3 class="font-bold text-gray-800">Bạn cần hỗ trợ?</h3>
                            <p class="text-sm text-gray-600 mt-2">Chúng tôi sẵn sàng hỗ trợ 24/7</p>
                            <div class="mt-4 space-y-2">
                                <a href="tel:19001177" class="flex items-center gap-x-3 text-[var(--color-primary)] hover:text-[var(--color-primary-dark)]">
                                    <i class="fa-solid fa-phone-volume text-xl"></i>
                                    <span class="font-bold text-lg">1900 1177</span>
                                </a>
                                <a href="mailto:info@kingexpresstravel.com.vn" class="flex items-center gap-x-3 text-gray-700 hover:text-[var(--color-primary)]">
                                    <i class="fa-solid fa-envelope text-xl"></i>
                                    <span class="font-semibold">Gửi yêu cầu</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

            @if(isset($relatedTours) && $relatedTours->isNotEmpty())
                <section class="mt-12 md:mt-16">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 uppercase mb-6">Tour tương tự</h2>
                    <div class="relative slider-container">
                        <div class="swiper tour-slider">
                            <div class="swiper-wrapper">
                                @foreach($relatedTours as $relatedTour)
                                    <div class="swiper-slide h-auto">
                                        <x-client.tour-card :tour="$relatedTour"/>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </section>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Fancybox.bind("[data-fancybox]", {});

            const slider = document.querySelector('.slider-container .swiper');
            if(slider) {
                new Swiper(slider, {
                    slidesPerView: 1.15,
                    spaceBetween: 12,
                    navigation: {
                        nextEl: '.slider-container .swiper-button-next',
                        prevEl: '.slider-container .swiper-button-prev',
                    },
                    breakpoints: {
                        640: { slidesPerView: 2.2, spaceBetween: 16 },
                        768: { slidesPerView: 3.2, spaceBetween: 16 },
                        1024: { slidesPerView: 4, spaceBetween: 16 },
                    },
                });
            }

            const navItems = document.querySelectorAll('.tour-nav-item');
            const sections = document.querySelectorAll('section[id]');
            const nav = document.getElementById('tour-nav');
            const navHeight = nav ? nav.offsetHeight : 0;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        navItems.forEach(item => {
                            item.classList.remove('text-[var(--color-primary)]');
                            if (item.getAttribute('href').substring(1) === entry.target.id) {
                                item.classList.add('text-[var(--color-primary)]');
                            }
                        });
                    }
                });
            }, { rootMargin: `-${navHeight + 20}px 0px 0px 0px`, threshold: 0.1 });

            sections.forEach(section => observer.observe(section));

            navItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - (navHeight + 20);
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
@endpush
