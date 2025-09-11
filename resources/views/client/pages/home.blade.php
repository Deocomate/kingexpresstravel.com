@extends('client.layouts.app')

@section('title', 'Trang chủ - King Express Travel')
@section('description', 'Khám phá các tour du lịch hấp dẫn trong và ngoài nước với giá tốt nhất. King Express Travel, đồng hành cùng bạn trên mọi nẻo đường.')

@section('content')
    <section class="relative">
        <div class="swiper main-carousel h-[48vh] md:h-[70vh]">
            <div class="swiper-wrapper">
                @forelse(($banners ?? []) as $bannerUrl)
                    <div class="swiper-slide">
                        <img src="{{ $bannerUrl }}" alt="King Express Travel Banner"
                             class="w-full h-full object-cover">
                    </div>
                @empty
                    <div class="swiper-slide">
                        <img src="https://placehold.co/1920x600/e2e8f0/e2e8f0?text=King+Express"
                             alt="King Express Travel Banner"
                             class="w-full h-full object-cover">
                    </div>
                @endforelse
            </div>
            <div class="main-carousel-nav-btn swiper-button-prev main-carousel-prev"></div>
            <div class="main-carousel-nav-btn swiper-button-next main-carousel-next"></div>
            <div class="swiper-pagination"></div>
        </div>

        <x-client.tour-search-bar variant="overlay"/>
    </section>

    <section class="md:hidden px-4 pt-4 pb-2 bg-gray-50">
        <x-client.tour-search-bar variant="mobile"/>
    </section>

    <div class="after-banner bg-gray-100 pt-6 md:pt-20 md:-mt-14">
        <div class="container mx-auto px-4 py-8 md:py-12 space-y-12">
            @if(!empty($tourCategories) && $tourCategories->isNotEmpty())
                @foreach($tourCategories as $category)
                    @if($category->tours->isNotEmpty())
                        <section>
                            <div class="text-center md:text-left mb-6" data-aos="fade-right">
                                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 uppercase">
                                    {{ $category->name }}
                                </h2>
                                <div class="mt-2 w-24 h-1 bg-[var(--color-primary)] mx-auto md:mx-0"></div>
                            </div>
                            <div class="relative slider-container" data-aos="fade-up" data-aos-delay="150">
                                <div class="swiper tour-slider">
                                    <div class="swiper-wrapper">
                                        @foreach($category->tours as $tour)
                                            <div class="swiper-slide h-auto">
                                                <x-client.tour-card :tour="$tour"/>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="slider-nav-btn swiper-button-prev"></div>
                                <div class="slider-nav-btn swiper-button-next"></div>
                            </div>
                        </section>
                    @endif
                @endforeach
            @endif

            @if(!empty($newsCategories) && $newsCategories->isNotEmpty())
                @foreach($newsCategories as $category)
                    @if($category->news->isNotEmpty())
                        <section>
                            <div class="text-center md:text-left mb-6" data-aos="fade-right">
                                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 uppercase">
                                    {{ $category->name }}
                                </h2>
                                <div class="mt-2 w-24 h-1 bg-[var(--color-primary)] mx-auto md:mx-0"></div>
                            </div>
                            <div class="relative slider-container" data-aos="fade-up" data-aos-delay="150">
                                <div class="swiper news-slider">
                                    <div class="swiper-wrapper">
                                        @foreach($category->news as $newsItem)
                                            <div class="swiper-slide h-auto">
                                                <x-client.news-card :news="$newsItem"/>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="slider-nav-btn swiper-button-prev"></div>
                                <div class="slider-nav-btn swiper-button-next"></div>
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
                <div class="flex items-center p-4 bg-pink-100 rounded-lg" data-aos="zoom-in" data-aos-delay="100">
                    <div class="text-pink-500 mr-4">
                        <i class="fa-solid fa-hotel text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-pink-800">KHÁCH SẠN</h3>
                        <p class="text-sm text-pink-700">Khách sạn tốt nhất tại các địa điểm nổi tiếng.</p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-blue-100 rounded-lg" data-aos="zoom-in" data-aos-delay="200">
                    <div class="text-blue-500 mr-4">
                        <i class="fa-solid fa-car text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-blue-800">THUÊ XE</h3>
                        <p class="text-sm text-blue-700">Dịch vụ thuê xe giá tốt từ các nhà xe uy tín.</p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-green-100 rounded-lg" data-aos="zoom-in" data-aos-delay="300">
                    <div class="text-green-500 mr-4">
                        <i class="fa-solid fa-headset text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-green-800">HỖ TRỢ 24/7</h3>
                        <p class="text-sm text-green-700">Luôn sẵn sàng hỗ trợ bạn mọi lúc mọi nơi.</p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-yellow-100 rounded-lg" data-aos="zoom-in" data-aos-delay="400">
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
        document.addEventListener('DOMContentLoaded', () => {
            new Swiper('.main-carousel', {
                loop: true,
                autoplay: { delay: 5000, disableOnInteraction: false },
                pagination: { el: '.main-carousel .swiper-pagination', clickable: true },
                navigation: {
                    nextEl: '.main-carousel .main-carousel-next',
                    prevEl: '.main-carousel .main-carousel-prev',
                }
            });

            document.querySelectorAll('.slider-container').forEach(container => {
                const s = container.querySelector('.swiper');
                new Swiper(s, {
                    slidesPerView: 1.15,
                    spaceBetween: 12,
                    navigation: {
                        nextEl: container.querySelector('.swiper-button-next'),
                        prevEl: container.querySelector('.swiper-button-prev')
                    },
                    watchOverflow: true,
                    breakpoints: {
                        640: { slidesPerView: 2.2, spaceBetween: 16 },
                        768: { slidesPerView: 3.2, spaceBetween: 16 },
                        1024:{ slidesPerView: 4, spaceBetween: 16 },
                    }
                });
            });
        });
    </script>
@endpush
