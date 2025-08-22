@extends('client.layouts.app')

@section('title', $tour->name ?? 'Chi tiết Tour')
@section('description', $tour->short_description ?? 'Khám phá chi tiết tour du lịch hấp dẫn với lịch trình đầy đủ, dịch vụ bao gồm và những điểm nhấn không thể bỏ lỡ.')

@push('styles')
    <style>
        .gallery-top {
            height: 300px;
            width: 100%;
        }
        @media (min-width: 768px) {
            .gallery-top {
                height: 500px;
            }
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
            text-align: left;
            vertical-align: middle;
        }
        .tour-price-table th {
            background-color: #f9fafb;
            font-weight: bold;
        }
        .prose-styles ul {
            list-style-type: disc;
            padding-left: 20px;
            margin-top: 1em;
            margin-bottom: 1em;
        }
        .prose-styles ol {
            list-style-type: decimal;
            padding-left: 20px;
            margin-top: 1em;
            margin-bottom: 1em;
        }
        .prose-styles p {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
        }
        .prose-styles h1,
        .prose-styles h2,
        .prose-styles h3,
        .prose-styles h4 {
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
                    @include('client.pages.tours.partials._gallery', ['tour' => $tour])
                    @include('client.pages.tours.partials._main_content', ['tour' => $tour])
                </div>

                <aside class="lg:col-span-4">
                    @include('client.pages.tours.partials._sidebar', ['tour' => $tour])
                </aside>
            </div>

            @include('client.pages.tours.partials._related_tours', ['relatedTours' => $relatedTours])
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

            const relatedTourSlider = document.querySelector('.related-tours-slider-container .swiper.tour-slider');
            if(relatedTourSlider) {
                new Swiper(relatedTourSlider, {
                    slidesPerView: 1.15,
                    spaceBetween: 12,
                    navigation: {
                        nextEl: '.related-tours-slider-container .swiper-button-next',
                        prevEl: '.related-tours-slider-container .swiper-button-prev',
                    },
                    breakpoints: {
                        640: { slidesPerView: 2.2, spaceBetween: 16 },
                        768: { slidesPerView: 3, spaceBetween: 16 },
                        1024: { slidesPerView: 4, spaceBetween: 16 },
                    },
                });
            }

            const scheduleItems = document.querySelectorAll('.schedule-item');
            scheduleItems.forEach(item => {
                const content = item.querySelector('.schedule-content');
                const toggle = item.querySelector('.schedule-toggle');
                const icon = item.querySelector('.schedule-icon');

                if (content) {
                    content.style.maxHeight = content.scrollHeight + 'px';
                }
                if (icon) {
                    icon.classList.add('rotate-180');
                }

                if (toggle) {
                    toggle.addEventListener('click', () => {
                        const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';
                        if (isOpen) {
                            content.style.maxHeight = '0px';
                            if (icon) icon.classList.remove('rotate-180');
                        } else {
                            content.style.maxHeight = content.scrollHeight + 'px';
                            if (icon) icon.classList.add('rotate-180');
                        }
                    });
                }
            });
        });
    </script>
@endpush
