@extends('client.layouts.app')

@section('title', $tour->name ?? 'Chi tiết Tour')
@section('description', $tour->short_description ?? 'Khám phá chi tiết tour du lịch hấp dẫn với lịch trình đầy đủ, dịch vụ bao gồm và những điểm nhấn không thể bỏ lỡ.')

@push('styles')
    <style>
        .gallery-top {
            height: 500px;
            width: 100%;
        }
        .gallery-thumbs {
            height: 100px;
            box-sizing: border-box;
            padding: 10px 0;
        }
        .gallery-thumbs .swiper-slide {
            width: 25%;
            height: 100%;
            opacity: 0.5;
            cursor: pointer;
            transition: opacity 0.3s;
        }
        .gallery-thumbs .swiper-slide:hover {
            opacity: 0.8;
        }
        .gallery-thumbs .swiper-slide-thumb-active {
            opacity: 1;
            border: 2px solid var(--color-primary);
        }
        .tour-price-table th, .tour-price-table td {
            border: 1px solid #e5e7eb;
            padding: 0.75rem 1rem;
            text-align: center;
        }
        .tour-price-table th {
            background-color: #f9fafb;
            font-weight: bold;
        }
        .tour-price-table td:first-child {
            text-align: left;
        }
        .schedule-content .prose-styles ul {
            list-style-type: disc;
            padding-left: 20px;
            margin-top: 1em;
            margin-bottom: 1em;
        }
        .schedule-content .prose-styles ol {
            list-style-type: decimal;
            padding-left: 20px;
            margin-top: 1em;
            margin-bottom: 1em;
        }
        .schedule-content .prose-styles p {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
        }
        .schedule-content .prose-styles h1,
        .schedule-content .prose-styles h2,
        .schedule-content .prose-styles h3,
        .schedule-content .prose-styles h4 {
            font-weight: bold;
            margin-top: 1.2em;
            margin-bottom: 0.6em;
        }
    </style>
@endpush

@section('content')
    <div class="bg-white">
        <div class="container mx-auto px-4 py-6 md:py-10">
            <div class="mb-4">
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">{{ $tour->name ?? 'Tên tour đang cập nhật' }}</h1>
                <div class="flex items-center gap-x-4 text-sm text-gray-500 mt-2">
                    <span>Mã tour: <strong>{{ $tour->tour_code ?? 'N/A' }}</strong></span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-8">
                    @php
                        $allImages = collect([$tour->thumbnail])->concat($tour->images ?? [])->filter()->unique()->values();
                    @endphp

                    @if($allImages->isNotEmpty())
                        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper gallery-top rounded-lg shadow-md">
                            <div class="swiper-wrapper">
                                @foreach($allImages as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ $image }}" alt="Ảnh tour {{ $tour->name }}" class="w-full h-full object-cover"/>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        <div thumbsSlider="" class="swiper gallery-thumbs mt-2">
                            <div class="swiper-wrapper">
                                @foreach($allImages as $image)
                                    <div class="swiper-slide rounded-md overflow-hidden">
                                        <img src="{{ $image }}" alt="Thumbnail tour {{ $tour->name }}" class="w-full h-full object-cover"/>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="rounded-lg overflow-hidden shadow-md">
                            <img src="https://placehold.co/800x500/e2e8f0/e2e8f0?text=King+Express" alt="Ảnh bìa {{ $tour->name ?? '' }}" class="w-full h-auto object-cover">
                        </div>
                    @endif

                    <div class="mt-8 space-y-12">
                        @if($tour->short_description)
                            <section id="mo-ta-ngan">
                                <div class="prose max-w-none text-gray-700 font-semibold italic text-base">
                                    {!! $tour->short_description !!}
                                </div>
                            </section>
                        @endif

                        @if($tour->tour_description)
                            <section id="mo-ta-tour">
                                <h2 class="text-xl font-bold text-gray-800 border-l-4 border-[var(--color-primary)] pl-3 mb-4">MÔ TẢ TOUR</h2>
                                <div class="prose max-w-none text-gray-700">
                                    {!! $tour->tour_description !!}
                                </div>
                            </section>
                        @endif

                        @if($tour->characteristic)
                            <section id="diem-nhan">
                                <h2 class="text-xl font-bold text-gray-800 border-l-4 border-[var(--color-primary)] pl-3 mb-4">ĐIỂM NHẤN HÀNH TRÌNH</h2>
                                <div class="prose max-w-none text-gray-700">
                                    {!! $tour->characteristic !!}
                                </div>
                            </section>
                        @endif

                        <section id="lich-trinh">
                            <div class="flex items-center mb-6">
                                <i class="fa-solid fa-book-open text-2xl text-[var(--color-primary)] mr-3"></i>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800">Lịch trình</h2>
                                    <p class="text-xs text-gray-500">Cập nhật {{ optional($tour->updated_at)->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            @if(!empty($tour->tour_schedule) && is_array($tour->tour_schedule))
                                <div class="relative border-l-2 border-dashed border-gray-300 ml-4">
                                    <div class="space-y-4">
                                        @foreach($tour->tour_schedule as $schedule)
                                            <div class="schedule-item relative">
                                                <div class="absolute -left-[25px] top-2 w-10 h-10 flex items-center justify-center z-10">
                                                    <div class="schedule-circle w-6 h-6 rounded-full bg-white border-2 border-[var(--color-primary)] flex items-center justify-center transition-all duration-300 border-4">
                                                        <div class="w-2 h-2 rounded-full bg-[var(--color-primary)]"></div>
                                                    </div>
                                                </div>
                                                <div class="ml-8">
                                                    <button type="button" class="schedule-toggle flex justify-between items-center w-full text-left p-2 hover:cursor-pointer rounded-lg bg-[var(--color-primary)] text-white focus:outline-none transition-colors duration-300 hover:bg-[var(--color-primary-dark)]">
                                                        <h3 class="text-base font-bold">{{ $schedule['title'] ?? 'Chi tiết' }}</h3>
                                                        <span class="schedule-icon transform transition-transform duration-300 rotate-180">
                                                            <i class="fa-solid fa-chevron-down text-sm"></i>
                                                        </span>
                                                    </button>
                                                    <div class="schedule-content overflow-hidden transition-all duration-300 ease-in-out">
                                                        <div class="prose-styles pt-4 bg-gray-50 p-4 mt-[-8px] rounded-b-lg border border-t-0 border-gray-200">
                                                            {!! $schedule['content'] ?? '<p>Nội dung đang được cập nhật.</p>' !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-600">Lịch trình chi tiết đang được cập nhật. Vui lòng liên hệ để biết thêm thông tin.</p>
                            @endif
                        </section>

                        <section id="bang-gia">
                            <h2 class="text-xl font-bold text-gray-800 border-l-4 border-[var(--color-primary)] pl-3 mb-4">BẢNG GIÁ TOUR CHI TIẾT</h2>
                            <div class="overflow-x-auto">
                                <table class="w-full min-w-full tour-price-table">
                                    <thead>
                                    <tr>
                                        <th>Loại giá/Độ tuổi</th>
                                        <th>Người lớn (Trên 11 tuổi)</th>
                                        <th>Trẻ em (5 - 11 tuổi)</th>
                                        <th>Trẻ nhỏ (2 - 5 tuổi)</th>
                                        <th>Sơ sinh (< 2 tuổi)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="font-semibold">Giá</td>
                                        <td class="font-semibold text-red-600">{{ $tour->price_adult ? number_format($tour->price_adult) . ' đ' : 'Liên hệ' }}</td>
                                        <td class="font-semibold text-red-600">{{ $tour->price_child ? number_format($tour->price_child) . ' đ' : 'Liên hệ' }}</td>
                                        <td class="font-semibold text-red-600">{{ $tour->price_toddler ? number_format($tour->price_toddler) . ' đ' : 'Liên hệ' }}</td>
                                        <td class="font-semibold text-red-600">{{ $tour->price_infant ? number_format($tour->price_infant) . ' đ' : 'Liên hệ' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        @if($tour->services_note)
                            <section id="dich-vu">
                                <h2 class="text-xl font-bold text-gray-800 border-l-4 border-[var(--color-primary)] pl-3 mb-4">DỊCH VỤ & GHI CHÚ</h2>
                                <div class="prose max-w-none text-gray-700">
                                    {!! $tour->services_note !!}
                                </div>
                            </section>
                        @endif
                    </div>
                </div>

                <aside class="lg:col-span-4">
                    <div class="sticky top-36 space-y-6">
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-md">
                            <div class="space-y-3 text-sm text-gray-700">
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

                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-md">
                            <nav id="tour-nav" class="flex flex-col space-y-2">
                                @if($tour->tour_description)<a href="#mo-ta-tour" class="tour-nav-item text-gray-600 font-semibold hover:text-[var(--color-primary)] transition-colors">Mô tả Tour</a>@endif
                                @if($tour->characteristic)<a href="#diem-nhan" class="tour-nav-item text-gray-600 font-semibold hover:text-[var(--color-primary)] transition-colors">Điểm nhấn hành trình</a>@endif
                                @if(!empty($tour->tour_schedule))<a href="#lich-trinh" class="tour-nav-item text-gray-600 font-semibold hover:text-[var(--color-primary)] transition-colors">Lịch trình chi tiết</a>@endif
                                <a href="#bang-gia" class="tour-nav-item text-gray-600 font-semibold hover:text-[var(--color-primary)] transition-colors">Bảng giá chi tiết</a>
                                @if($tour->services_note)<a href="#dich-vu" class="tour-nav-item text-gray-600 font-semibold hover:text-[var(--color-primary)] transition-colors">Dịch vụ</a>@endif
                            </nav>
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

            const galleryThumbs = new Swiper('.gallery-thumbs', {
                spaceBetween: 10,
                slidesPerView: 5,
                freeMode: true,
                watchSlidesProgress: true,
                breakpoints: {
                    320: { slidesPerView: 3.5, spaceBetween: 8 },
                    640: { slidesPerView: 5, spaceBetween: 10 },
                }
            });

            const galleryTop = new Swiper('.gallery-top', {
                spaceBetween: 10,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                thumbs: {
                    swiper: galleryThumbs,
                },
            });

            const relatedTourSlider = document.querySelector('.slider-container .swiper.tour-slider');
            if(relatedTourSlider) {
                new Swiper(relatedTourSlider, {
                    slidesPerView: 1.15,
                    spaceBetween: 12,
                    navigation: {
                        nextEl: '.slider-container .swiper-button-next',
                        prevEl: '.slider-container .swiper-button-prev',
                    },
                    breakpoints: {
                        640: { slidesPerView: 2.2, spaceBetween: 16 },
                        768: { slidesPerView: 3, spaceBetween: 16 },
                    },
                });
            }

            const navItems = document.querySelectorAll('.tour-nav-item');
            const sections = document.querySelectorAll('section[id]');
            const header = document.querySelector('header');
            const headerHeight = header ? header.offsetHeight : 0;

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
            }, { rootMargin: `-${headerHeight + 25}px 0px -50% 0px`, threshold: 0 });

            sections.forEach(section => observer.observe(section));

            navItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - (headerHeight + 24);
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            const scheduleItems = document.querySelectorAll('.schedule-item');

            scheduleItems.forEach(item => {
                const content = item.querySelector('.schedule-content');
                if (content) {
                    content.style.maxHeight = content.scrollHeight + 'px';
                }
            });

            scheduleItems.forEach(item => {
                const toggle = item.querySelector('.schedule-toggle');
                if (toggle) {
                    toggle.addEventListener('click', () => {
                        const content = item.querySelector('.schedule-content');
                        const icon = item.querySelector('.schedule-icon');
                        const circle = item.querySelector('.schedule-circle');

                        if (!content) return;

                        const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';

                        if (isOpen) {
                            content.style.maxHeight = '0px';
                            if (icon) icon.classList.remove('rotate-180');
                            if (circle) circle.classList.remove('border-4');
                        } else {
                            content.style.maxHeight = content.scrollHeight + 'px';
                            if (icon) icon.classList.add('rotate-180');
                            if (circle) circle.classList.add('border-4');
                        }
                    });
                }
            });
        });
    </script>
@endpush
