@extends('client.layouts.app')

@section('title', 'Trang chủ - King Express Travel')
@section('description', 'Khám phá các tour du lịch hấp dẫn trong và ngoài nước với giá tốt nhất. King Express Travel, đồng hành cùng bạn trên mọi nẻo đường.')

@section('content')
    <section class="relative">
        <div class="swiper main-carousel">
            <div class="swiper-wrapper">
                @if(!empty($banners))
                    @foreach($banners as $bannerUrl)
                        <div class="swiper-slide">
                            <img src="{{ $bannerUrl }}" alt="King Express Travel Banner" class="w-full h-[60vh] object-cover">
                        </div>
                    @endforeach
                @else
                    <div class="swiper-slide">
                        <img src="/userfiles/images/placeholder.jpg" alt="King Express Travel Banner" class="w-full h-[60vh] object-cover">
                    </div>
                @endif
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <div class="bg-gray-100">
        <div class="container mx-auto px-4 py-8 md:py-12 space-y-12">
            @if(isset($tourCategories) && $tourCategories->isNotEmpty())
                @foreach($tourCategories as $category)
                    @if($category->tours->isNotEmpty())
                        <section>
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 uppercase">{{ $category->name }}</h2>
                                <a href="#" class="text-sm font-semibold text-[var(--color-primary)] hover:text-[var(--color-primary-dark)] transition-colors">
                                    Xem tất cả <i class="fa-solid fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                            <div class="relative slider-container">
                                <div class="swiper tour-slider">
                                    <div class="swiper-wrapper">
                                        @foreach($category->tours as $tour)
                                            <div class="swiper-slide">
                                                <x-client.tour-card :tour="$tour"/>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </section>
                    @endif
                @endforeach
            @endif

            @if(isset($newsCategories) && $newsCategories->isNotEmpty())
                @foreach($newsCategories as $category)
                    @if($category->news->isNotEmpty())
                        <section>
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 uppercase">{{ $category->name }}</h2>
                                <a href="#" class="text-sm font-semibold text-[var(--color-primary)] hover:text-[var(--color-primary-dark)] transition-colors">
                                    Xem tất cả <i class="fa-solid fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                            <div class="relative slider-container">
                                <div class="swiper news-slider">
                                    <div class="swiper-wrapper">
                                        @foreach($category->news as $newsItem)
                                            <div class="swiper-slide">
                                                <x-client.news-card :news="$newsItem"/>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </section>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

    <section class="bg-white py-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
                <div class="flex items-center p-4 bg-pink-100 rounded-lg">
                    <div class="text-pink-500 mr-4">
                        <i class="fa-solid fa-hotel text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-pink-800">KHÁCH SẠN</h3>
                        <p class="text-sm text-pink-700">Khách sạn tốt nhất tại các địa điểm nổi tiếng.</p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-blue-100 rounded-lg">
                    <div class="text-blue-500 mr-4">
                        <i class="fa-solid fa-car text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-blue-800">THUÊ XE</h3>
                        <p class="text-sm text-blue-700">Dịch vụ thuê xe giá tốt từ các nhà xe uy tín.</p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-green-100 rounded-lg">
                    <div class="text-green-500 mr-4">
                        <i class="fa-solid fa-headset text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-green-800">HỖ TRỢ 24/7</h3>
                        <p class="text-sm text-green-700">Luôn sẵn sàng hỗ trợ bạn mọi lúc mọi nơi.</p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-yellow-100 rounded-lg">
                    <div class="text-yellow-500 mr-4">
                        <i class="fa-solid fa-thumbs-up text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-yellow-800">GIÁ TỐT NHẤT</h3>
                        <p class="text-sm text-yellow-700">Cam kết mức giá tốt nhất thị trường.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainCarousel = new Swiper('.main-carousel', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.main-carousel .swiper-button-next',
                    prevEl: '.main-carousel .swiper-button-prev',
                },
            });

            document.querySelectorAll('.slider-container').forEach(container => {
                const slider = container.querySelector('.swiper');
                const nextBtn = container.querySelector('.swiper-button-next');
                const prevBtn = container.querySelector('.swiper-button-prev');

                new Swiper(slider, {
                    slidesPerView: 1.2,
                    spaceBetween: 16,
                    navigation: {
                        nextEl: nextBtn,
                        prevEl: prevBtn,
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2.5,
                            spaceBetween: 16,
                        },
                        768: {
                            slidesPerView: 3.5,
                            spaceBetween: 20,
                        },
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 24,
                        },
                    },
                });
            });
        });
    </script>
@endpush
